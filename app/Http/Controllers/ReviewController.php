<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StoreReviewService;
use App\Services\CalculateReviewAnalyticsService;
use App\Models\Review;

class ReviewController extends Controller
{
    protected $storeReviewService;

    public function __construct(StoreReviewService $s, CalculateReviewAnalyticsService $calc)
    {
        $this->storeReviewService = $s;
        $this->calculator = $calc;
    }

    // Endpoint: /reviews/store
    public function store(Request $request)
    {
        // \Log::info($request);
        // $newReview = $this->storeReviewService->store($request);
        // Review::create($newReview);
    }

    // Endpoint: /reviews/fetch/{businessId}/{reviewId}
    public function fetchReview(mixed $businessId, mixed $reviewId)
    {
        //
    }

    // Endpoint: GET /reviews/fetch-all/{businessId}
    public function fetchAll(mixed $businessId)
    {
        $reviews = ['reviews' => Review::where('businessId', $businessId)->take(25)->get()];

        $reviews['counts'] = $this->calculator->getReviewRatingsCount($businessId);
        // $reviews->countByRating = $this->calculator()->getCountByRating($businessId);

        // $reviews->averageRating = $this->calculator()->getAverageRating($businessId);
        // $pastWeek = $this->calculator()->getReviewsPastWeek($businessId);
        return response()->json(['reviews' => $reviews]);
    }

    /**
     * Endpoint: GET /review/review-data/{businessId}
     */
    public function fetchData(Request $request)
    {
        \Log::info($request);
        // $businessId = Auth::user()->businessId
        $pctReviewed = $this->calculator->getReviewPercent($request->businessId);
        $averageRating = $this->calculator->getAverageRating($request->businessId);
        $pastWeek = $this->calculator->getReviewsPastDays($request->businessId, 7);

        return response()->json([
            'pctReviewed' => $pctReviewed,
            'avgRating' => $averageRating,
            'reviewsPastWeek' => $pastWeek 
        ], 200);
    }

    /**
     * Send a review Invite to phoneNumber
     * @param $request
     * @return response()->json()
     */
    public function send(Request $request)
    {
        try {
            $subscriber = Subscriber::firstOrCreate(['phoneNumber' => $request->phoneNumber], [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'visitDate' => $request->visitDate,
            ]);
        } catch(\Exception $e) {
            //
        }
        
    }
}
