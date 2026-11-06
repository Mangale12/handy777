<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewFormOccurred;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        if($payload['type'] == 'charge.succeeded'){
           Notification::route('nexmo', config('services.nexmo.sms_to'))
                        ->notify(new NewFormOccurred($payload));
        }

        return response('Webhook received');
    }
}
