<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     */
    public function __construct(array $details) // pass array directly
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = 'Users Updated List';

        $settings = GeneralSetting::first();
        $title = ($settings && $settings->theme == 'default') 
            ? 'Handy777' 
            : ucwords($settings->theme ?? 'Handy');

        return $this
                    ->subject($subject)
                    ->markdown('mails.exmpl')
                    ->with([
                        'details' => $this->details // already array
                    ]);
    }
}
