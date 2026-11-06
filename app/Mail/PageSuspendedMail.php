<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PageSuspendedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $newPageUrl;
    public $whatsapp;
    public $whatsappLink;

    public function __construct(
        $customerName,
        $newPageUrl = 'https://www.facebook.com/share/1E3rfypCod/',
        $whatsapp = '+1 (334) 820-4628'
    ) {
        $this->customerName = trim($customerName) !== '' ? trim($customerName) : 'Valued Customer';
        $this->newPageUrl   = $newPageUrl;
        $this->whatsapp     = $whatsapp;
        $this->whatsappLink = 'https://wa.me/' . preg_replace('/\D/', '', $whatsapp);
    }

    public function build()
    {
        return $this->from('americangamingclub@gmail.com', 'Emmy Club')
                    ->subject("{$this->customerName}, our AB page has moved")
                    ->view('mails.page-suspended');
    }
}