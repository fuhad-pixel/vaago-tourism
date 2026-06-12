<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home() { 
        $latestBlogs = \App\Models\Blog::with('images')->latest()->take(3)->get();
        $testimonials = \App\Models\Testimonial::latest()->get();
        $destinations = \App\Models\Destination::withCount('tours')->latest()->get();
        $sliders = \App\Models\Slider::latest()->get();
        $tours = \App\Models\Tour::with(['destination', 'images', 'category'])->latest()->take(6)->get();
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('pages.home', compact('latestBlogs', 'testimonials', 'destinations', 'sliders', 'tours', 'categories')); 
    }
    public function about() { return view('pages.about'); }
    public function destination(Request $request) { 
        $query = \App\Models\Tour::with(['destination', 'images', 'category'])->latest();

        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('price')) {
            $priceLimit = (float) $request->price;
            $query->where(function($q) use ($priceLimit) {
                $q->where(function($sub) use ($priceLimit) {
                    $sub->whereNotNull('discount_price')
                        ->where('discount_price', '<=', $priceLimit);
                })->orWhere(function($sub) use ($priceLimit) {
                    $sub->whereNull('discount_price')
                        ->where('original_price', '<=', $priceLimit);
                });
            });
        }

        $tours = $query->paginate(9)->withQueryString();
        $destinations = \App\Models\Destination::orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('pages.destination', compact('tours', 'destinations', 'categories')); 
    }
    public function hotel() { return view('pages.hotel'); }
    public function blog() { 
        $blogs = \App\Models\Blog::with('images')->latest()->paginate(9);
        return view('pages.blog', compact('blogs')); 
    }
    public function blogSingle($slug) { 
        $blog = \App\Models\Blog::with('images')->where('slug', $slug)->firstOrFail();
        $recentBlogs = \App\Models\Blog::with('images')->latest()->take(3)->get();
        return view('pages.blog-single', compact('blog', 'recentBlogs')); 
    }
    public function tourDetail($slug) {
        $tour = \App\Models\Tour::with(['destination', 'images', 'category', 'itineraries', 'faqs'])->where('slug', $slug)->firstOrFail();
        
        $additionalInclusions = collect();
        if ($tour->additional_inclusions && is_array($tour->additional_inclusions)) {
            $additionalInclusions = \App\Models\AdditionalInclusion::whereIn('id', $tour->additional_inclusions)->get();
        }

        return view('pages.tour-detail', compact('tour', 'additionalInclusions'));
    }
    public function contact(Request $request) {
        $tour = null;
        if ($request->has('tour')) {
            $tour = \App\Models\Tour::where('slug', $request->query('tour'))->first();
        }
        return view('pages.contact', compact('tour'));
    }
}
