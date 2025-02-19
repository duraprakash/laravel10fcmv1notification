<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendFcmNotification;
use App\Models\User; // Example model
use Carbon\Carbon;

class ScheduleFcmNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:fcm-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule FCM notifications dynamically for users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Example: Fetch users who need notifications
        $users = User::where('notify', true)->get();

        foreach ($users as $user)
        {
            // Example: Schedule a notification for each user
            $scheduleAt = Carbon::now()->addMinutes(10); // Schedule 10 minutes from now

            SendFcmNotification::dispatch(
                $user->fcm_token, // Device token
                'Hello ' . $user->name, // Title
                'This is a dynamic scheduled notification.', // Body
                // ['userId' => $user->id], // Optional data payload
                ['key' => 'value']
                // )->delay(now()->addMinutes(10)); // Schedule for 10 minutes later
            )->delay($scheduleAt);

            $this->info("Scheduled notification for user: {$user->id} at {$scheduleAt}"); // remove
        }

        $this->info('All FCM notifications scheduled successfully!');
    }
}
