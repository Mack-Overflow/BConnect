<?php

namespace App\Services;

use Twilio\Rest\Client;



class SmsService
{
    public Client $client;

    public static function create() : Client
    {
        $twilSid = env('TWILIO_SENDER_NO');
        $twilToken = env('TWILIO_AUTH_TOKEN');

        $client = new Client($twilSid, $twilToken);
        return $client;
    }

    public static function send(string $recipientNo, mixed $meta) 
    {
        // $recipientNo = env('TWILIO_PHONE_NO');
        try 
        {
            $client->messages->create(
                $senderNo,
                $meta
            );
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 400]);
        }
        
    }

    public function get()
    {
        //
    }

    public function read()
    {
        //
    }
}