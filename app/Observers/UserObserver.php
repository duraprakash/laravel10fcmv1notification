<?php

namespace App\Observers;

use App\Models\User;
use App\Jobs\SendFcmNotification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Example: Send welcome notification
        SendFcmNotification::dispatch($user->fcm_token, 'Welcome', 'Thank you for registering!');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Example: Send status update notification
        if ($user->wasChanged('status'))
        {
            SendFcmNotification::dispatch($user->fcm_token, 'Status Updated', 'Your status has been updated.');
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
