<?php

namespace App\Services;

class UploadRecordsService
{
    public function uploadCsv(string $filename)
    {
        try {
            if (($handler = fopen($filename, 'r') != false ))
            {
                return response()->json([
                    'message' => 'Successfully read '.$filename
                ], 200);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}