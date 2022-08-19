<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\{
//     IncomingSmsController,
// };
use App\Http\Controllers\Auth\{
    LoginController,
    LogoutController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/ 

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     // \Log::info($request);
//     return $request->user();
// });

Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);

Route::get('register', function(Request $request) {
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password
    ]);

    return $user;
});

Route::get('get-user', function() {
    return 'api guard';
});

// Twilio incoming webhooks
// Route::post('/receive-sms', [IncomingSmsController::class, 'receiveSms']);
// Route::post('/receive-sms', [IncomingSmsController::class, 'receiveSms']);
// Route::post('/delivery-status', [IncomingSmsController::class, 'deliveryStatus']);
