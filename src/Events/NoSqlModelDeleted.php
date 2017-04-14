<?php

namespace TCG\Voyager\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NoSqlModelDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $table;

    /**
     * Primary key for the content for table
     *
     * @var string
     */
    public $primaryKey;

    /**
     * Secondary key for the content for table
     *
     * @var string
     */
    public $secondaryKey;

    /**
     * Create a new event instance.
     *
     * @param string $table Table where the content is to be saved
     * @param string $primaryKey Primary key where content will be indexed with
     * @param string $secondaryKey Primary key where content will be indexed with
     */
    public function __construct($table, $primaryKey, $secondaryKey)
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->secondaryKey = config('voyager.real_time_co')['secondary_key_function']($secondaryKey);
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