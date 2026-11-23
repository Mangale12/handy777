<?php

namespace App\Mail;

use App\Models\ChatEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChatAccessCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $chatEmail;

    public function __construct(ChatEmail $chatEmail)
    {
        $this->chatEmail = $chatEmail;
    }

    public function build()
    {
        return $this
            ->subject('Your support chat code')
            ->view('mails.chat_access_code');
    }
}
