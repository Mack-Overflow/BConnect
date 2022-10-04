<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

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
        Log::info(Auth::user());
        // Include necessary user data in Json response
        return response()->json(['message' => 'Logged In!', 'user_data' => auth()->user()], 201);
    }

    /**
     * Endpoint: POST /api/login
     * @param Request $request
     * 
     * @return response()->json()
     */
    public function apiLogin(Request $request) : JsonResponse
    {
        if (!auth()->attempt($request->only('email', 'password')))
        {
            throw new AuthenticationException();
        }

        $request->session()->regenerate();
        $token = Auth::user()->createToken('api_auth_token', ['abilities:fetch-data'])->plainTextToken;
        Log::info(Auth::user());
        $businessData = Business::find(Auth::user()->businessId);

        // Include necessary user data in Json response,
        // Issues API Token to be used as bearer token in Authorization headers
        return response()->json(['message' => 'Logged In!', 'token' => $token, 'businessData' => $businessData], 201);
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
