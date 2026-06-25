<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = \App\Models\Driver::latest()->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/drivers'), $imageName);
            $data['photo'] = 'assets/images/drivers/' . $imageName;
        }

        \App\Models\Driver::create($data);

        return redirect('/admin/drivers')->with('success', 'Driver created successfully.');
    }

    public function edit($id)
    {
        $driver = \App\Models\Driver::findOrFail($id);
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $driver = \App\Models\Driver::findOrFail($id);

        $request->validate([
            'driver_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($driver->photo && file_exists(public_path($driver->photo))) {
                unlink(public_path($driver->photo));
            }
            $image = $request->file('photo');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/drivers'), $imageName);
            $data['photo'] = 'assets/images/drivers/' . $imageName;
        }

        $driver->update($data);

        return redirect('/admin/drivers')->with('success', 'Driver updated successfully.');
    }

    public function destroy($id)
    {
        $driver = \App\Models\Driver::findOrFail($id);

        if ($driver->photo && file_exists(public_path($driver->photo))) {
            unlink(public_path($driver->photo));
        }

        $driver->delete();

        return redirect('/admin/drivers')->with('success', 'Driver deleted successfully.');
    }
}
