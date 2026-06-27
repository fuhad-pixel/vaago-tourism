<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Services\LeadService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    protected $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    /**
     * Display a listing of the leads.
     */
    public function index()
    {
        $leads = $this->leadService->getAllLeads();
        return view('admin.leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new lead.
     */
    public function create()
    {
        $users = User::all();
        $statuses = ['New', 'Contacted', 'Proposal Sent', 'Negotiating', 'Confirmed', 'Cancelled', 'Lost'];
        $countries = \App\Models\Country::all();
        return view('admin.leads.create', compact('users', 'statuses', 'countries'));
    }

    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'adults' => 'nullable|integer|min:0',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'arrival_date' => 'nullable|date',
            'departure_date' => 'nullable|date|after_or_equal:arrival_date',
            'source' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:New,Contacted,Proposal Sent,Negotiating,Confirmed,Cancelled,Lost',
        ]);

        $this->leadService->createLead($data);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit(Lead $lead)
    {
        $users = User::all();
        $statuses = ['New', 'Contacted', 'Proposal Sent', 'Negotiating', 'Confirmed', 'Cancelled', 'Lost'];
        $countries = \App\Models\Country::all();
        return view('admin.leads.edit', compact('lead', 'users', 'statuses', 'countries'));
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'adults' => 'nullable|integer|min:0',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'arrival_date' => 'nullable|date',
            'departure_date' => 'nullable|date|after_or_equal:arrival_date',
            'source' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:New,Contacted,Proposal Sent,Negotiating,Confirmed,Cancelled,Lost',
        ]);

        $this->leadService->updateLead($lead, $data);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified lead from storage.
     */
    public function destroy(Lead $lead)
    {
        $this->leadService->deleteLead($lead);
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}
