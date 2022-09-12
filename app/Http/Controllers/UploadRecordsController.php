<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\UploadRecordsService;
use App\Models\Subscriber;

class UploadRecordsController extends Controller
{
    protected $uploadRecord;

    public function __construct(UploadRecordsService $uploadRecord)
    {
        $this->uploadRecord = $uploadRecord;
    }

    /**
     * Endpoint: /uploadRecords Name: 
     */
    public function upload(Request $request)
    {
        return $this->uploadRecord->handle($request);
    }

    /**
     * Endpoint: fetch-subscribers
     */
    public function fetch(Request $request)
    {
        Log::info($request);
        $subscribers = Subscriber::where('businessId', $request->businessId)->get();
        return response()->json(['subscriberData' => $subscribers], 201);
    }

}
