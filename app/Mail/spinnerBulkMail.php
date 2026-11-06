<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;

class spinnerBulkMail extends Mailable {
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
        $details1 = [
            'text' => json_decode($this->details,true),
            'theme' => $settings->theme
        ];
      
        $subject = isset($this->details['subject'])?$this->details['subject']:'🌟 Get Ready to Spin and Win with Our Exclusive Event! 🎉';

        $title = ("Emmy Games");

        return $this->from('americangamingclub@gmail.com', $title.' Games')
                    ->subject($subject)
                    ->markdown('mails.spinnerBulkMessage')
                    ->with([
                        'details1' => (!empty($details1) ? $details1 : '') 
                           ]);
    }
}
