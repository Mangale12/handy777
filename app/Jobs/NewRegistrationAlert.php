<?php

namespace App\Jobs;

use App\Mail\UserNoticMail;
use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewRegistrationAlert implements ShouldQueue
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
        $settings = GeneralSetting::first();
        $details = [
            'text' => $this->details,
            'theme' => ($settings->theme)
        ];
        if(!empty($settings->new_register_mail)){
            $emails = explode(',',$settings['new_register_mail']);
            foreach($emails as $a){
                Mail::to($a)->send(new UserNoticMail(($details)));
            }
        }
    }
}
