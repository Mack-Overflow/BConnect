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
    protected static $base_62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Takes a Customer ID and generates a 7-character string for a 
     * shortened URL
     */
    public static function generate()
    {
        $base_62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            $output_url = '';
            for ($i = 0; $i < 63; $i++)
            {
                $randomIndex = random_int(0, 61);
                $output_url .= $base_62[$randomIndex];
            }
            $extension = substr($output_url, -7);
            $final_url = (getenv('APP_ENV') === 'staging') ? "https://client.bconnect-staging.com/link/".$extension : "localhost:3000/link/".$extension;

            // the conditional below is where we will want to optimize DB performance
            // and potentially use clustering to run in parallel
            // MongoDB may also be faster query time for 1D search
        } while (Url::where('shortUrl', $extension)->exists());
        
        return $final_url;
    }
}