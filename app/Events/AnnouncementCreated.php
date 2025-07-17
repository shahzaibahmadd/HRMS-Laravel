<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Announcement;

class AnnouncementCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function broadcastOn()
    {
        return new Channel('announcements');
    }

    public function broadcastAs()
    {
        return 'announcement.created';
    }

    public function broadcastWith()
    {
        return [
            'announcement' => [
                'id'        => $this->announcement->id,
                'title'     => $this->announcement->title,
                'message'   => $this->announcement->message,
                'is_active' => (bool) $this->announcement->is_active,
                'created_at'=> $this->announcement->created_at?->toDateTimeString(),
            ]
        ];
    }
}
