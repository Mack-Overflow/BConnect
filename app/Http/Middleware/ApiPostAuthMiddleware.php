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
        \Log::info($request->header('Authorization'));
        $bearer = ($request->header('Authorization')) ? $request->header('Authorization') : null;
        if (!$bearer) return response()->json(['error' => 'Unauthenticated'], 401);
        
        if ($this->apiTokenService->verifyBearerToken($bearer)) return $next($request);
        
    }
}
