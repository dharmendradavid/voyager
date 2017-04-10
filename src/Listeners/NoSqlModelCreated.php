<?php

namespace TCG\Voyager\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use TCG\Voyager\Events\NoSqlModelCreated as Listener;
use TCG\Voyager\NoSqlWrapper;

class NoSqlModelCreated
{
    protected $wrapper;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->wrapper = new NoSqlWrapper();
    }

    /**
     * Handle the event.
     *
     * @param Listener $event
     * @return void
     */
    public function handle(Listener $event)
    {
        $this->wrapper->authenticate([
            [
                'name' => $event->table
            ]
        ])->storeItem($event->table, $event->key, $event->content);
    }
}
