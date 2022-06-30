<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StoreReviewService;
use App\Models\Review;

class ReviewController extends Controller
{
    protected $storeReviewService;

    public function __construct(StoreReviewService $s)
    {
        $this->storeReviewService = $s;
    }

    // Endpoint: /reviews/store
    public function store(Request $request)
    {
        \Log::info($request);
        // $newReview = $this->storeReviewService->store($request);
        // Review::create($newReview);
    }

    // Endpoint: /reviews/fetch/{businessId}/{reviewId}
    public function fetchReview(mixed $businessId, mixed $reviewId)
    {
        //
    }

    // Endpoint: /reviews/fetch-all
    public function fetchAll(mixed $businessId)
    {
        //
    }
}
