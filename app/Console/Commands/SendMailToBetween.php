<?php

namespace App\Console\Commands;

use App\Mail\spinnerBulkMail;
use App\Models\GeneralSetting;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailToBetween extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendMailToBetween:cron';

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
       
        $settings = GeneralSetting::first()->toArray();
        $limit_amount = $settings['limit_amount'];
        $message = json_decode($settings['between_limit_text'],true);//$settings['between_limit_text'];        
        $type = 'between-';
        

        $year = date('Y');
        $month = date('m');

        $filter_start = $year.'-'.$month.'-01';
        $filter_end = Carbon::now();
        // Log::info('filter_start: '.json_encode($filter_start));

        $history = History::with('form')
                            ->whereHas('form')
                            ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();

        $final = [];
        $forms = [];

        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $totals = ['load' => 0];

                if (!(isset($final[$b['form_id']])))
                {
                    $final[$b['form_id']] = [];
                }
                $final[$b['form_id']]['form_id'] = $b['form_id'];
                $final[$b['form_id']]['spinner_key'] = $b['form']['token'];
                $final[$b['form_id']]['full_name'] = $b['form']['full_name'];
                $final[$b['form_id']]['number'] = $b['form']['number'];
                $final[$b['form_id']]['email'] = $b['form']['email'];
                $final[$b['form_id']]['facebook_name'] = $b['form']['facebook_name'];

                if (isset($final[$b['form_id']]['totals']))
                {
                    $totals['load'] = $final[$b['form_id']]['totals']['load'];
                }
                ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);

                $final[$b['form_id']]['totals'] = $totals;     
                
            }
        }
        // echo '<pre>';
        // print_r($final);
        // echo '</pre>';
        foreach ($final as $a => $b){
                $input['email'] = $b['email'];
                $input['name'] = $b['full_name'];
                $input['load'] = $b['totals']['load'];

                $token_id = $b['spinner_key'];
                $form = [
                    'name' => $input['name'],
                    'message' => $message,
                    'message-end' => '',
                    'limit_amount' => $limit_amount,
                    'load' => $input['load'],
                    'type' => $type,
                    'subject' => '',
                    'token_id' => $token_id,
                    'load-remaining' => 0
                ];

                if($type == 'above-'.$limit_amount){
                
                    if($b['totals']['load']  >= $limit_amount){
                        $form['subject'] = 'Noor Games - Eligible For Spinner';
                        try
                            {
                                Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].'for type above-'.$limit_amount);
                            }
                        catch(\Exception $e)
                            {
                                $bug = $e->getMessage();
                                dd($bug);
                                Log::channel('spinnerBulk')->info($bug);
                            }
                    }
                }elseif($type == 'below-'.$limit_amount){
                    if($b['totals']['load']  <  $limit_amount){
                        $form['subject'] = 'Noor Games - Spinner';           
                        $form['load-remaining'] = $limit_amount - $b['totals']['load'];

                        try
                        {
                            Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                            Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].'for type below-'.$limit_amount);
                        }
                        catch(\Exception $e)
                        {
                            $bug = $e->getMessage();
                            dd($bug);
                            Log::channel('spinnerBulk')->info($bug);
                        }
                    }
                }else{
                    // echo '<pre>';
                    // print_r($b['email']);
                    // echo '</pre>';
                    $limit_1 = $limit_amount - 200;
                    $limit_2 = $limit_amount;
                    if($b['totals']['load']  >= $limit_1){
                        if($b['totals']['load']  < $limit_2){  
                            $form['subject'] = 'Noor Games - Almost Eligible For Spinner';                    
                            $form['load-remaining'] = $limit_amount - $b['totals']['load'];
                            
                            try
                            {
                                Mail::to($b['email'])->send(new spinnerBulkMail(json_encode($form)));
                                Log::channel('spinnerBulk')->info("Mail sent successfully to ".$b['email'].' for type between-'.$limit_amount);
                            }
                            catch(\Exception $e)
                            {
                                $bug = $e->getMessage();
                                Log::channel('spinnerBulk')->info($bug);
                            }
                        }
                    }
                }
        }
        
    }
}
