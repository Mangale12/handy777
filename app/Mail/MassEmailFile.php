<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MassEmailFile extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $attachmentPath = asset('public/files/handy.csv');
        //  return $this->from('filesend@handy777.net')->view('mails.ecxel_mail')
        //     ->subject('Mass Excell file')
        //     ->attach($attachmentPath, [
        //         'as' => 'attachment-file.pdf',
        //     ]);
        //$app_name = json_decode($this->data, true);
            // dd("yeyye");
            return $this->from('americangamingclub@gmail.com', $this->data['app_name'])
                    ->subject($this->data['subject'])
                    ->markdown('mails.video_template')
                    ->with(['data'=>$this->data]);        
    }
}
