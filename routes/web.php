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
use Twilio\Twiml;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    BusinessController,
    CampaignController,
    SmsController,
    UploadRecordsController,
    TestEndpointController,
    ReviewController,
    IncomingSmsController,
    RedemptionController,
    LinkController,
    SubscriberController,
};
use App\Http\Controllers\Auth\{
    LoginController,
    LogoutController,
};

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Login/Logout Routes
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);

// get curr user
Route::get('/get-user', [TestEndpointController::class, 'getUser']);

// Route::get('campaign', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('sendSMS', [SmsController::class, 'index']);
Route::post('uploadRecords', [UploadRecordsController:: class, 'upload']);
Route::post('/createCampaign', [CampaignController::class, 'create']);
Route::put('/send-campaign', [CampaignController::class, 'send']);
Route::post('/update-campaign', [CampaignController::class, 'update']);

Route::post('/fetch-subscribers', [UploadRecordsController::class, 'fetch']);
Route::post('/fetch-campaigns', [CampaignController::class, 'fetch']);
Route::get('/fetch-sendToTypes/{businessId}', [CampaignController::class, 'fetchTypes']);

// Reviews
Route::get('/reviews/fetch/{businessId}/{reviewId}', [ReviewController::class, 'fetchReview']);
Route::get('/reviews/fetch-all/{businessId}', [ReviewController::class, 'fetchAll']);
Route::post('/reviews/review-data', [ReviewController::class, 'fetchData']);
Route::post('/reviews/store', [ReviewController::class, 'store']);

// Redemptions
Route::get('/redemptions/data/fetch-all/{businessId}', [RedemptionController::class, 'fetchAll']);

// Handle Short URL links
Route::get('/link/{shortUrl}', [LinkController::class, 'index']);

// Twilio incoming webhooks
Route::get('/receive-sms', [IncomingSmsController::class, 'receiveSms']);
// Route::get('/receive-sms', function (Request $request) {
//     \Log::info($request);
//     // $res = new Twiml();
//     // $res->sms("This is it!");
//     return response()->json(['message' => 'coming soon'], 200);
// });
// Route::post('/receive-sms', [IncomingSmsController::class, 'receiveSms']);
Route::post('/delivery-status', [IncomingSmsController::class, 'deliveryStatus']);


// ----------- A P I  S P E C I F I C  R O U T E S -------------------------------
// Ensure before login that following pre-request script is added: 
// pm.sendRequest({
//     url: pm.environment.get('APP_URL') + 'sanctum/csEBrf-cookie',
//     method: 'GET'
// }, function (error, response, { cookies }) {
//     if (!error) {
//         pm.environment.set('XSRF_TOKEN', cookies.get('XSRF-TOKEN'))
//     }
// })
// Retrieve API Token
// Route::post('/api/login', [LoginController::class, 'apiLogin']);
Route::post('/api/login', [LoginController::class, 'apiLogin']);


Route::group(['middleware' => ['auth:sanctum']], function() {
    // phoneNumber i.e "+18001012222"
    Route::get('/api/fetch-subscriber/{phoneNumber}', [SubscriberController::class, 'retrieve']);
    // businessName i.e. "Bconnect%20Dev"
    Route::get('/api/fetch-business/{businessId}', [BusinessController::class, 'fetchOne']);
    // Needs Campaign ID, ideal for reminder text
    
    Route::group(['middleware' => ['apiPostAuth']], function() {
        Route::put('/api/send-campaign', [CampaignController::class, 'send']);
        Route::post('/api/send-single-text', [CampaignController::class, 'sendSingleText']);
        Route::post('/api/create-subscriber', [SubscriberController::class, 'store']);
        
        // Required fields: msgHeader, msgBody, msgUrl, businessId, sendToType. Optional: promoCode
        Route::post('/api/create-campaign', [CampaignController::class, 'create']);
    });
});
