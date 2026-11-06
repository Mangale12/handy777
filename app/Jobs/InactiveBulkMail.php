<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\InactiveBulkMail as MailInactiveBulkMail;
use App\Models\Form;
use App\Models\FormBalance;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\FormGame;
use App\Models\Unsubmail;

class InactiveBulkMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $days = $this->details['days'];
        $message = $this->details['message'];
        $subject = $this->details['subject'];
        
        $users = FormGame::select('form_id')->distinct()->get()->toArray();

        $balance = FormBalance::select('form_id')->where('created_at', '>', Carbon::now()->subDays($days))->distinct()->get()->toArray();

        $differenceArray = self::multi_array_diff($users, $balance);
        $array = array_column($differenceArray, 'form_id');
        // Log::channel('cronLog')->info($differenceArray);
        $forms = Form::whereIn('id', $array)->get();
        

        if($forms->isEmpty()){
            Log::channel('cronLog')->info('List Empty');
        }else{
            foreach($forms as $a => $form){
                try
                    {
                        $data = [
                            'days' => $days,
                            'message' => $message,
                            'subject' => $subject,
                            'name' => $form->full_name,
                            'form_id' => $form->id,
                            'form_email' => $form->email,
                        ];
                        // $data['name'] = $form->full_name;
                        // $data['form_id'] = ($form->id);
                        Mail::to($form->email)->send(new MailInactiveBulkMail(json_encode($data)));

                        //save log
                        Unsubmail::create([
                            'form_id' => $form->id,
                            'full_name' => $form->full_name,
                            'email' => $form->email,
                            'days' => $days
                        ]);
                        Log::channel('cronLog')->info("Mail sent successfully to ".$form->email);
                }
                catch(\Exception $e)
                {
                    $bug = $e->getMessage();
                    Log::channel('cronLog')->info($bug);
                }

            }
        }

    }
    
    function multi_array_diff($arraya, $arrayb)
    {
        foreach ($arraya as $keya => $valuea)
        {
            if (in_array($valuea, $arrayb))
            {
                unset($arraya[$keya]);
            }
        }
        return $arraya;
    }
}
