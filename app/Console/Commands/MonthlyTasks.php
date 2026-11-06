<?php

namespace App\Console\Commands;

use App\Mail\monthlyMail;
use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Form;
use App\Models\FormGame;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\History;


class MonthlyTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MonthlyTasks:cron';

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
        Log::channel('dailyReport')->info("Monthly Task : Reset balance of form table");
        try {
            // Form::query()->update([
            //     'balance' => 0,
            //     'token' => null
            // ]);
            Log::channel('dailyReport')->info("Monthly Task : Balance and Token updated of all forms.");
        } catch (Exception $ex) {
                    Log::channel('dailyReport')->info($ex->getMessage());
        }
        
        
        $limit_amount = 500;
        $history = History::with('account')->with('form')
                            ->whereHas('form')
                            // ->whereBetween('created_at', [Carbon::now()->subMinutes(1440), now()])
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();

        $final = [];
        $forms = [];

        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $totals = [
                    'tip' => 0, 
                    'load' => 0, 
                    'redeem' => 0, 
                    'refer' => 0, 
                    'cashAppLoad' => 0
                ];

                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                if (!empty($form_game))
                {
                    $form = Form::where('id', $b['form_id'])->first();
                    if (!empty($form))
                    {
                        $form_game->toArray();
                        $form->toArray();

                        if (!(isset($final[$b['form_id']])))
                        {
                            $final[$b['form_id']] = [];
                        }
                        $final[$b['form_id']]['form_id'] = $b['form_id'];
                        $final[$b['form_id']]['spinner_key'] = $form['token'];
                        $final[$b['form_id']]['full_name'] = $form['full_name'];
                        $final[$b['form_id']]['number'] = $form['number'];
                        $final[$b['form_id']]['email'] = $form['email'];
                        $final[$b['form_id']]['facebook_name'] = $form['facebook_name'];
                    }

                    // $b['form_game'] = $form_game;
                    if (isset($final[$b['form_id']]['totals']))
                    {
                        $totals['tip'] = $final[$b['form_id']]['totals']['tip'];
                        $totals['load'] = $final[$b['form_id']]['totals']['load'];
                        $totals['redeem'] = $final[$b['form_id']]['totals']['redeem'];
                        $totals['refer'] = $final[$b['form_id']]['totals']['refer'];
                        $totals['cashAppLoad'] = $final[$b['form_id']]['totals']['cashAppLoad'];
                    }

                    ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                    ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);
                    $final[$b['form_id']]['totals'] = $totals;
                    
                }
            }
        }
        $limit = 0;
        $final_redeem = [];
        $final_tip = [];
        if(!empty($final)){
            foreach ($final as $a => $b){
                if($b['totals']['redeem']  >= $limit_amount){
                    array_push($final_redeem,$b);
                }
                if($b['totals']['tip']  >= $limit_amount){
                    array_push($final_tip,$b);
                }
            }
            // dd($final_redeem,$final_tip);
            if(empty($final_redeem)){
                Log::channel('cronLog')->info('Empty Data Today For Mail of Redeem');
            }else{
                $details = [
                    'subject' => 'Total Players this month who redeemed more than '.$limit_amount,
                    'type' => 'redeem',
                    'data' => $final_redeem
                ];                    
                // Mail::to('joshibipin2052@gmail.com')->send(new monthlyMail(json_encode($details)));
                Mail::to('prasundahal6@gmail.com')->send(new monthlyMail(json_encode($details)));
                Log::channel('cronLog')->info('Mail Sent of tip');
            }
            
            if(empty($final_tip)){
                Log::channel('cronLog')->info('Empty Data Today For Mail of Tip');
            }else{
                $details = [
                    'subject' => 'Total Players this month who tipped more than '.$limit_amount,
                    'type' => 'tip',
                    'data' => $final_redeem
                ];                    
                // Mail::to('joshibipin2052@gmail.com')->send(new monthlyMail(json_encode($details)));
                Mail::to('prasundahal6@gmail.com')->send(new monthlyMail(json_encode($details)));
            Log::channel('cronLog')->info('Mail Sent of tip');
                
            }
        }else{
            //empty all data
            Log::channel('cronLog')->info('Empty Data Today For Mail of Redeem & Tip');
        }
        // return 0;
    }
}
