<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Faq;
use App\Services\TourService;
use Illuminate\Http\Request;

class TourController extends Controller
{
    protected $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }

    public function index()
    {
        $tours = $this->tourService->getAllTours();
        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $destinations = Destination::orderBy('name')->get();
        $faqs = Faq::orderBy('question')->get();
        $additionalInclusions = \App\Models\AdditionalInclusion::orderBy('name')->get();
        $allTours = Tour::orderBy('name')->get();

        return view('admin.tours.create', compact('categories', 'destinations', 'faqs', 'additionalInclusions', 'allTours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tours,slug',
            'overview' => 'nullable|string',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'required|array',
            'destination_id.*' => 'exists:destinations,id',
            'original_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:per_person,per_vehicle,per_group',
            'duration_days' => 'nullable|integer|min:0',
            'duration_nights' => 'nullable|integer|min:0',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'min_guests' => 'nullable|integer|min:0',
            'max_guests' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'faqs' => 'nullable|array',
            'faqs.*' => 'exists:faqs,id',
            'additional_inclusions' => 'nullable|array',
            'additional_inclusions.*' => 'exists:additional_inclusions,id',
            'related_tours' => 'nullable|array',
            'related_tours.*' => 'exists:tours,id',
            'itineraries' => 'nullable|array',
            'itineraries.*.title' => 'required_with:itineraries|string|max:255',
            'itineraries.*.description' => 'nullable|string',
        ], [
            'itineraries.*.title.required_with' => 'The itinerary title is required.',
            'category_id.required' => 'The category field is required.',
            'destination_id.required' => 'The destination field is required.',
        ]);

        $this->tourService->createTour($validated);

        return redirect('/admin/tours')->with('success', 'Tour created successfully.');
    }

    public function edit(Tour $tour)
    {
        $categories = Category::orderBy('name')->get();
        $destinations = Destination::orderBy('name')->get();
        $faqs = Faq::orderBy('question')->get();
        $additionalInclusions = \App\Models\AdditionalInclusion::orderBy('name')->get();
        $allTours = Tour::where('id', '!=', $tour->id)->orderBy('name')->get();
        
        $tour->load('itineraries', 'faqs', 'images');

        return view('admin.tours.edit', compact('tour', 'categories', 'destinations', 'faqs', 'additionalInclusions', 'allTours'));
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tours,slug,' . $tour->id,
            'overview' => 'nullable|string',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'required|array',
            'destination_id.*' => 'exists:destinations,id',
            'original_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:per_person,per_vehicle,per_group',
            'duration_days' => 'nullable|integer|min:0',
            'duration_nights' => 'nullable|integer|min:0',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'min_guests' => 'nullable|integer|min:0',
            'max_guests' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'faqs' => 'nullable|array',
            'faqs.*' => 'exists:faqs,id',
            'additional_inclusions' => 'nullable|array',
            'additional_inclusions.*' => 'exists:additional_inclusions,id',
            'related_tours' => 'nullable|array',
            'related_tours.*' => 'exists:tours,id',
            'itineraries' => 'nullable|array',
            'itineraries.*.title' => 'required_with:itineraries|string|max:255',
            'itineraries.*.description' => 'nullable|string',
        ], [
            'itineraries.*.title.required_with' => 'The itinerary title is required.',
            'category_id.required' => 'The category field is required.',
            'destination_id.required' => 'The destination field is required.',
        ]);

        $this->tourService->updateTour($tour, $validated);

        return redirect('/admin/tours')->with('success', 'Tour updated successfully.');
    }

    public function destroy(Tour $tour)
    {
        $this->tourService->deleteTour($tour);
        return redirect('/admin/tours')->with('success', 'Tour deleted successfully.');
    }

    public function deleteImage($id)
    {
        $image = \App\Models\TourImage::findOrFail($id);
        $this->tourService->deleteImage($image);
        return response()->json(['success' => true]);
    }

    public function inclusionIndex()
    {
        $inclusions = $this->tourService->getAllInclusions();
        return view('admin.inclusions.index', compact('inclusions'));
    }

    public function inclusionCreate()
    {
        return view('admin.inclusions.create');
    }

    public function inclusionStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $this->tourService->createInclusion($validated);

        return redirect('/admin/additional-inclusions')->with('success', 'Inclusion created successfully.');
    }

    public function inclusionEdit($id)
    {
        $inclusion = \App\Models\AdditionalInclusion::findOrFail($id);
        return view('admin.inclusions.edit', compact('inclusion'));
    }

    public function inclusionUpdate(Request $request, $id)
    {
        $inclusion = \App\Models\AdditionalInclusion::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $this->tourService->updateInclusion($inclusion, $validated);

        return redirect('/admin/additional-inclusions')->with('success', 'Inclusion updated successfully.');
    }

    public function inclusionDestroy($id)
    {
        $inclusion = \App\Models\AdditionalInclusion::findOrFail($id);
        $this->tourService->deleteInclusion($inclusion);

        return redirect('/admin/additional-inclusions')->with('success', 'Inclusion deleted successfully.');
    }

    public function exclusionIndex()
    {
        $exclusions = $this->tourService->getAllExclusions();
        return view('admin.exclusions.index', compact('exclusions'));
    }

    public function exclusionCreate()
    {
        return view('admin.exclusions.create');
    }

    public function exclusionStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $this->tourService->createExclusion($validated);

        return redirect('/admin/additional-exclusions')->with('success', 'Exclusion created successfully.');
    }

    public function exclusionEdit($id)
    {
        $exclusion = \App\Models\AdditionalExclusion::findOrFail($id);
        return view('admin.exclusions.edit', compact('exclusion'));
    }

    public function exclusionUpdate(Request $request, $id)
    {
        $exclusion = \App\Models\AdditionalExclusion::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $this->tourService->updateExclusion($exclusion, $validated);

        return redirect('/admin/additional-exclusions')->with('success', 'Exclusion updated successfully.');
    }

    public function exclusionDestroy($id)
    {
        $exclusion = \App\Models\AdditionalExclusion::findOrFail($id);
        $this->tourService->deleteExclusion($exclusion);

        return redirect('/admin/additional-exclusions')->with('success', 'Exclusion deleted successfully.');
    }

    public function toggleStatus(Tour $tour)
    {
        $tour->status = $tour->status == 1 ? 0 : 1;
        $tour->save();

        return response()->json([
            'success' => true,
            'status' => $tour->status,
            'message' => 'Tour status updated successfully.'
        ]);
    }

    public function mealIndex()
    {
        $meals = $this->tourService->getAllMeals();
        return view('admin.meals.index', compact('meals'));
    }

    public function mealCreate()
    {
        return view('admin.meals.create');
    }

    public function mealStore(Request $request)
    {
        $validated = $request->validate([
            'meal' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->tourService->createMeal($validated);

        return redirect('/admin/meals')->with('success', 'Meal created successfully.');
    }

    public function mealEdit($id)
    {
        $meal = \App\Models\Meal::findOrFail($id);
        return view('admin.meals.edit', compact('meal'));
    }

    public function mealUpdate(Request $request, $id)
    {
        $meal = \App\Models\Meal::findOrFail($id);
        $validated = $request->validate([
            'meal' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->tourService->updateMeal($meal, $validated);

        return redirect('/admin/meals')->with('success', 'Meal updated successfully.');
    }

    public function mealDestroy($id)
    {
        $meal = \App\Models\Meal::findOrFail($id);
        $this->tourService->deleteMeal($meal);

        return redirect('/admin/meals')->with('success', 'Meal deleted successfully.');
    }
}
