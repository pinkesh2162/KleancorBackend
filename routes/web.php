<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\HouseKeepingController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HouseKeepingRadioController;
use App\Http\Controllers\UserController;

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/terms-of-use', function () {
    return view('terms-of-use');
});

Route::get('/user-data-deletion', function () {
    return view('user-data-deletion');
});

Route::get('/apps-link', function () {
    return view('apps-link');
});

Route::get('/', [WelcomeController::class, 'login_page'])->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('admin');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('housekeepings', HouseKeepingController::class);
    Route::resource('persons', PersonController::class);
    Route::resource('jobs', JobController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('housekeepingradios', HouseKeepingRadioController::class);
    Route::resource('users', UserController::class);
    Route::post('users/{user}/change-status', [UserController::class, 'changeStatus']);
    Route::post('users/delete-all', [UserController::class, 'deleteAllUsers']);
    Route::post('users/verifying/{id}', [UserController::class, 'verifying'])->name('users.verifying');
});

Route::get('send-mail', function () {
    $details = [
        'title' => 'Mail from Kleancor.com',
        'body' => 'This is for testing email using Gmail smtp'
    ];

    \Mail::to('codesdealbd@gmail.com')->send(new \App\Mail\SendInvoiceMail($details));

    dd("Email is Sent.");
});

// Clear application cache:
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

//Clear route cache:
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return 'Routes cache has been cleared';
});

//Clear config cache:
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has been cleared';
});

// Clear view cache:
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});

Route::get('/updateapp', function () {
    exec('composer dump-autoload');
    echo 'composer dump-autoload complete';
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'Symlink Created';
});
