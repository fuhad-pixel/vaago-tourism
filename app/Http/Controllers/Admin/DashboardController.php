<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTours = \App\Models\Tour::count();
        $activeTours = \App\Models\Tour::where('status', 1)->count();
        $totalBlogs = \App\Models\Blog::count();
        $totalEnquiries = \App\Models\Enquiry::count();

        $destinations = \App\Models\Destination::latest()->take(5)->get()->map(function($destination) {
            $destination->tours_count = \App\Models\Tour::whereJsonContains('destination_id', (string)$destination->id)->count();
            return $destination;
        });

        $recentEnquiries = \App\Models\Enquiry::latest()->take(5)->get();

        // Monthly enquiries data (last 6 months)
        $monthlyMonths = [];
        $monthlyEnquiries = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyMonths[] = $date->format('M Y');
            $monthlyEnquiries[] = \App\Models\Enquiry::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Category-wise active tours count
        $categoriesData = \App\Models\Category::withCount(['tours' => function($query) {
            $query->where('status', 1);
        }])->get();
        
        $categoryNames = $categoriesData->pluck('name')->toArray();
        $categoryCounts = $categoriesData->pluck('tours_count')->toArray();

        return view('admin.dashboard', compact(
            'totalTours', 'activeTours', 'totalBlogs', 'totalEnquiries', 
            'destinations', 'recentEnquiries', 
            'monthlyMonths', 'monthlyEnquiries', 
            'categoryNames', 'categoryCounts'
        ));
    }
}
