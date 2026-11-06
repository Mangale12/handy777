<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendMailToWinner extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details) {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $settings = GeneralSetting::first();
        $details = $this->details;
        $subject = 'Congratulations !! You have won !!';
        $title = ($settings->theme == 'default')?'Handy777':ucwords($settings->theme);
        // $details= $subject;
       
        return $this->from('americangamingclub@gmail.com', $title.' Games')
                    ->subject($subject)
                    ->markdown('mails.sendMailToWinner')
                    ->with([
                        'details' => (!empty($details) ? $details : '') 
                           ]);
    }
}