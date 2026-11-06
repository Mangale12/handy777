<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Form;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\customMail;
use App\Mail\ReportMail;

use App\Models\FormGame;
use App\Models\FormNumber;
use App\Models\Account;
use App\Models\History;
use App\Models\CashApp;
use App\Models\CashAppForm;
use App\Models\FormTip;
use App\Models\FormRefer;
use App\Models\FormBalance;
use App\Models\FormRedeem;
use App\Models\GeneralSetting;

class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyReport:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Log::channel('dailyReport')->info("Reached command dailyReport");

        $history = History::with('form')->whereHas('form')
            ->with('account')
            ->whereHas('account')
            ->whereBetween('created_at', [Carbon::now()->subMinutes(1440), now()])
            // ->with('created_by')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        $final = [];
        $forms = [];

        if (!empty($history)) {
            $totals = [
                'tip' => 0,
                'load' => 0,
                'redeem' => 0,
                'refer' => 0,
                'cashAppLoad' => 0
            ];
            foreach ($history as $a => $b) {
                if (!isset($final[$b['account_id']])) {
                    $final[$b['account_id']]['game_name'] = $b['account']['name'];
                    $final[$b['account_id']]['game_title'] = $b['account']['title'];
                    $final[$b['account_id']]['game_balance'] = $b['account']['balance'];
                    $final[$b['account_id']]['histories'] = [];
                    $final[$b['account_id']]['totals'] = $totals;
                    $final[$b['account_id']]['total_transactions'] = 0;
                }

                ($b['type'] == 'tip') ? ($final[$b['account_id']]['totals']['tip'] = $final[$b['account_id']]['totals']['tip'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['tip'] = $final[$b['account_id']]['totals']['tip']);
                ($b['type'] == 'load') ? ($final[$b['account_id']]['totals']['load'] = $final[$b['account_id']]['totals']['load'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['load'] = $final[$b['account_id']]['totals']['load']);
                ($b['type'] == 'redeem') ? ($final[$b['account_id']]['totals']['redeem'] = $final[$b['account_id']]['totals']['redeem'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['redeem'] = $final[$b['account_id']]['totals']['redeem']);
                ($b['type'] == 'refer') ? ($final[$b['account_id']]['totals']['refer'] = $final[$b['account_id']]['totals']['refer'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['refer'] = $final[$b['account_id']]['totals']['refer']);
                ($b['type'] == 'cashAppLoad') ? ($final[$b['account_id']]['totals']['cashAppLoad'] = $final[$b['account_id']]['totals']['cashAppLoad'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['cashAppLoad'] = $final[$b['account_id']]['totals']['cashAppLoad']);
                $final[$b['account_id']]['total_transactions'] = $final[$b['account_id']]['total_transactions'] + 1;
                array_push($final[$b['account_id']]['histories'], $b);
            }
        }
        else{
            Log::channel('dailyReport')->info("dailyReport : History is empty");
        }
        // Log::channel('dailyReport')->info("Reached Command");
        
        $details = $final;
        try {
             $settings = GeneralSetting::first()->toArray();
            if(!empty($settings['emails'])){
                $emails = explode(',',$settings['emails']);
                foreach($emails as $a){
                    Mail::to($a)->send(new reportMail(json_encode($details)));
                    Log::channel('dailyReport')->info("Daily Report Mail sent successfully to ".$a);
                }
            }else{
                Log::channel('dailyReport')->info("Empty Today");
            }
            //         Mail::to('russelcraigspencer@gmail.com')->send(new customMail(json_encode($formData)));
            //         Mail::to('prasundahal@gmail.com')->send(new customMail(json_encode($formData)));
            //         Mail::to('slimnoor96@gmail.com')->send(new customMail(json_encode($formData)));
            // Mail::to('joshibipin2052@gmail.com')->send(new reportMail(json_encode($details)));
            // Log::channel('dailyReport')->info("Mail sent successfully to russelcraigspencer@gmail.com, slimnoor96@gmail.com");
        } catch (Exception $ex) {
            Log::channel('dailyReport')->info($ex->getMessage());
        }


        // return 0;
    }
}
