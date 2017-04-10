<?php

namespace TCG\Voyager\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NoSqlSchemaCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $schema;

    /**
     * Create a new event instance.
     *
     * @param mixed $schema Contains schema information of table to be created
     */
    public function __construct($schema)
    {
        $this->schema = $schema;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}