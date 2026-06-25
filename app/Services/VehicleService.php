<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Support\Facades\File;

class VehicleService
{
    /**
     * Get all vehicles.
     */
    public function getAllVehicles()
    {
        return Vehicle::latest()->get();
    }

    /**
     * Create a new vehicle.
     */
    public function createVehicle(array $data): Vehicle
    {
        $imagePath = null;
        if (isset($data['image']) && $data['image']->isValid()) {
            $imagePath = $this->uploadImage($data['image']);
        }

        return Vehicle::create([
            'vehicle_name' => $data['vehicle_name'],
            'type' => $data['type'],
            'seating' => $data['seating'],
            'cost_type' => $data['cost_type'],
            'cost' => $data['cost'],
            'image' => $imagePath,
        ]);
    }

    /**
     * Update an existing vehicle.
     */
    public function updateVehicle(Vehicle $vehicle, array $data): Vehicle
    {
        $updateData = [
            'vehicle_name' => $data['vehicle_name'],
            'type' => $data['type'],
            'seating' => $data['seating'],
            'cost_type' => $data['cost_type'],
            'cost' => $data['cost'],
        ];

        if (isset($data['image']) && $data['image']->isValid()) {
            // Delete old image if it exists
            $this->deleteImageFile($vehicle->image);
            $updateData['image'] = $this->uploadImage($data['image']);
        }

        $vehicle->update($updateData);

        return $vehicle;
    }

    /**
     * Delete a vehicle.
     */
    public function deleteVehicle(Vehicle $vehicle): bool
    {
        $this->deleteImageFile($vehicle->image);
        return $vehicle->delete();
    }

    /**
     * Upload vehicle image.
     */
    protected function uploadImage($file): string
    {
        $uploadPath = public_path('uploads/vehicles');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        return 'uploads/vehicles/' . $filename;
    }

    /**
     * Delete image file helper.
     */
    protected function deleteImageFile($path): void
    {
        if ($path) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
