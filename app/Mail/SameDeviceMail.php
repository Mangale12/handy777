<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;
class SameDeviceMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = $this->details;
        $subject = 'Same Device Registration';
        //$details= $subject;
        //dd($details,$subject);
        $settings = GeneralSetting::first();
       $title = ($settings->theme == 'default')?'Handy':ucwords($settings->theme);

        // return $this->from('noorgames@gmail.com', 'Noor Games')
        return $this->from('americangamingclub@gmail.com', $title.' Games')
                    ->subject($subject)
                    ->markdown('mails.same_device_alert')
                    ->with([
                        'details' => (!empty($details) ? $details : '') 
                           ]);
    }
}
