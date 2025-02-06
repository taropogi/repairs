<?php

namespace App\Listeners;

use App\Events\CpoUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\UpdateCpoTotals;

class UpdateCpoTotal
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
     * @param  \App\Events\CpoUpdated  $event
     * @return void
     */
    public function handle(CpoUpdated $event)
    {
        UpdateCpoTotals::dispatch(
            $event->cpo,
            auth()->user(),
            request()->ip()
        )->delay(now()->addSeconds(2));
    }
}
