<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    /**
     * Endpoint: GET /api/fetch-business/{businessName}
     */
    public function fetchOne(Request $request)
    {
        \Log::info($request->businessId);
        $bizId = $request->businessId;

        $business = Business::find('business_name', $bizId);
        return response()->json(['business' => $business], 201);
    }
}
