<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\AboutSetting;
use Illuminate\Support\Facades\Storage;

class PageSettingController extends Controller
{
    public function home()
    {
        $header = Service::firstOrCreate(
            ['type' => 'header'],
            [
                'title' => 'It’s Time to Travel with our Company',
                'description' => 'our services'
            ]
        );

        $services = Service::where('type', 'card')->orderBy('sort_order', 'asc')->get();
        $about = AboutSetting::firstOrCreate(['id' => 1]);

        return view('admin.settings.pages.home', compact('header', 'services', 'about'));
    }

    public function updateHomeHeader(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $header = Service::where('type', 'header')->first();
        if ($header) {
            $header->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }

        return redirect()->back()->with('success', 'Header updated successfully');
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'header_title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $about = AboutSetting::firstOrCreate(['id' => 1]);

        $data = [
            'header_title' => $request->header_title,
            'subtitle' => $request->subtitle,
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($about->image_path && file_exists(public_path($about->image_path))) {
                unlink(public_path($about->image_path));
            }
            $imageName = time() . '_about.' . $request->image->extension();
            $request->image->move(public_path('uploads/about'), $imageName);
            $data['image_path'] = 'uploads/about/' . $imageName;
        }

        $about->update($data);

        return redirect()->back()->with('success', 'About Us section updated successfully');
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $data = [
            'type' => 'card',
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'sort_order' => Service::where('type', 'card')->count() + 1,
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '_bg.' . $request->image->extension();
            $request->image->move(public_path('uploads/services'), $imageName);
            $data['image_path'] = 'uploads/services/' . $imageName;
        }

        if ($request->hasFile('icon')) {
            $iconName = time() . '_icon.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/services'), $iconName);
            $data['icon_path'] = 'uploads/services/' . $iconName;
        }

        Service::create($data);

        return redirect()->back()->with('success', 'Service card added successfully');
    }

    public function updateService(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $service = Service::findOrFail($id);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ];

        if ($request->hasFile('image')) {
            if ($service->image_path && file_exists(public_path($service->image_path))) {
                unlink(public_path($service->image_path));
            }
            $imageName = time() . '_bg.' . $request->image->extension();
            $request->image->move(public_path('uploads/services'), $imageName);
            $data['image_path'] = 'uploads/services/' . $imageName;
        }

        if ($request->hasFile('icon')) {
            if ($service->icon_path && file_exists(public_path($service->icon_path))) {
                unlink(public_path($service->icon_path));
            }
            $iconName = time() . '_icon.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/services'), $iconName);
            $data['icon_path'] = 'uploads/services/' . $iconName;
        }

        $service->update($data);

        return redirect()->back()->with('success', 'Service card updated successfully');
    }

    public function destroyService($id)
    {
        $service = Service::findOrFail($id);
        
        if ($service->image_path && file_exists(public_path($service->image_path))) {
            unlink(public_path($service->image_path));
        }
        if ($service->icon_path && file_exists(public_path($service->icon_path))) {
            unlink(public_path($service->icon_path));
        }
        
        $service->delete();

        return redirect()->back()->with('success', 'Service card deleted successfully');
    }

    public function reorderServices(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:services,id',
            'order.*.position' => 'required|integer',
        ]);

        foreach ($request->order as $item) {
            Service::where('id', $item['id'])->update(['sort_order' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }
}
