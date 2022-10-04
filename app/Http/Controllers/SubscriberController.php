<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Endpoint GET /api/fetch-subscriber
     * 
     * @param Request $request
     * @return reponse()->json()
     */
    public function retrieve(Request $request)
    {

        // $subscriber = Subscriber::find($request->phoneNumber);
        \Log::info($request->user());
        $subscriber = Subscriber::where('phoneNumber', $request->phoneNumber)->first();
        \Log::info($subscriber);
        return response()->json(['subscriber' => $subscriber], 201);
    }

    /**
     * Endpoint POST /api/create-subscriber
     */
    public function store(Request $request)
    {
        try {
            $insertData = [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'visitDate' => $request->visitDate,
                'phoneNumber' => $request->phoneNumber,
                'businessId' => $request->businessId,
                // 'googleReviewLinksClicked' => 0,
                'lastMsgSentType' => 'Uncontacted',
            ];
            $subscriber = Subscriber::firstOrCreate($insertData);

            return response()->json(['subscriber' => $subscriber], 201);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Endpoint PUT /api/update-subscriber
     * 
     * @param Request $request
     * @return Response()->json()
     */
    public function update(Request $request)
    {
        $subId = $request->subscriberId;

    }
}
