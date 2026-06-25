<?php

namespace App\Services;

use App\Models\Hotel;
use App\Models\HotelRoomRate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HotelService
{
    /**
     * Get all hotels with destinations.
     */
    public function getAllHotels()
    {
        return Hotel::with('destination')->latest()->get();
    }

    /**
     * Create a new hotel.
     */
    public function createHotel(array $data)
    {
        $roomRates = $data['room_rates'] ?? [];
        unset($data['room_rates']);

        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        $hotel = Hotel::create($this->prepareData($data));

        foreach ($roomRates as $rate) {
            $this->addRoomRate($hotel, $rate);
        }

        return $hotel;
    }

    /**
     * Update an existing hotel.
     */
    public function updateHotel(Hotel $hotel, array $data)
    {
        if (isset($data['image'])) {
            if ($hotel->image) {
                $this->deleteImage($hotel->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        }

        $hotel->update($this->prepareData($data));
        return $hotel;
    }

    /**
     * Delete a hotel and its image.
     */
    public function deleteHotel(Hotel $hotel)
    {
        if ($hotel->image) {
            $this->deleteImage($hotel->image);
        }
        return $hotel->delete();
    }

    /**
     * Delete a hotel image explicitly.
     */
    public function deleteHotelImage(Hotel $hotel)
    {
        if ($hotel->image) {
            $this->deleteImage($hotel->image);
            $hotel->update(['image' => null]);
            return true;
        }
        return false;
    }

    /**
     * Add a room rate to a hotel.
     */
    public function addRoomRate(Hotel $hotel, array $data)
    {
        $data['hotel_id'] = $hotel->id;
        
        // Convert empty strings to null for nullable fields
        foreach (['meal_plan', 'season'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        return HotelRoomRate::create($data);
    }

    /**
     * Delete a room rate.
     */
    public function deleteRoomRate(HotelRoomRate $rate)
    {
        return $rate->delete();
    }

    /**
     * Prepare data for creation/update by cleaning up empty values.
     */
    private function prepareData(array $data)
    {
        $nullableFields = ['description', 'star_rating', 'contact_person', 'phone', 'address'];
        
        foreach ($nullableFields as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        return $data;
    }

    /**
     * Upload hotel image.
     */
    private function uploadImage($file)
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/hotels'), $filename);
        return 'uploads/hotels/' . $filename;
    }

    /**
     * Delete image file.
     */
    private function deleteImage($path)
    {
        if (file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
}
