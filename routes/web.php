<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\{
    CampaignController,
    SmsController,
    UploadRecordsController,
    TestEndpointController,
};
use App\Http\Controllers\Auth\{
    LoginController,
    LogoutController,
};

Route::get('/', function () {
    return view('welcome');
});

// Login/Logout Routes
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);

// get curr user
Route::get('/get-user', [TestEndpointController::class, 'getUser']);

// Route::get('campaign', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('sendSMS', [SmsController::class, 'index']);
Route::post('uploadRecords', [UploadRecordsController:: class, 'upload']);
Route::post('createCampaign', [CampaignController::class, 'create']);

Route::post('/fetch-subscribers', [UploadRecordsController::class, 'fetch']);
Route::post('/fetch-campaigns', [CampaignController::class, 'fetch']);