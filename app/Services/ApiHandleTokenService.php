<?php

namespace App\Services;

use Laravel\Sanctum\PersonalAccessToken;


class ApiHandleTokenService
{
    public function verifyBearerToken(string $bearer)
    {
        $hashedToken = hash('sha256', $personalAccessToken = $bearer);
        if (!is_null(PersonalAccessToken::where(['token' => $hashedToken])->where('last_used_at', '>', now()->subHours(2))->first())); 
    }
}