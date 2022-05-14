<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadRecordsService;

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

}
