<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\TextMessage;

class CreateCampaignService
{
    public function handle(Request $request)
    {
        $msgBody = $request->msgBody;
        $msgUrl = $request->msgUrl;
        $msgHeader = $request->msgHeader;
        // Need to get request's business

        $insertData = [
            'msgUrl' => $msgUrl,
        ];

        try
        {
            $message = TextMessage::create($insertData);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}