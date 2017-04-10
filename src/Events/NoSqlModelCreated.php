<?php

namespace TCG\Voyager\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NoSqlModelCreated
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
    public $key;

    /**
     * Create a new event instance.
     *
     * @param string $table Table where the content is to be saved
     * @param string $key Primary key where content will be indexed with
     * @param mixed $content Content to be saved
     */
    public function __construct($table, $key, $content)
    {
        $this->table = $table;
        $this->key = $key;
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