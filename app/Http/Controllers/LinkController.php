<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Business;
use App\Models\Subscriber;
use App\Models\TextMessage;
use App\Models\Url;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        // Log::info($request->headers->all());
        Log::info($request->shortUrl);
        $url = Url::where('shortUrl', $request->shortUrl)->first();
        // $text = TextMessage::where('url', $request->shortUrl)
        //     ->whereNotNull('url')
        //     ->first();
        // dd(Subscriber::find(4));
        $subscriber = Subscriber::where('id', $url->subscriberId)->first();
        $subscriber->googleReviewLinksClicked++;
        $subscriber->save();

        $business = Business::find($url->businessId);
        $place_id = $business->google_place_id;
        $external_url = $url->fullUrl.$place_id;
        Log::info($external_url);

        return redirect()->to($external_url)->send();
    }
}
