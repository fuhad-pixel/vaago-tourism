<?php

namespace App\Services;

use App\Models\Lead;

class LeadService
{
    /**
     * Get all leads with assigned user relationship.
     */
    public function getAllLeads()
    {
        return Lead::with('assignedTo')->latest()->get();
    }

    /**
     * Create a new lead.
     */
    public function createLead(array $data)
    {
        return Lead::create($this->prepareData($data));
    }

    /**
     * Update an existing lead.
     */
    public function updateLead(Lead $lead, array $data)
    {
        $lead->update($this->prepareData($data));
        return $lead;
    }

    /**
     * Delete a lead (soft delete).
     */
    public function deleteLead(Lead $lead)
    {
        return $lead->delete();
    }

    /**
     * Prepare data for creation/update by cleaning up empty values.
     */
    private function prepareData(array $data)
    {
        // For fields that are nullable, convert empty strings to null.
        // This is especially important for foreign keys (assigned_to) and dates.
        $nullableFields = ['phone', 'country', 'adults', 'children', 'infants', 'arrival_date', 'departure_date', 'source', 'budget', 'notes', 'assigned_to'];
        
        foreach ($nullableFields as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        return $data;
    }
}
