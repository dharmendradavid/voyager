<?php

namespace TCG\Voyager\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NoSqlModelUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $table;

    /**
     * Content to be saved
     * @var mixed
     */
    public $content;

    /**
     * Primary key for the content for table
     *
     * @var string
     */
    public $primaryKey;

    /**
     * Primary key for the content for table
     *
     * @var string
     */
    public $secondaryKey;

    /**
     * Create a new event instance.
     *
     * @param string $table Table where the content is to be saved
     * @param string $primaryKey Primary key where content will be indexed with
     * @param string $secondaryKey Secondary key where content will be indexed with
     * @param mixed $content Content to be saved
     */
    public function __construct($table, $primaryKey, $secondaryKey, $content)
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->secondaryKey = $secondaryKey;
        $this->content = $content;
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