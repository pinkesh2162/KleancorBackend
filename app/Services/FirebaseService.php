<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $serviceAccountPath = base_path(env('FIREBASE_CREDENTIALS'));

        // Create the Firebase instance
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccountPath);

        // Get the Messaging instance
        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $message = [
            'token' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ]
        ];

        try {
            $this->messaging->send($message);
            return ['success' => true, 'message' => 'Notification sent successfully.'];
        } catch (FirebaseException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
