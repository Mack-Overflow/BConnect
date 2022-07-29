<?php

namespace App\Services;

use App\Models\TextMessage;
use App\Models\SentMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 

class CalculateRedemptionAnalyticsService
{
    public static function getOptInRate($bizId=null)
    {
        if ($bizId === null) $bizId = Auth::user()->businessId;
        $optIns = Subscriber::where('businessId', $bizId)->where('subscribed', 1)->count();
        $requests = TextMessage::where('businessId', $bizId)->where('sendToType', 'Opt-In Request')->count();
    }

    public function getOptOutRate()
    {
        $bizId = Auth::user()->businessId;
    }
}