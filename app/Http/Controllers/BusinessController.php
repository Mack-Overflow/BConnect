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
        \Log::info($request->businessName);
        $bizName = $request->businessName;

        $business = Business::where('business_name', $bizName)->first();
        return response()->json(['business' => $business], 201);
    }
}
