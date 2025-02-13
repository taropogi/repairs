<?php

namespace App\Listeners;

use App\Events\CpoDeleted;
use App\Models\Activity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Cpo;

class UpdateRmaNumberCpoDeleted
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
     * @param  \App\Events\CpoDeleted  $event
     * @return void
     */
    public function handle(CpoDeleted $event)
    {
        $cpo = $event->cpo;
        $cpo->rma_number = null;
        $cpo->save();

        // also for othere delete cpo
        $deletedCpos = Cpo::onlyTrashed()->whereNotNull('rma_number')->get();
        foreach ($deletedCpos as $deletedCpo) {
            $deletedCpo->rma_number = null;
            $deletedCpo->save();
        }

        Activity::create([
            'action' => 'Deleted CPO, Updatd Rma Number to null',
            'description' => 'RMA number removed from CPO: ' . $cpo->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}
