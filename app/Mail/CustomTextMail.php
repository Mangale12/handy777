<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;

class CustomTextMail extends Mailable
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
    public function build()
    {
        $details = json_decode($this->details, true);
        // dd($details);
        $subject = $details['subject'];
        $settings = GeneralSetting::first();
        // $details['theme'] = $settings->theme;

        $title = ($settings->theme == 'default')?'Handy777':ucwords($settings->theme);

        return $this->from('americangamingclub@gmail.com', $title.' Games')
                    ->subject($subject)
                    ->markdown('mails.customMail')
                    ->with([
                        'details' => (!empty($details) ? $details : '') 
                           ]);
    }
}
