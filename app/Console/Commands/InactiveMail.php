<?php

namespace App\Console\Commands;

use App\Mail\InactiveBulkMail;
use App\Models\Form;
use App\Models\FormBalance;
use App\Models\FormGame;
use App\Models\GeneralSetting;
use App\Models\Unsubmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InactiveMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'InactiveMail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'InactiveMail';

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
        
        $days = 7;
        $users = FormGame::select('form_id')->distinct()->get()->toArray();
        $balance = FormBalance::select('form_id')->where('created_at', '>', Carbon::now()->subDays($days))
                                ->distinct()
                                ->get()
                                ->toArray();
        $differenceArray = self::multi_array_diff($users, $balance);
        $array = array_column($differenceArray, 'form_id');
        // $forms = Form::whereIn('id', [5,7])->get();
        $forms = Form::whereIn('id', $array)->get();
        foreach($forms as $key => $form){            
            $data = [
                'days' => $days,
                'message' => $setting->inactive_mail_message,
                'subject' => 'Inactive Notification',
                'name' => $form->full_name,
                'form_id' => $form->id,
                'form_email' => $form->email,
            ];
            try {
                Mail::to($form->email)->send(new InactiveBulkMail(json_encode($data)));
                Log::channel('inactiveMail')->info("Inactive Mail sent successfully to ".$form->email);
            } catch (\Exception $ex) {
                Log::channel('inactiveMail')->info($ex->getMessage());
            }
            //save log
            Unsubmail::create([
                'form_id' => $form->id,
                'full_name' => $form->full_name,
                'email' => $form->email,
                'days' => $days
            ]);
            // Log::channel('inactiveMail')->info("Inactive Mail sent successfully to ");
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
