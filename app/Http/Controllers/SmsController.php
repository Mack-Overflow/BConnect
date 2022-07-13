<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextMessage;
use App\Services\SmsService;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public static function index(Request $request)
    {
        $message = $request->body;
        $header = $request->header;
        $sendToType = $request->sendToType;

        $this->smsService->send($header, $message, $sendToType);
    }
        
    // public function send(Request $request)
    // {
    //     $body = $request->body;
    //     $senderNo = env('TWILIO_SENDER_NO');

    //     $recipientNo = $request->recipient;
    //     $meta = array(
    //         'from' => $senderNo,
    //         'body' => $body
    //     );

    //     SmsService::send($recipientNo, $meta);
    // }



    // public function sendFromCampaign(Request $request)
    // {
    //     $campaignId = $request->campaignId;
    //     $text = TextMessage::where('id', $campaignId)->get();
    //     \Log::info($text);
    // }
}
