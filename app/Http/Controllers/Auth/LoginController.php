<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // request()->validate([
        //     'email' => ['required', 'string', 'email'],
        //     'password' => ['required', 'string', 'email'],
        // ]);

        // if (EnsureFrontendRequestsStateful::fromFrontend(request())) {
        //     $this->authenticateFrotend();
        // }

        // else {
        //     // Token authentication rate
        // }

        if (!auth()->attempt($request->only('email', 'password')))
        {
            throw new AuthenticationException();
        }
        $request->session()->regenerate();
        \Log::info(\Auth::user());
        // Include necessary user data in Json response
        return response()->json(['message' => 'Logged In!', 'user_data' => auth()->user()], 201);
    }

    // private function authenticateFrontend()
    // {
    //     if (!Auth::guard('web')
    //         ->attempt(
    //             request()->only('email', 'password'),
    //             request()->boolean('rembember')
    //         )) {
    //             throw ValidationException::withMessages([
    //                 'email' => __('auth.failed'),
    //             ]);
    //         }
    // }
}
