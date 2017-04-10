<?php

namespace TCG\Voyager\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use TCG\Voyager\Events\NoSqlModelDeleted as Listener;
use TCG\Voyager\NoSqlWrapper;

class NoSqlModelDeleted
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
        ])->deleteItem($event->table, $event->key);
    }
}
