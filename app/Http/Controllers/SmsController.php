<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextMessage;
use App\Services\SmsService;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    public static function index(mixed $message)
    {
        $recipientNo = "+14352224432";

        try {
            $account_id = getenv('TWILIO_SID');
            $auth_tok = getenv('TWILIO_TOKEN');
            $twilio_num = getenv('TWILIO_FROM');

            $client = new Client($account_id, $auth_tok);
            $client->messages->create($recipientNo, [
                'from' => $twilio_num,
                'body' => $message
            ]);

            return response()->json(['message' => 'Successfully sent message']);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
        
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



    public function sendFromCampaign(Request $request)
    {
        $campaignId = $request->campaignId;
        $text = TextMessage::where('id', $campaignId)->get();
        \Log::info($text);
    }
}
