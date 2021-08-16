<?php

namespace App\Listeners;

use App\Events\ColumnDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteCards
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ColumnDeleted  $event
     * @return void
     */
    public function handle(ColumnDeleted $event)
    {
        $event->column->records()->delete();
    }
}
