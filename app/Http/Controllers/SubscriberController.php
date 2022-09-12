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
}
