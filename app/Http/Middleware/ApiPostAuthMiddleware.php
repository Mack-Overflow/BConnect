<?php

namespace App\Http\Middleware;

use App\Services\ApiHandleTokenService;
use Closure;
use Illuminate\Http\Request;

class ApiPostAuthMiddleware
{
    protected ApiHandleTokenService $apiTokenService;

    public function __construct(ApiHandleTokenService $apiTokenService)
    {
        $this->apiTokenService = $apiTokenService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // \Log::info($request->header('Authorization'));
        $bearer_unparsed = ($request->header('Authorization')) ? $request->header('Authorization') : null;

        if (!$bearer_unparsed) return response()->json(['error' => 'Unauthenticated'], 401);
        
        $bearer_parsed = explode(" ", $bearer_unparsed)[1];
        // \Log::info($bearer_parsed);
        if ($this->apiTokenService->verifyBearerToken($bearer_parsed)) return $next($request);
        // if ($this->apiTokenService->verifyBearerToken($bearer_parsed)) return response()->json(['message' => 'hell yeah'], 200);
        return response()->json(['error' => 'Invalid Bearer Token'], 401);
    }
}
