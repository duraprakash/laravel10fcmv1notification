<?php

use App\Http\Controllers\API\V1\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// To test in web
Route::get('/test-notification', function () {
    return view('notifications.test');
});

// Send notification to a single device
Route::post('/send-notification', [NotificationController::class, 'sendToDevice']);

// Send notification to multiple devices
Route::post('/send-notification-multiple', [NotificationController::class, 'sendToMultipleDevices']);

// Schedule a notification
Route::post('/schedule-notification', [NotificationController::class, 'scheduleNotification']);

// Create a route to store the token
Route::post('/store-token', [NotificationController::class, 'storeToken']);