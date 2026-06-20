<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home() { 
        $latestBlogs = \App\Models\Blog::with('images')->latest()->take(3)->get();
        $testimonials = \App\Models\Testimonial::latest()->get();
        $sliders = \App\Models\Slider::latest()->get();
        
        // Manual tour count for JSON array
        $destinations = \App\Models\Destination::latest()->get()->map(function($destination) {
            $destination->tours_count = \App\Models\Tour::where('status', 1)->whereJsonContains('destination_id', (string)$destination->id)->count();
            return $destination;
        });

        $tours = \App\Models\Tour::where('status', 1)->with(['images', 'category'])->latest()->take(6)->get();
        $categories = \App\Models\Category::orderBy('name')->get();
        
        $serviceHeader = \App\Models\Service::where('type', 'header')->first();
        $services = \App\Models\Service::where('type', 'card')->orderBy('sort_order', 'asc')->take(5)->get();

        return view('pages.home', compact('latestBlogs', 'testimonials', 'destinations', 'sliders', 'tours', 'categories', 'serviceHeader', 'services')); 
    }
    public function about() { 
        $hero_setting = \App\Models\HeroSetting::where('page_name', 'about')->first();
        $about_setting = \App\Models\AboutSetting::first();
        
        $statusModule = \App\Models\SystemModule::where('key', 'travel_guide_status')->first();
        $travel_guide_status = $statusModule ? $statusModule->value : '0';
        $travel_guides = $travel_guide_status == '1' ? \App\Models\TravelGuide::all() : collect();

        return view('pages.about', compact('hero_setting', 'about_setting', 'travel_guide_status', 'travel_guides')); 
    }
    public function destination() { 
        $destinations = \App\Models\Destination::orderBy('name')->get()->map(function($destination) {
            $destination->tours_count = \App\Models\Tour::where('status', 1)->whereJsonContains('destination_id', (string)$destination->id)->count();
            return $destination;
        });
        $hero_setting = \App\Models\HeroSetting::where('page_name', 'destinations')->first();
        return view('pages.destination', compact('destinations', 'hero_setting')); 
    }
    public function tours(Request $request) { 
        $query = \App\Models\Tour::where('status', 1)->with(['images', 'category'])->latest();

        if ($request->filled('destination_id')) {
            try {
                $decryptedId = decrypt($request->destination_id);
                $request->merge(['destination_id' => $decryptedId]);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Fallback to original value if it is not encrypted
            }
            $query->whereJsonContains('destination_id', (string)$request->destination_id);
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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('overview', 'like', "%{$search}%");
            });
        }

        $tours = $query->paginate(9)->withQueryString();
        $destinations = \App\Models\Destination::orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('name')->get();
        $hero_setting = \App\Models\HeroSetting::where('page_name', 'tours')->first();

        return view('pages.tours', compact('tours', 'destinations', 'categories', 'hero_setting')); 
    }
    public function hotel() { return view('pages.hotel'); }
    public function blog() { 
        $blogs = \App\Models\Blog::with('images')->latest()->paginate(9);
        $hero_setting = \App\Models\HeroSetting::where('page_name', 'blog')->first();
        return view('pages.blog', compact('blogs', 'hero_setting')); 
    }
    public function blogSingle($slug) { 
        $blog = \App\Models\Blog::with('images')->where('slug', $slug)->firstOrFail();
        $recentBlogs = \App\Models\Blog::with('images')->latest()->take(3)->get();
        return view('pages.blog-single', compact('blog', 'recentBlogs')); 
    }
    public function tourDetail($slug) {
        $tour = \App\Models\Tour::where('status', 1)->with(['images', 'category', 'itineraries', 'faqs'])->where('slug', $slug)->firstOrFail();
        
        $additionalInclusions = collect();
        if ($tour->additional_inclusions && is_array($tour->additional_inclusions)) {
            $additionalInclusions = \App\Models\AdditionalInclusion::whereIn('id', $tour->additional_inclusions)->get();
        }

        return view('pages.tour-detail', compact('tour', 'additionalInclusions'));
    }
    public function contact(Request $request) {
        $tour = null;
        if ($request->has('tour')) {
            $tour = \App\Models\Tour::where('status', 1)->where('slug', $request->query('tour'))->first();
        }
        $hero_setting = \App\Models\HeroSetting::where('page_name', 'contact')->first();
        return view('pages.contact', compact('tour', 'hero_setting'));
    }

    public function ajaxSearch(Request $request) {
        $q = $request->query('q');
        if (!$q) {
            return response()->json([]);
        }

        $results = [];

        // Search Categories
        $categories = \App\Models\Category::where('name', 'like', "%{$q}%")->take(5)->get();
        foreach ($categories as $category) {
            $results[] = [
                'id' => $category->id,
                'title' => $category->name,
                'type' => 'category',
                'url' => url('/tours?category_id=' . $category->id),
                'icon' => '<i class="fal fa-tags"></i>'
            ];
        }

        // Search Destinations
        $destinations = \App\Models\Destination::where('name', 'like', "%{$q}%")->take(5)->get();
        foreach ($destinations as $destination) {
            $results[] = [
                'id' => $destination->id,
                'title' => $destination->name,
                'type' => 'destination',
                'url' => url('/tours?destination_id=' . $destination->id),
                'icon' => '<i class="fal fa-map-marker-alt"></i>'
            ];
        }

        // Search Tours
        $tours = \App\Models\Tour::where('status', 1)
                                 ->where(function($query) use ($q) {
                                     $query->where('name', 'like', "%{$q}%")
                                           ->orWhere('tour_code', 'like', "%{$q}%");
                                 })
                                 ->take(5)->get();
        foreach ($tours as $tour) {
            $results[] = [
                'id' => $tour->id,
                'title' => $tour->name,
                'type' => 'tour',
                'url' => url('/tour/' . $tour->slug),
                'icon' => '<i class="fal fa-compass"></i>'
            ];
        }

        return response()->json($results);
    }
}
