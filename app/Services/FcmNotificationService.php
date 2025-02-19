<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FcmNotificationService
{
    protected $messaging;

    public function __construct()
    {
        // method1: Optional: Load the Firebase service account credentials from the .env file
        // $credentialsPath = config('firebase.credentials'); 
        // $credentialsPath = config('firebase.projects.app.credentials.file'); // method2: Recommended: Load the Firebase service account credentials from the config file
        $credentialsPath = storage_path('app/firebase/laravel10fcmv1notification-firebase-adminsdk-fbsvc-938fe52687.json'); // method3: Alternative: direct file access via storage

        if (!file_exists($credentialsPath))
        {
            throw new \Exception('Firebase credentials file not found at: ' . $credentialsPath);
        }

        // $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
        $factory = (new Factory)->withServiceAccount($credentialsPath);
        $this->messaging = $factory->createMessaging();
    }

    public function sendToDevice($token, $title, $body, $data = [])
    {
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        $this->messaging->send($message);
    }

    public function sendToMultipleDevices(array $tokens, $title, $body, $data = [])
    {
        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        $this->messaging->sendMulticast($message, $tokens);
    }
}