<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\TextMessage;
use App\Services\GenerateReviewUrlService;

class CreateCampaignService
{
    protected $genUrlService;

    public function __construct(GenerateReviewUrlService $urlService)
    {
        $this->genUrlService = $urlService;
    }

    public function handle(Request $request)
    {
        $msgBody = $request->msgBody;
        $msgUrl = $request->msgUrl;
        $msgHeader = $request->msgHeader;
        // $sendToTypes = json_encode($request->sendToTypes);
        // $businessId = $request->businessId;

        $shortened_url = $this->urlService->generate();

        $insertData = [
            'msgUrl' => $msgUrl,
            'msgHeader' => $msgHeader,
            'msgBody' => $msgBody,
            // 'sendToTypes' => $sendToTypes,
            // 'businessId' => $businessId,
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