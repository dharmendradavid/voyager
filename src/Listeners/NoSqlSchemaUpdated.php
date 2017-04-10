<?php

namespace TCG\Voyager\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use TCG\Voyager\Events\NoSqlSchemaUpdated as Listener;
use TCG\Voyager\NoSqlWrapper;

class NoSqlSchemaUpdated
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
        //@todo need to create update schema handler
//        $this->wrapper->authenticate([])
//            ->createTable($event->schema);
    }
}
