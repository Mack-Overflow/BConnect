<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\TextMessage;
use App\Models\SentMessage;
use App\Models\Review;

class CalculateReviewAnalyticsService
{
    public function getReviewsPastDays(int $businessId, int $days)
    {
        $reviewCount = Review::where('businessId', $businessId)->where('created_at', '>', now()->subDays($days)->endofDay())->count();
        return $reviewCount;
        // $users = DB::table("users")
        //     ->select('id')
        //     ->where('accounttype', 'standard')
        //     ->where('created_at', '>', now()->subDays(30)->endOfDay())
        //     ->all();
    }

    public function getAverageRating($businessId)
    {
        \Log::info($businessId);
        $totalReviewCount = Review::where('businessId', $businessId)->count();
        $totalReviewCount = $totalReviewCount ? $totalReviewCount : 1;
        $ratings = intval(Review::where('businessId', $businessId)->sum('rating'));

        $average = number_format($ratings / ($totalReviewCount), 1);
        \Log::info($average);
        return $average;
    }

    public function getReviewPercent()
    {
        $businessId = Auth::user()->businessId;
        $reviewCount = Review::where('businessId', $businessId)->count();

        $reviewInviteCount = SentMessage::where('businessId', $businessId)
            ->where('sendToType', 'Review Invite')
            ->count();
        // if (!$reviewInviteCount)
        $percent = ($reviewInviteCount > 0) ? 100 * ($reviewCount / $reviewInviteCount) : 100;
        \Log::info($percent);
        return $percent;
    }


    public function getReviewRatingsCount($businessId)
    {
        // $totalCount = 
        $counts = ['totalCount' => Review::where('businessId', $businessId)->count()];
        
        $counts['oneStar'] = Review::where('businessId', $businessId)->where('rating', 1)->count();
        $counts['twoStar'] = Review::where('businessId', $businessId)->where('rating', 2)->count();
        $counts['threeStar'] = Review::where('businessId', $businessId)->where('rating', 3)->count();
        $counts['fourStar'] = Review::where('businessId', $businessId)->where('rating', 4)->count();
        $counts['fiveStar'] = Review::where('businessId', $businessId)->where('rating', 5)->count();

        \Log::info($counts);
        return $counts;
    }

    // public function getCountByRating($businessId)
    // {
    //     $oneStar = Review::where('businessId', $businessId)
    // }

    public function getSentReviewCount($businessId)
    {
        // $sentCount = 
    }
}