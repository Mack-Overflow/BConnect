<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke()
    {
        if (EnsureFrontendRequestsAreStateful::fromFrontend(request()))
        {
            Auth::guard('web')->logout();

            request()->session()->invalidate();
        
            request()->session()->regenerateToken();
        } else {
            // Revoke token
        }
    }
}
