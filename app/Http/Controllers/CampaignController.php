<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SendToType;
use App\Models\TextMessage;
use App\Services\SmsService;
use App\Http\Requests\SendCampaignRequest;
use App\Http\Requests\SendTextRequest;

class CampaignController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }
    
    /**
     * Endpoint: POST /fetch-campaigns
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
     * Endpoint: GET /fetch-sendToTypes
     */
    public function fetchTypes(Request $request)
    {
        \Log::info($request->businessId);
        try {
            $types = SendToType::get()->toArray();
            // \Log::info($types);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json(['types' => $types], 201);
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
            'url' => $request->msgUrl,
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
            'businessId' => $bizId,
            'sendToType' => $request->sendToType,
            'promoCode' => $request->promoCode,
        ];

        $campaign->update($insertData);
        \Log::info($campaign);
        return response()->json(['updated_campaign' => $campaign], 200);
    }

    /**
     * Endpoint: PUT /send-campaign & /api/send-campaign
     */
    public function send(SendCampaignRequest $request)
    {
        $campId = $request->campaignId;
        return $this->smsService->send($campId);
    }

    /**
     * Endpoint: POST /send-single-text
     * 
     * @param SendTextRequest $request
     * @return JsonResponse
     */
    public function sendSingleText(SendTextRequest $request)
    {   
        return $this->smsService->sendSingleText($request);
    }
}


