<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendInactiveMailToAdmin extends Mailable
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
        $details = json_decode($this->details,true);
        $subject = $details['subject'];
        $title = ($settings->theme == 'default')?'Handy777':ucwords($settings->theme);
        // $details= $subject;
       
        return $this->from('americangamingclub@gmail.com', $title.' Games')
                    ->subject($subject)
                    ->markdown('mails.inactiveMailToAdmin')
                    ->with([
                        'details' => (!empty($details) ? json_encode($details) : '') 
                           ]);
    }
}