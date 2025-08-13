<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        ActivityLog::create([
            'user_id' => $event->userId,
            'activity' => $event->activity,
            'ip_address' => $event->ip,
        ]);
    }
}
