<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JobPostingController;
use App\Http\Controllers\API\HomeScreenController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\API\PaymentMethodController;
use App\Mail\WelcomeMail;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout');
        Route::post('forgotpassword', 'forgotpassword');
        Route::post('matchpincode', 'matchpincode');
        Route::post('changepassword', 'changepassword');
    });
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::post('job-posting', [JobPostingController::class, 'index']);
    Route::post('job/delete/{id}', [JobPostingController::class, 'destroy']);
    Route::get('job-edit/{id}/{time}', [JobPostingController::class, 'job_edit']);
    Route::post('job-update', [JobPostingController::class, 'job_update']);
    Route::get('get-decline-jobs', [JobPostingController::class, 'geWorkerDeclineJob']);
    Route::get('house-keepings/{id}', [HomeScreenController::class, 'house_keepings']);
    Route::get('location', [HomeScreenController::class, 'location']);
    Route::get('home', [HomeScreenController::class, 'category']);
    Route::get('job-list/{start}/{status}', [JobPostingController::class, 'job_list']);
    Route::get('profile-job-list/{start}/{status}/{userid}/{type}', [JobPostingController::class, 'profile_job_list']);
    Route::get('worker-completed-jobs/{start}/{userid}', [JobPostingController::class, 'worker_completed_jobs']);
    Route::get('settings', [HomeScreenController::class, 'settings']);
    Route::get('job-details/{id}/{userId}', [JobPostingController::class, 'job_deatils']);
    Route::post('job-apply', [JobPostingController::class, 'job_apply']);
    Route::get('proposal-list/{id}', [JobPostingController::class, 'proposal_list']);
    Route::post('complete-hire', [JobPostingController::class, 'complete_hire']);
    Route::post('accept-offer', [JobPostingController::class, 'accept_offer']);
    Route::get('client-offer-list/{userid}', [JobPostingController::class, 'client_offer_list']);
    Route::get('payment/{id}', [JobPostingController::class, 'payment']);
    Route::post('completed-job-info', [JobPostingController::class, 'completed_job_info']);
    Route::post('recent-search-save', [JobPostingController::class, 'recent_search_save']);
    Route::get('recent-search/{id}', [JobPostingController::class, 'recent_search']);
    Route::get('job-search/{keyword}', [JobPostingController::class, 'job_search']);
    Route::get('job-list-search/{keyword}/{start}/{status}', [JobPostingController::class, 'job_list_search']);
    Route::get('category-search/{keyword}', [HomeScreenController::class, 'category_search']);
    Route::post('complete-review', [JobPostingController::class, 'complete_review']);
    Route::get('load-client-profile/{id}', [JobPostingController::class, 'load_client_profile']);
    Route::get('load-worker-profile/{id}', [JobPostingController::class, 'load_worker_profile']);

    Route::get('recent-category-search/{id}', [JobPostingController::class, 'recent_category_search']);
    Route::post('recent-category-search-save', [JobPostingController::class, 'recent_category_search_save']);
});

Route::middleware(['cors'])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('get-profile/{id}', 'getProfile');
        Route::post('profile-update', 'profile_update');
        Route::post('delete-profile/{id}', 'delete_profile');
        Route::post('client-profile-update', 'client_profile_update');
        Route::get('skills', 'skills');
        Route::get('locations', 'locations');
        Route::get('categories', 'categories');
        Route::post('save-fcm', 'saveFcm');
        Route::get('get-fcm/{id}', 'getFcm');
        Route::post('save-notification', 'saveNotifications');
        Route::get('get-notification/{id}', 'getNotifications');
        Route::post('update-notification/{id}', 'updateNotifications');
        Route::get('count-notification/{id}', 'getLatestNotifyRows');
        Route::post('sent-refer', 'sent_refer');
        Route::get('get-refer-numbers/{id}', 'get_refer_numbers');
        Route::get('get-refer-info/{id}', 'get_refer_info');
        Route::get('get-invoices-info/{id}', 'get_invoices_info');
    });
});

Route::post('/create-payment-user/{id}', [PaymentMethodController::class, 'createPaymentUser']);

//create account 
Route::post('/create-vendor-stripe-account/{id}', [PaymentMethodController::class, 'createStripeAccount']);

//connect account or link account to stripe
Route::post('/create-bank-stripe-account/{id}', [PaymentMethodController::class, 'linkBankAccount']);

//create transfer for payroll
Route::post('/create-transfer/{id}', [PaymentMethodController::class, 'createTransfer']);

//transfer bank account money
Route::post('/create-transfer-money/{id}', [PaymentMethodController::class, 'transferToBankAccount']);

//delete account 
Route::delete('/delete-stripe-account/{id}', [PaymentMethodController::class, 'deleteStripeAccount']);

Route::post('messages', [ChatController::class, 'sendMessage']);


Route::post('/upload-image/{id}', [ImageController::class, 'uploadImage']);
Route::post('upload-pdf/{id}', [ImageController::class, 'uploadPdf']);

Route::post('/upload-documents/{id}', [ImageController::class, 'updateDocuments']);

Route::get('get-messages/{channel_name}', [ChatController::class, 'getMessages']);
Route::get('chat-history/{id}', [ChatController::class, 'chat_history']);

Route::middleware(['cors'])->group(function () {
    Route::controller(PaymentMethodController::class)->group(function () {
        Route::get('payment-info/{id}', 'index');
        Route::post('update-payment-info', 'update');
    });
});

// Route::get('send/mail', function () {
//     setEmailConfiguration();
//     \Mail::to('chandanpradhan.in@gmail.com')->send(new WelcomeMail('test from'));
//     dd('send success');
// });

// New change
