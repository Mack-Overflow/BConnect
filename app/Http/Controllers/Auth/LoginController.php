<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    private function __invoke()
    {
        request()->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'email'],
        ]);

        if (EnsureFrontendRequestsStateful::fromFrontend(request())) {
            $this->authenticateFrotend();
        }

        else {
            // Token authentication rate
        }
    }

    private function authenticateFrontend()
    {
        if (!Auth::guard('web')
            ->attempt(
                request()->only('email', 'password'),
                request()->boolean('rembember')
            )) {
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }
    }
}
