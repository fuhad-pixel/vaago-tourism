<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Services\WebsiteService;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    protected $websiteService;

    public function __construct(WebsiteService $websiteService)
    {
        $this->websiteService = $websiteService;
    }

    /**
     * Display a listing of the sliders.
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.settings.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new slider.
     */
    public function create()
    {
        return view('admin.settings.slider.create');
    }

    /**
     * Store a newly created slider in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $this->websiteService->createSlider($validated, $request);

        return redirect('/admin/settings/slider')->with('success', 'Slider created successfully.');
    }

    /**
     * Show the form for editing the specified slider.
     */
    public function edit(Slider $slider)
    {
        return view('admin.settings.slider.edit', compact('slider'));
    }

    /**
     * Update the specified slider in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $this->websiteService->updateSlider($slider, $validated, $request);

        return redirect('/admin/settings/slider')->with('success', 'Slider updated successfully.');
    }

    /**
     * Remove the specified slider from storage.
     */
    public function destroy(Slider $slider)
    {
        $this->websiteService->deleteSlider($slider);
        return redirect('/admin/settings/slider')->with('success', 'Slider deleted successfully.');
    }

    /**
     * Display a listing of the testimonials.
     */
    public function testimonialIndex()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.settings.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function testimonialCreate()
    {
        return view('admin.settings.testimonial.create');
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function testimonialStore(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'client_dp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $this->websiteService->createTestimonial($validated, $request);

        return redirect('/admin/settings/testimonial')->with('success', 'Testimonial created successfully.');
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function testimonialEdit(Testimonial $testimonial)
    {
        return view('admin.settings.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function testimonialUpdate(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'client_dp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $this->websiteService->updateTestimonial($testimonial, $validated, $request);

        return redirect('/admin/settings/testimonial')->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified testimonial from storage.
     */
    public function testimonialDestroy(Testimonial $testimonial)
    {
        $this->websiteService->deleteTestimonial($testimonial);
        return redirect('/admin/settings/testimonial')->with('success', 'Testimonial deleted successfully.');
    }
}
