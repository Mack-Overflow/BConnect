<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use App\Models\Url;

class GenerateReviewUrlService
{
    /**
     * String that is used to generate a 7-digit short URL
     * @var string
     */
    protected $base_62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Takes a Customer ID and generates a 7-character string for a 
     * shortened URL
     */
    public function generate()
    {
        // $subId = $request->subscriberId;
        do {
            $output_url = '';
            for ($i = 0; $i < 63; $i++)
            {
                $randomIndex = random_int(0, 61);
                $output_url .= $this->base_62[$randomIndex];
            }
            $final_url = substr($output_url, -7);

            // the conditional below is where we will want to optimize DB performance
            // and potentially use clustering to run in parallel
            // MongoDB may also be faster query time for 1D search
        } while (Url::where('shortUrl', $final_url)->exists());
        
        return $final_url;
    }
}