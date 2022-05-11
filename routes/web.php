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
    LoginController,
    LogoutController,
    CreateCampaignController,
    SmsController,
    UploadRecordsController
};

Route::get('/', function () {
    return view('welcome');
});

Route::get('campaign', [CreateCampaignController::class, 'index'])->name('campaign.index');
Route::get('sendSMS', [SmsController::class, 'index']);
Route::post('uploadRecords', [UploadRecordsController:: class, 'upload']);
