<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tokoId;
    public $status;
    public $idAkun;

    /**
     * Create a new event instance.
     */
    public function __construct($tokoId, $status, $idAkun)
    {
        $this->tokoId = $tokoId;
        $this->status = $status;
        $this->idAkun = $idAkun;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
