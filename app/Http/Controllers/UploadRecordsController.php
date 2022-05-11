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
        $file_name = $request->uploadFile;
        if (!file_exists($file_name) || !is_readable($file_name))
        {
            return response()->json(['error' => 'Could not read or open provided file']);
        }

        $file_type = pathinfo($file_name);

        if ($file_type["extension"] = "csv") return $this->uploadRecord->uploadCsv($file_name);
    }

}
