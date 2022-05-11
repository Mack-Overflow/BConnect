<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService; 

class SmsController extends Controller
{
    public function send(Request $request)
    {
        $body = $request->body;
        $senderNo = env('TWILIO_SENDER_NO');

        $recipientNo = $request->recipient;
        $meta = array(
            'from' => $senderNo,
            'body' => $body
        );

        SmsService::send($recipientNo, $meta);
    }
}
