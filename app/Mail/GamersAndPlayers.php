<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Form;
use Carbon\Carbon;

class GamersAndPlayers extends Mailable
{
    public $data;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($forms)
    {
        $this->data = $forms;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
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
        // Log::info('filter_start: '.json_encode($filter_start));
        //dd($filter_end, ' ', $filter_start);
        // $history = History::with('form')->get();
        $history = History::with('form')
                            ->whereHas('form')
                            ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
        $spinner_winner = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)]);
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
        // $array = ['prasundahal@gmail.com','bpc0421@gmail.com','Kevgullo1@yahoo.com','christopherbowling43@gmail.com','parksvon30@gmail.com1','lonniecarney42@gmail.com','william23smith@gmail.com','ufoundarida@gmail.com','done4now79@gmail.com','Maeio.Estrada714@Yaboo.com','83hallendorris@gmail.com','leslie.capistran14@gmail.com','candy316kisses@gmail.com','melissafellhauer1@gmail.com','kwgrimet@yahoo.com','manwellc@outlook.com','angelalundy17@gmail.com','tlkaestner@gmail.com','toryphillips93@icloud.com','trinaneedshelp@gmail.com','jwilliams5858@yahoo.comj','iansoto911@gmail.com','robertweiser35@gmail.com','paul.28martin@gmail.com','e.baptiste1985@gmail.com','turnerchris6900@gmail.com','geromettalisa84@gmail.com','larryhirsch.651@gmail.com','ok2open2@icloud.com','marcushawkins56@gmail.com','df482169@gmail.com','poochiebabym@gmail.com','skylitdrop@gmail.com','elizabethcaffee@gmail.com','pricecynthia628@gmail.com','angusnelexia2020@gmail.com','alicia0798@yahoo.com','jivey985@gmail.com','joejoe199613@gmail.com','snaxx83@gmail.com','dion1967m@gmail.com','larryminx70@gmail.com','misskittycat007@gmail.com','angiesmims@yahoo.com','bxsullivan@outlook.com','smiller_28@yahoo.com','tylar352@gmail.com','justabiggun@gmail.com','2811skrappy@gmail.com','cox.terek2.0@gmail.com','desesca10@yahoo.com','lowkeylisag@gmail.com','dede.hulsey@yahoo.com','carol55evans@gmail.com','Reynoldsfrancisca117@gmail.com','lmb6971@gmail.coml','danielweikel5@gmail.com','ladyboss8338@gmail.com','madduxdanielle1@gmail.com','714slugger34@gmail.com','freetobemesince0823@gmail.com','therealeezlup@gmail.com','richiesativa21@gmail.com','liza_waugh@yahoo.com','tamaritkatelynn@gmail.com','thistimewillbethasttime@gmail.com','kmshaven1111@gmail.com','ogcastillo213@gmail.com','emelf11268@gmail.com','rogersallen332@gmail.com','abmarchetti93@gmail.com','wgill440376@gmail.com','crissynuernberg@gmail.com','francesrankin3@gmail.com','savagedriver70@gmail.com','liza.glane@gmail.com','yulanda_abner@yahoo.com'];
        foreach ($final as $a => $b){

            if($a==4){
                $input['email'] = $b['email'];
                $input['name'] = $b['full_name'];
                $input['load'] = $b['totals']['load'];

                $token_id = $b['spinner_key'];
                if($token_id == ''){
                    $token_id = Str::random(32);
                    $form = Form::where('id',$b['form_id'])->update([
                        'token' => $token_id
                    ]);
                }
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
                                // if(!(in_array($input['email'],$array))){
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
                }elseif($type == 'below-'.$limit_amount){
                    // if($b['totals']['load']  <  $limit_amount){
                    //     $form['subject'] = 'Noor Games - Spinner';
                    //     $form['load-remaining'] = $limit_amount - $b['totals']['load'];

                    //     try
                    //     {
                    //         Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                    //         Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].'for type below-'.$limit_amount);
                    //     }
                    //     catch(\Exception $e)
                    //     {
                    //         $bug = $e->getMessage();
                    //         dd($bug);
                    //         Log::channel('spinnerBulk')->info($bug);
                    //     }
                    // }
                }else{
                    // echo '<pre>';
                    // print_r($b['email']);
                    // echo '</pre>';
                    // $limit_1 = $limit_amount - 200;
                    // $limit_2 = $limit_amount;
                    // if($b['totals']['load']  >= $limit_1){
                    //     if($b['totals']['load']  < $limit_2){
                    //         $form['subject'] = 'Noor Games - Almost Eligible For Spinner';
                    //         $form['load-remaining'] = $limit_amount - $b['totals']['load'];

                    //         try
                    //         {
                    //             Mail::to($b['email'])->send(new spinnerBulkMail(json_encode($form)));
                    //             Log::channel('spinnerBulk')->info("Mail sent successfully to ".$b['email'].' for type between-'.$limit_amount);
                    //         }
                    //         catch(\Exception $e)
                    //         {
                    //             $bug = $e->getMessage();
                    //             Log::channel('spinnerBulk')->info($bug);
                    //         }
                    //     }
                    // }
                }
            }


        }
        // $form = [
        //     'name' => 'Prasun Dahal',
        //     'message' => 'Custom Text',
        //     'message-end' => '',
        //     'limit_amount' => $limit_amount,
        //     'load' => 800,
        //     'type' => $type,
        //     'subject' => '',
        //     'token_id' => 'asdfasdfasdfa',
        //     'load-remaining' => 0
        // ];
        // Mail::to('prasundahal@gmail.com')->send(new spinnerBulkMail(json_encode($form)));

        if($spinner_winner->count() <= 0){
            // $history->delete();

            $shuffle = array_rand($final);
            $f1 = Form::where('id',$final[$shuffle]['form_id'])->first();
            $winner = SpinnerWinner::create([
                'form_id' => $final[$shuffle]['form_id'],
                'full_name' => $final[$shuffle]['full_name'],
                'created_at' => $year.'-'.$month.'-15'
            ]);
        }
        $today = Carbon::now();
        $yesterday = $today->subDay();
        $firstDate = $today->subDay()->toDateString();
        $secondDate = $yesterday->subMonth()->toDateString();
        $details = Form::whereBetween('created_at',[$secondDate,$firstDate])->get();
        $load_balance = json_decode($this->data,true);// $details = Form::get();
        $subject = "Forms Details";
        return $this->from('americangamingclub@gmail.com', 'Handy777 Games')
                    ->subject($subject)
                    ->markdown('mails.playersandgamers')
                    ->with(['load_balance'=>$load_balance]);
        // return $this->view('view.name');
    }
}
