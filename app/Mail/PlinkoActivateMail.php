<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlinkoActivateMail extends Mailable
{
    use SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->markdown('mails.plinkoActivate')
            ->with('details1', $this->data); // Pass data to view
    }
}
