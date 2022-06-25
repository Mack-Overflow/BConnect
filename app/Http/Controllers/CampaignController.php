<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextMessage;

class CampaignController extends Controller
{
    // protected $createCampaign;

    // public function __construct()
    // {

    // }
    
    /**
     * Endpoint: /fetch-campaigns
     */
    public function fetch(Request $request)
    {
        $biz_id = $request->businessId;
        \Log::info($biz_id);
        $campaigns = TextMessage::where('businessId', $biz_id)->get();
        \Log::info($campaigns);
        return response()->json(['campaigns' => $campaigns], 201);
    }

    /**
     * Endpoint: createCampaign
     */
    public function create(Request $request)
    {
        $insertData = [
            'header' => $request->msgHeader,
            'body' => $request->msgBody,
            'url' => $request->msgUrl,
            'businessId' => $request->businessId,
            'sendToType' => $request->sendToType,
        ];

        \Log::info($insertData);

        try {
            TextMessage::create($insertData);
            return response()->json(['message' => 'Successfully created message'], 201);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        
        // \Log::info($request);
    }
}
