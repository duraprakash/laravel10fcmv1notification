<?php

use App\Http\Controllers\API\V1\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Send notification to a single device
Route::post('/send-notification', [NotificationController::class, 'sendToDevice']);

// Send notification to multiple devices
Route::post('/send-notification-multiple', [NotificationController::class, 'sendToMultipleDevices']);

// Schedule a notification
Route::post('/schedule-notification', [NotificationController::class, 'scheduleNotification']);