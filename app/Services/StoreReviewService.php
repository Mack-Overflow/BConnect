<?php

namespace App\Services;

use Illuminate\Http\Request;

class StoreReviewService
{
    public function store(Request $request)
    {   
        $reviewerName = '';

        return [
            'rating' => $request->rating,
            'reviewBody' => $request->reviewBody,
            'customerName' => $reviewerName,
        ];
    }

    public static function getReviewerName()
    {
        //
    }
}