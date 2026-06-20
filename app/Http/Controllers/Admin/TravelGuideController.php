<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TravelGuideController extends Controller
{
    public function index()
    {
        $guides = \App\Models\TravelGuide::latest()->get();
        $statusModule = \App\Models\SystemModule::firstOrCreate(
            ['key' => 'travel_guide_status'],
            ['value' => '0']
        );
        $travel_guide_status = $statusModule->value;

        return view('admin.travel_guides.index', compact('guides', 'travel_guide_status'));
    }

    public function create()
    {
        return view('admin.travel_guides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'designation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'address' => 'nullable|string',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/guides'), $imageName);
            $data['photo'] = 'assets/images/guides/' . $imageName;
        }

        \App\Models\TravelGuide::create($data);

        return redirect('/admin/travel-guides')->with('success', 'Travel Guide created successfully.');
    }

    public function edit($id)
    {
        $guide = \App\Models\TravelGuide::findOrFail($id);
        return view('admin.travel_guides.edit', compact('guide'));
    }

    public function update(Request $request, $id)
    {
        $guide = \App\Models\TravelGuide::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'designation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'address' => 'nullable|string',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($guide->photo && file_exists(public_path($guide->photo))) {
                unlink(public_path($guide->photo));
            }
            $image = $request->file('photo');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/guides'), $imageName);
            $data['photo'] = 'assets/images/guides/' . $imageName;
        }

        $guide->update($data);

        return redirect('/admin/travel-guides')->with('success', 'Travel Guide updated successfully.');
    }

    public function destroy($id)
    {
        $guide = \App\Models\TravelGuide::findOrFail($id);

        if ($guide->photo && file_exists(public_path($guide->photo))) {
            unlink(public_path($guide->photo));
        }

        $guide->delete();

        return redirect('/admin/travel-guides')->with('success', 'Travel Guide deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $statusModule = \App\Models\SystemModule::firstOrCreate(
            ['key' => 'travel_guide_status'],
            ['value' => '0']
        );
        
        $newValue = $request->status == '1' ? '1' : '0';
        $statusModule->update(['value' => $newValue]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully.', 'status' => $newValue]);
    }
}
