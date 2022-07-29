<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextMessage;
use App\Services\SmsService;
use App\Http\Requests\SendCampaignRequest;

class CampaignController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }
    
    /**
     * Endpoint: /fetch-campaigns
     */
    public function fetch(Request $request)
    {
        $biz_id = $request->businessId;
        // \Log::info($biz_id);
        $campaigns = TextMessage::where('businessId', $biz_id)->get();
        // \Log::info($campaigns);
        return response()->json(['campaigns' => $campaigns], 201);
    }

    /**
     * Endpoint: /createCampaign
     * 
     * The URL will have a shortened URL generated when the message is sent
     */
    public function create(Request $request)
    {
        $insertData = [
            'header' => $request->msgHeader,
            'body' => $request->msgBody,
            'url' => 'https://'.$request->msgUrl,
            'businessId' => $request->businessId,
            'sendToType' => $request->sendToType,
            'promoCode' => $request->promoCode,
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
    
    /**
     * Endpoint: POST /update-campaign
     */
    public function update(Request $request)
    {
        $cmpId = $request->id;
        $bizId = $request->businessId;
        $campaign = TextMessage::find($cmpId);

        $insertData = [
            'header' => $request->msgHeader,
            'body' => $request->msgBody,
            'url' => $request->msgUrl,
            'businessId' => $request->businessId,
            'sendToType' => $request->sendToType,
            'promoCode' => $request->promoCode,
        ];

        $campaign->update($insertData);
        \Log::info($campaign);
        return response()->json(['updated_campaign' => $campaign], 200);
    }

    /**
     * Endpoint: POST /send-campaign
     */
    public function send(SendCampaignRequest $request)
    {
        // $msgToSend = $request->message;

        $message = $request->body;
        $header = $request->header;
        $sendToTypes = $request->sendToType;
        $url = $request->url;
        $body = $request->body;
        // $promoCode = $request->promoCode;

        return $this->smsService->send($header, $body, $sendToTypes, $url);
    }
}
