<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendFcmNotification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // Schedule the FCM notifications command to run every hour
        $schedule->command('fcm:schedule-notifications')->hourly();

        /**
         * Dynamic
         */
        // $schedule->job(new SendFcmNotification($token, $title, $body, $data))->at(now()->addMinutes(10)); // Example for delayed notification

        // $schedule->job(new SendFcmNotification($token, $title, $body, $data))->dailyAt('13:00'); // Example for specific time

        // Example for delayed notification (10 minutes from now)
        $schedule->job(new SendFcmNotification(
            'DEVICE_FCM_TOKEN', // Replace with a valid device token
            'Delayed Notification', // Title
            'This is a delayed notification sent 10 minutes after scheduling.', // Body
            ['key1' => 'value1', 'key2' => 'value2'] // Optional data payload
        ))->at(now()->addMinutes(10));

        // Example for specific time (daily at 13:00)
        $schedule->job(new SendFcmNotification(
            'DEVICE_FCM_TOKEN', // Replace with a valid device token
            'Scheduled Notification', // Title
            'This is a scheduled notification sent daily at 13:00.', // Body
            ['key1' => 'value1', 'key2' => 'value2'] // Optional data payload
        ))->dailyAt('13:00');

        // Call the custom command to schedule notifications dynamically based on data from database
        $schedule->command('schedule:fcm-notifications')->everyMinute(); // Adjust frequency as needed


    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
