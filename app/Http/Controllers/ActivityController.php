<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function index()
    {
        return view('activities.index');
    }

    /**
     * Display the specified activity.
     */
    public function show(Activity $activity)
    {
        return view('activities.show', [
            'activity' => $activity
        ]);
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return Redirect::route('activities.index')
            ->with('success', 'Activity deleted successfully.');
    }
}
