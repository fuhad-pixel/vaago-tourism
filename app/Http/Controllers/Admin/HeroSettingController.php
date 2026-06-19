<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSetting;
use Illuminate\Support\Str;

class HeroSettingController extends Controller
{
    public function index()
    {
        $pages = ['about', 'destinations', 'blog', 'contact', 'tours'];
        foreach ($pages as $page) {
            HeroSetting::firstOrCreate(
                ['page_name' => $page],
                ['title' => ucfirst($page)]
            );
        }
        $settings = HeroSetting::all()->keyBy('page_name');
        return view('admin.settings.hero', compact('settings'));
    }

    public function update(Request $request)
    {
        $pages = ['about', 'destinations', 'blog', 'contact', 'tours'];
        
        foreach ($pages as $page) {
            $setting = HeroSetting::firstOrNew(['page_name' => $page]);

            // Update title and description
            $setting->title = $request->input("{$page}_title", $setting->title ?? ucfirst($page));
            $setting->description = $request->input("{$page}_description");

            // Handle image upload if provided
            if ($request->hasFile("{$page}_image")) {
                $file = $request->file("{$page}_image");
                
                // Validate image
                $request->validate([
                    "{$page}_image" => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                ]);

                // Store image
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/hero'), $filename);
                
                // Delete old image if it was uploaded
                if ($setting->image_path && Str::startsWith($setting->image_path, 'uploads/')) {
                    $oldPath = public_path($setting->image_path);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $setting->image_path = 'uploads/hero/' . $filename;
            }

            $setting->save();
        }

        return redirect()->back()->with('success', 'Hero settings updated successfully.');
    }
}
