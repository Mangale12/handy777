<?php

namespace App\Console\Commands;

use App\Mail\InactiveBulkMail;
use App\Mail\sendInactiveMailToAdmin;
use App\Models\Form;
use App\Models\FormBalance;
use App\Models\FormGame;
use App\Models\GeneralSetting;
use App\Models\Unsubmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InactiveMailToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'InactiveMailToAdmin:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'InactiveMailToAdmin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $setting = GeneralSetting::first();

        $days = [7, 10, 20];
        $users = FormGame::select('form_id')->distinct()->get()->toArray();
        foreach ($days as $a => $day) {
            $balance = FormBalance::select('form_id')->where('created_at', '>', Carbon::now()->subDays($day))
                ->distinct()
                ->get()
                ->toArray();
            $differenceArray = self::multi_array_diff($users, $balance);
            $array = array_column($differenceArray, 'form_id');
            $forms = Form::whereIn('id', $array)->get()->toArray();
            $details = [
                'forms' => $forms,
                'subject' => 'Inactive Players since '.$day.' days',
                'theme' => $setting->theme
            ];
            // Log::channel('inactiveMail')->info($details);
            try {
                if (!empty($setting->emails)) {
                    $emails = explode(',', $setting->emails);
                    foreach ($emails as $a) {
                        Mail::to($a)->send(new sendInactiveMailToAdmin(json_encode($details)));
                        Log::channel('inactiveMail')->info("Inactive Mail Report sent to " . $a);
                    }
                } else {
                    Log::channel('inactiveMail')->info("Admin Emails Empty");
                }
            } catch (\Exception $ex) {
                Log::channel('inactiveMail')->info($ex->getMessage());
            }
        }
    }
    function multi_array_diff($arraya, $arrayb)
    {
        foreach ($arraya as $keya => $valuea) {
            if (in_array($valuea, $arrayb)) {
                unset($arraya[$keya]);
            }
        }
        return $arraya;
    }
}
