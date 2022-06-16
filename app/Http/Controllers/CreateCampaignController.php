<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextMessage;

class CreateCampaignController extends Controller
{
    // protected $createCampaign;

    // public function __construct()
    // {

    // }

    public function index()
    {
        // return "Hello!";
    }

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
