<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivityLogged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $activity;
    public $ip;

    /**
     * Create a new event instance.
     *
     * @param int $userId The ID of the user associated with the activity.
     * @param string $activity The description of the user's activity.
     * @param string|null $ip The IP address from which the activity was performed.
     */

    public function __construct($userId, $activity, $ip = null)
    {
        $this->userId = $userId;
        $this->activity = $activity;
        $this->ip = $ip;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
