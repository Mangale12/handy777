<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\GeneralSetting;
use App\Mail\CustomMail;

class ColabUpdate extends Command
{
    protected $signature = 'colabUpdate:cron';
    protected $description = 'Update form intervals and send weekly performance report';

    public function handle()
    {
        Log::channel('cronLog')->info('Started ColabUpdate command');

        try {

            /* ============================================================
             | DATE RANGE — LAST 7 FULL DAYS (TILL YESTERDAY)
             ============================================================ */
            $startDate = Carbon::now()->subDays(7)->startOfDay();
            $endDate   = Carbon::yesterday()->endOfDay();

            /* ============================================================
             | FETCH FORMS + REPORT DATA
             ============================================================ */
            $formsToday = DB::table('forms')
                ->select([
                    'forms.id',
                    'forms.full_name',
                    'forms.email',
                    'forms.balance',
                    'forms.intervals',
                    'forms.facebook_name',
                    'forms.game_id',

                    /* ---------- 7 DAY TOTALS ---------- */
                    DB::raw('COALESCE(SUM(
                        CASE 
                            WHEN histories.type = "load"
                            AND histories.created_at BETWEEN ? AND ?
                            THEN histories.amount_loaded
                            ELSE 0
                        END
                    ), 0) AS total_load_7d'),

                    DB::raw('COALESCE(SUM(
                        CASE 
                            WHEN histories.type = "redeem"
                            AND histories.created_at BETWEEN ? AND ?
                            THEN histories.amount_loaded
                            ELSE 0
                        END
                    ), 0) AS total_redeem_7d'),

                    DB::raw('COALESCE(SUM(
                        CASE 
                            WHEN histories.type = "tip"
                            AND histories.created_at BETWEEN ? AND ?
                            THEN histories.amount_loaded
                            ELSE 0
                        END
                    ), 0) AS total_tip_7d'),

                    /* ---------- LAST ACTIVITY (ALL TIME) ---------- */
                    DB::raw('MAX(CASE WHEN histories.type = "load" THEN histories.created_at END) AS last_load_at'),
                    DB::raw('MAX(CASE WHEN histories.type = "redeem" THEN histories.created_at END) AS last_redeem_at'),
                    DB::raw('MAX(CASE WHEN histories.type = "tip" THEN histories.created_at END) AS last_tip_at'),
                ])
                ->leftJoin('histories', 'histories.form_id', '=', 'forms.id')

                /* ---------- INTERVAL LOGIC (CRON SAFE) ---------- */
                ->whereDate('forms.intervals', '<=', Carbon::today())

                ->setBindings([
                    $startDate, $endDate, // load
                    $startDate, $endDate, // redeem
                    $startDate, $endDate, // tip
                ], 'select')

                ->groupBy(
                    'forms.id',
                    'forms.full_name',
                    'forms.email',
                    'forms.balance',
                    'forms.intervals',
                    'forms.facebook_name',
                    'forms.game_id'
                )
                ->having('total_load_7d', '>', 0)

                ->get();

            Log::channel('cronLog')->info("Found {$formsToday->count()} forms to process.");

            /* ============================================================
             | UPDATE INTERVALS
             ============================================================ */
            foreach ($formsToday as $form) {
                DB::table('forms')
                    ->where('id', $form->id)
                    ->update([
                        'count'     => DB::raw('count + 1'),
                        'intervals' => Carbon::today()->addDays(7),
                    ]);

                Log::channel('cronLog')->info("Updated intervals for {$form->full_name}");
            }

            /* ============================================================
             | EMAIL REPORT
             ============================================================ */
            $settings = GeneralSetting::first();
            if (!$settings) {
                Log::channel('cronLog')->error('GeneralSetting not found.');
                return Command::FAILURE;
            }

            $data = [
                'forms'               => $formsToday,
                'theme'               => $settings->theme,
                'total_forms_updated' => $formsToday->count(),
                'run_date'            => Carbon::now()->format('Y-m-d H:i:s'),
                'report_start_date'   => $startDate->format('Y-m-d H:i:s'),
                'report_end_date'     => $endDate->format('Y-m-d H:i:s'),
                'report_period'       => $startDate->format('M j') . ' – ' . $endDate->format('M j, Y'),
            ];

            $emails = array_filter(array_map('trim', explode(',', (string) $settings->bonus_report_emails)));
            $testEmails = ['redninoteat@gmail.com', 'mangaletamang65@gmail.com'];
            $allEmails = array_unique(array_merge($testEmails, $emails));

            foreach ($allEmails as $email) {
                try {
                    Mail::to($email)->send(new CustomMail($data));
                    Log::channel('cronLog')->info("Report sent to {$email}");
                } catch (\Throwable $e) {
                    Log::channel('cronLog')->error("Mail failed for {$email}: {$e->getMessage()}");
                }
            }

        } catch (\Throwable $e) {
            Log::channel('cronLog')->error('ColabUpdate failed: ' . $e->getMessage());
            Log::channel('cronLog')->error($e->getTraceAsString());
            return Command::FAILURE;
        }

        Log::channel('cronLog')->info('Finished ColabUpdate successfully');
        return Command::SUCCESS;
    }
}
