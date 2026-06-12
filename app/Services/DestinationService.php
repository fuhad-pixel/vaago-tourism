<?php

namespace App\Services;

use App\Models\Destination;
use Illuminate\Support\Facades\File;

class DestinationService
{
    /**
     * Get all destinations.
     */
    public function getAllDestinations()
    {
        return Destination::latest()->get();
    }

    /**
     * Create a new destination.
     */
    public function createDestination(array $data): Destination
    {
        $imagePath = null;
        if (isset($data['image']) && $data['image']->isValid()) {
            $imagePath = $this->uploadImage($data['image']);
        }

        return Destination::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'image' => $imagePath,
        ]);
    }

    /**
     * Update an existing destination.
     */
    public function updateDestination(Destination $destination, array $data): Destination
    {
        $updateData = [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ];

        if (isset($data['image']) && $data['image']->isValid()) {
            // Delete old image if it exists
            $this->deleteImageFile($destination->image);
            $updateData['image'] = $this->uploadImage($data['image']);
        }

        $destination->update($updateData);

        return $destination;
    }

    /**
     * Soft delete a destination.
     */
    public function deleteDestination(Destination $destination): bool
    {
        return $destination->delete();
    }

    /**
     * Upload destination image.
     */
    protected function uploadImage($file): string
    {
        $uploadPath = public_path('uploads/destinations');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        return 'uploads/destinations/' . $filename;
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
