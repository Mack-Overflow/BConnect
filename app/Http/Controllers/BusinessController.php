<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    /**
     * Endpoint: GET /api/fetch-business/businessId
     */
    public function fetchOne(Request $request)
    {
        \Log::info($request->businessId);
        try {
            $bizId = intval($request->businessId);

            $business = Business::find($bizId);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        
        return response()->json(['business' => $business], 201);
    }
}
