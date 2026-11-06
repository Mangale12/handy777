<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;

class crossedPlayers extends Mailable {
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
        $details = json_decode($this->details, true);
        // dd($details['token']);
        $subject = 'Congratulations You are Eligible for Spinner';
        $settings = GeneralSetting::first();

        $title = ($settings->theme == 'default')?'handy77':ucwords($settings->theme);

        return $this->from('admin@test99.caandv.com', $title.' Games')
                    ->subject($subject)
                    ->markdown('mails.exmpl2')
                    ->with([
                        'details' => (!empty($details) ? $details : '') 
                           ]);
    }
}
