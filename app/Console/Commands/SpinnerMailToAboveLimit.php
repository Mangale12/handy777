<?php

namespace App\Console\Commands;

use App\Mail\spinnerBulkMail;
use App\Models\Form;
use App\Models\GeneralSetting;
use App\Models\History;
use App\Models\SpinnerWinner;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;

class SpinnerMailToAboveLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SpinnerMailToAboveLimit:cron';

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
        $message = $settings['above_limit_text'];
        $type = 'above-'.$limit_amount;


        $year = date('Y');
        $month = date('m');

        if($month != 1){
            $month = $month - 1;
        }else{
            $month = 12;
        }

        $filter_start = $year.'-'.$month.'-01';
        $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-01'));
        
        $history = History::with('form')
                            ->whereHas('form')
                            ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
                            
        //test start here  
        $userData = Form::get()->toArray();
        foreach($userData as $index => $input){
            $form = [
                        'name' => $input['full_name'],
                        'message' => $message,
                        'message-end' => '',
                        'limit_amount' => 600,
                        'load' => 600,
                        'type' => 'above',
                        'subject' => '',
                        'token_id' => $input['token'],
                        'load-remaining' => 0
                    ];
                   
                    $form['subject'] = '🌟 Get Ready to Spin and Win with Our Exclusive Event! 🎉';
                    try
                    {
                        // if(!(in_array($input['email'],$array))){
                        // Mail::to("mangaletamang65@gmail.com")->send(new
                        Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                            Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].' for type above-'.$limit_amount);
                        
                        // }
                    }
                    catch(\Exception $e)
                    {
                        $bug = $e->getMessage();
                        Log::channel('spinnerBulk')->info($bug);
                       
                    }
        }
        dd("successfully send ");
        // $spinner_winner = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)]);
        // $final = [];
        // $forms = [];

        // if (!empty($history))
        // {
        //     foreach ($history as $a => $b)
        //     {
        //         $totals = ['load' => 0];

        //         if (!(isset($final[$b['form_id']])))
        //         {
        //             $final[$b['form_id']] = [];
        //         }
        //         $final[$b['form_id']]['form_id'] = $b['form_id'];
        //         $final[$b['form_id']]['spinner_key'] = $b['form']['token'];
        //         $final[$b['form_id']]['full_name'] = $b['form']['full_name'];
        //         $final[$b['form_id']]['number'] = $b['form']['number'];
        //         $final[$b['form_id']]['email'] = $b['form']['email'];
        //         $final[$b['form_id']]['facebook_name'] = $b['form']['facebook_name'];

        //         if (isset($final[$b['form_id']]['totals']))
        //         {
        //             $totals['load'] = $final[$b['form_id']]['totals']['load'];
        //         }
        //         ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);

        //         $final[$b['form_id']]['totals'] = $totals;

        //     }
        // }
        
        // foreach ($final as $a => $b){

        //     // if($a<=0){
        //         $input['email'] = $b['email'];
        //         $input['name'] = $b['full_name'];
        //         $input['load'] = $b['totals']['load'];

        //         $token_id = $b['spinner_key'];
        //         if($token_id == ''){
        //             $token_id = Str::random(32);
        //             $form = Form::where('id',$b['form_id'])->update([
        //                 'token' => $token_id
        //             ]);
        //         }
        //         $form = [
        //             'name' => $input['name'],
        //             'message' => $message,
        //             'message-end' => '',
        //             'limit_amount' => $limit_amount,
        //             'load' => $input['load'],
        //             'type' => $type,
        //             'subject' => '',
        //             'token_id' => $token_id,
        //             'load-remaining' => 0
        //         ];
        //         $form['subject'] = 'Handy Games - Eligible For Spinner';
        //                 try
        //                     {
        //                         // if(!(in_array($input['email'],$array))){
        //                         // Mail::to($input['email'])->send(new
        //                             Mail::to("mangaletamang65@gmail.com")->send(new spinnerBulkMail(json_encode($form)));
        //                             Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].' for type above-'.$limit_amount);
        //                         dd("success");
        //                         // }
        //                     }
        //                 catch(\Exception $e)
        //                     {
        //                         $bug = $e->getMessage();
        //                         Log::channel('spinnerBulk')->info($bug);
        //                     }

        //         if($type == 'above-'.$limit_amount){

        //             if($b['totals']['load']  >= $limit_amount){
        //                 $form['subject'] = 'Handy Games - Eligible For Spinner';
        //                 try
        //                     {
        //                         // if(!(in_array($input['email'],$array))){
        //                         // Mail::to($input['email'])->send(new
        //                             Mail::to("mangaletamang65@gmail.com")->send(new spinnerBulkMail(json_encode($form)));
        //                             Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].' for type above-'.$limit_amount);
        //                         dd("success");
        //                         // }
        //                     }
        //                 catch(\Exception $e)
        //                     {
        //                         $bug = $e->getMessage();
        //                         Log::channel('spinnerBulk')->info($bug);
        //                     }
        //             }
        //         }
        // }
        
        // if($spinner_winner->count() <= 0){
        //     // $history->delete();

        //     $shuffle = array_rand($final);
        //     $f1 = Form::where('id',$final[$shuffle]['form_id'])->first();
        //     $winner = SpinnerWinner::create([
        //         'form_id' => $final[$shuffle]['form_id'],
        //         'full_name' => $final[$shuffle]['full_name'],
        //         'created_at' => $year.'-'.$month.'-15'
        //     ]);
        // }

    }
}
