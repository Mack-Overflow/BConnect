<?php

namespace App\Http\Controllers;

use Twilio\Twiml;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Models\Webhook;
use App\Services\OptInOutService;
use App\Twilio;

class IncomingSmsController extends Controller
{
    /**
     * Registers a subscriber when they opt-in
     * @param Request $request
     */
    public function register(Request $request)
    {
        $phoneNo = $request->from;
        $message = $request->message;
        $output = $this->createMessage($phoneNo, $message);

        $response = new Twiml();
        $response->message($output);
        return response($response)
            ->header('Content-Type', 'text/xml');
    }

    private function createMessage($phoneNo, $message)
    {
        $sub = Subscriber::where('phoneNumber', $phoneNo)->first();

        if (!$sub)
        {
            // get businessId additionally from recipient phone number
            $sub = new Subscriber;
            $sub->phoneNumber = $phoneNo;
            // $subcriber->businessId = 
            $sub->subscribed = false;

            $sub->save();
        }
        return OptInOutService::generateOutputMessage($sub, $message);
    }

    /**
     * @param Request $request
     * 
     */
    public function receiveSms(Request $request)
    {
        // if (env('APP_ENV') === 'local') return response()->json(['message' => 'This method is not available in local development'], 400);
        // $this->validate($request, $this->rules());
        \Log::info("Incoming SMS\n");
        \Log::info($request);
        $phoneNo = $request['From'];

        $fromSubscriber = Subscriber::where('phoneNumber', $phoneNo)->first();

        // Handle received review invite response if the last message sent to the subscriber was a review invite
        // $rating = ($fromSubscriber->lastMsgSentType === 'Review Invite' && is_int($request['Body'])) ? trim($request['Body'], " \n\t\v\x00") : null;
        // if (is_null($rating)) OptInOutService::handleResponse($request, $fromSubscriber);
        OptInOutService::handleResponse($request, $fromSubscriber);
        // \Log::info($rating);
        // if (in_array($rating, ['1', '2', '3', '4', '5'])) 
        

        return response()->json(["message" => "Received message from $phoneNo"], 200);
    }

    // public function dispatchMessage($webhook, Twilio $twilio)
    // {
    //     $webhook = Webhook::whereIdentifier($webhook)->firstOrFail();

    //     $twilio->notify("+14352224432", $webhook->message);
    // }

    public function deliveryStatus(Request $request)
    {
        //
    }
}
