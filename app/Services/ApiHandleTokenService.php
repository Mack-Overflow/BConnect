<?php

namespace App\Services;

use Laravel\Sanctum\PersonalAccessToken;


class ApiHandleTokenService
{
    public function verifyBearerToken(string $bearer)
    {
        $hashedToken = hash('sha256', $personalAccessToken = $bearer);
        if (!is_null(PersonalAccessToken::where(['token' => $hashedToken])
                    ->where('created_at', '>', now()->subHours(4))
                    ->orWhere('last_used_at', '>', now()->subHours(4))
                    ->first())) return true;
        
        return false;
        
    }
}