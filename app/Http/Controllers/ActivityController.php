<?php

namespace App\Http\Controllers;

use App\Jobs\LogActivity;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }

    public function logActivity(Request $request)
    {
        // Activity::create([
        //     'action' => $request->action,
        //     'description' => $request->description,
        //     'user_id' => auth()->user()->id
        // ]);

        LogActivity::dispatch(
            $request->action,
            $request->description,
            auth()->user()->id,
            auth()->user()->name
        );
    }

    public function logGotoYp(Request $request)
    {
        // Activity::create([
        //     'action' => 'Goto YP',
        //     'description' => 'User went to YP and checked the item: ' . $request->item['description'],
        //     'user_id' => auth()->user()->id
        // ]);

        LogActivity::dispatch(
            'Goto YP',
            'User went to YP and checked the item: ' . $request->item['description'],
            auth()->user()->id,
            auth()->user()->name
        );
    }

    public function logSelectItem(Request $request)
    {
        // Activity::create([
        //     'action' => 'Select Item',
        //     'description' => 'User selected item: ' . $request->item['description'],
        //     'user_id' => auth()->user()->id
        // ]);

        LogActivity::dispatch(
            'Select Item',
            'User selected item: ' . $request->item['description'],
            auth()->user()->id,
            auth()->user()->name
        );
    }

    public function logPageVisit()
    {
        $ipAddress = request()->ip();
        // logger()->info('User visited the page: ' . request()->page . ' from IP: ' . $ipAddress);
        // Activity::create([
        //     'action' => 'Page Visit',
        //     'description' => 'User visited the page: ' . request()->page,
        //     'user_id' => auth()->user()->id
        // ]);

        LogActivity::dispatch(
            'Page Visit',
            'User visited the page: ' . request()->page,
            auth()->user()->id,
            auth()->user()->name
        );
    }
}
