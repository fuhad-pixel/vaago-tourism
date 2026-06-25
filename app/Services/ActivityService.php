<?php

namespace App\Services;

use App\Models\Activity;

class ActivityService
{
    /**
     * Get all activities with destinations.
     */
    public function getAllActivities()
    {
        return Activity::with('destination')->latest()->get();
    }

    /**
     * Create a new activity.
     */
    public function createActivity(array $data)
    {
        return Activity::create($this->prepareData($data));
    }

    /**
     * Update an existing activity.
     */
    public function updateActivity(Activity $activity, array $data)
    {
        $activity->update($this->prepareData($data));
        return $activity;
    }

    /**
     * Delete an activity.
     */
    public function deleteActivity(Activity $activity)
    {
        return $activity->delete();
    }

    /**
     * Prepare data by setting empty nullable fields to their defaults.
     */
    private function prepareData(array $data)
    {
        $nullableFields = ['cost_child', 'cost_infant'];
        
        foreach ($nullableFields as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = 0;
            }
        }

        return $data;
    }
}
