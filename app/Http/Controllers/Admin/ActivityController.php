<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Destination;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of activities.
     */
    public function index()
    {
        $activities = $this->activityService->getAllActivities();
        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create()
    {
        $destinations = Destination::all();
        return view('admin.activities.create', compact('destinations'));
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required|string|max:255',
            'cost_adult' => 'required|numeric|min:0',
            'cost_child' => 'nullable|numeric|min:0',
            'cost_infant' => 'nullable|numeric|min:0',
        ]);

        $this->activityService->createActivity($data);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    /**
     * Show the form for editing the activity.
     */
    public function edit(Activity $activity)
    {
        $destinations = Destination::all();
        return view('admin.activities.edit', compact('activity', 'destinations'));
    }

    /**
     * Update the activity.
     */
    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required|string|max:255',
            'cost_adult' => 'required|numeric|min:0',
            'cost_child' => 'nullable|numeric|min:0',
            'cost_infant' => 'nullable|numeric|min:0',
        ]);

        $this->activityService->updateActivity($activity, $data);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the activity.
     */
    public function destroy(Activity $activity)
    {
        $this->activityService->deleteActivity($activity);
        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
}
