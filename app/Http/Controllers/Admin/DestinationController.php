<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\ParentDestination;
use App\Services\DestinationService;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    protected $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    /**
     * Display a listing of destinations.
     */
    public function index()
    {
        $destinations = $this->destinationService->getAllDestinations();
        $parentDestinations = $this->destinationService->getAllParentDestinations();
        return view('admin.destinations.index', compact('destinations', 'parentDestinations'));
    }

    /**
     * Show the form for creating a new destination.
     */
    public function create(Request $request)
    {
        $isParent = $request->query('type') === 'parent';
        $parentDestinations = ParentDestination::all();
        return view('admin.destinations.create', compact('isParent', 'parentDestinations'));
    }

    /**
     * Store a newly created destination in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'parent_destination_id' => 'nullable|exists:parent_destinations,id',
        ]);

        $this->destinationService->createDestination($validated);

        return redirect('/admin/destinations')->with('success', 'Destination created successfully.');
    }

    /**
     * Show the form for editing the specified destination.
     */
    public function edit(Destination $destination)
    {
        $isParent = false;
        $parentDestinations = ParentDestination::all();
        return view('admin.destinations.edit', compact('destination', 'isParent', 'parentDestinations'));
    }

    /**
     * Update the specified destination in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'parent_destination_id' => 'nullable|exists:parent_destinations,id',
        ]);

        $this->destinationService->updateDestination($destination, $validated);

        return redirect('/admin/destinations')->with('success', 'Destination updated successfully.');
    }

    /**
     * Remove the specified destination from storage.
     */
    public function destroy(Destination $destination)
    {
        $this->destinationService->deleteDestination($destination);
        return redirect('/admin/destinations')->with('success', 'Destination deleted successfully.');
    }

    /**
     * Store a newly created parent destination.
     */
    public function storeParent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $this->destinationService->createParentDestination($validated);

        return redirect('/admin/destinations')->with('success', 'Parent destination created successfully.');
    }

    /**
     * Show the form for editing the specified parent destination.
     */
    public function editParent(ParentDestination $parentDestination)
    {
        $isParent = true;
        // Re-use the existing view but pass the parent destination object as $destination
        $destination = $parentDestination;
        return view('admin.destinations.edit', compact('destination', 'isParent'));
    }

    /**
     * Update the specified parent destination in storage.
     */
    public function updateParent(Request $request, ParentDestination $parentDestination)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $this->destinationService->updateParentDestination($parentDestination, $validated);

        return redirect('/admin/destinations')->with('success', 'Parent destination updated successfully.');
    }

    /**
     * Remove the specified parent destination from storage.
     */
    public function destroyParent(ParentDestination $parentDestination)
    {
        $this->destinationService->deleteParentDestination($parentDestination);
        return redirect('/admin/destinations')->with('success', 'Parent destination deleted successfully.');
    }
}
