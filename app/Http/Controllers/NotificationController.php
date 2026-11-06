<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendSmsNotificaition()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("e20bd554", "M5arJoXIrJ8Kat1r");
        $client = new \Vonage\Client($basic);



        $message = $client->message()->send([
            'to' => '16179389095',
            'from' => '18337222376',
            'text' => 'Congrats!!! :partying_face: </br>We have received your info. Based on the date you joined we send you $20 on game monthly for active customers. </br>Happy playing :)'
        ]);


        dd('SMS message has been delivered.');
    }


    public function sendSms()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("e20bd554", "M5arJoXIrJ8Kat1r");
        $client = new \Vonage\Client($basic);



        $message = $client->message()->send([
            'to' => '16179389095',
            'from' => '18337222376',
            'text' => 'Congrats!!! :partying_face: </br>We have received your info. Based on the date you joined we send you $20 on game monthly for active customers. </br>Happy playing :)'
        ]);


        dd('SMS message has been delivered.');
    }
}
