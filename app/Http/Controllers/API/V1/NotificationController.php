<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\FcmNotificationService;
use App\Jobs\SendFcmNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $fcmService;

    public function __construct(FcmNotificationService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    // Send notification to a single device
    public function sendToDevice(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array',
        ]);

        $this->fcmService->sendToDevice(
            $request->token,
            $request->title,
            $request->body,
            $request->data ?? []
        );

        return response()->json(['message' => 'Notification sent successfully!']);
    }

    // Send notification to multiple devices
    public function sendToMultipleDevices(Request $request)
    {
        $request->validate([
            'tokens' => 'required|array',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array',
        ]);

        $this->fcmService->sendToMultipleDevices(
            $request->tokens,
            $request->title,
            $request->body,
            $request->data ?? []
        );

        return response()->json(['message' => 'Notifications sent successfully!']);
    }

    // Schedule a notification
    public function scheduleNotification(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array',
            'schedule_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $delay = Carbon::parse($request->schedule_at)->diffInSeconds(now());

        SendFcmNotification::dispatch(
            $request->token,
            $request->title,
            $request->body,
            $request->data ?? []
        )->delay(now()->addSeconds($delay));

        return response()->json(['message' => 'Notification scheduled successfully!']);
    }

    public function storeToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // Store the token in the database (e.g., associated with the authenticated user)
        // Example: auth()->user()->update(['fcm_token' => $request->token]);
        auth()->user()->update(['fcm_token' => $request->token]);

        return response()->json(['message' => 'Token stored successfully!']);
    }
}
