<?php

namespace App\Services;

use App\Models\Tour;
use App\Models\TourItinerary;
use Illuminate\Support\Str;

class TourService
{
    public function getAllTours()
    {
        return Tour::with(['category'])->latest()->get();
    }

    public function generateTourCode()
    {
        $latest = Tour::orderBy('id', 'desc')->first();
        if (!$latest) {
            return 'VG-00001';
        }
        $number = intval(str_replace('VG-', '', $latest->tour_code));
        return 'VG-' . str_pad($number + 1, 5, '0', STR_PAD_LEFT);
    }

    public function createTour(array $data)
    {
        $tourCode = $this->generateTourCode();
        
        $tour = Tour::create([
            'tour_code' => $tourCode,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'overview' => $data['overview'] ?? null,
            'inclusions' => $data['inclusions'] ?? null,
            'exclusions' => $data['exclusions'] ?? null,
            'terms_and_conditions' => $data['terms_and_conditions'] ?? null,
            'category_id' => $data['category_id'],
            'destination_id' => $data['destination_id'],
            'original_price' => $data['original_price'],
            'discount_price' => $data['discount_price'] ?? null,
            'price_type' => $data['price_type'],
            'duration_days' => $data['duration_days'] ?? 0,
            'duration_nights' => $data['duration_nights'] ?? 0,
            'duration_hours' => $data['duration_hours'] ?? 0,
            'duration_minutes' => $data['duration_minutes'] ?? 0,
            'min_guests' => $data['min_guests'] ?? null,
            'max_guests' => $data['max_guests'] ?? null,
            'additional_inclusions' => $data['additional_inclusions'] ?? null,
            'related_tours' => $data['related_tours'] ?? null,
        ]);

        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $image) {
                if ($image->isValid()) {
                    $imagePath = $this->uploadImage($image);
                    $tour->images()->create(['image_path' => $imagePath]);
                }
            }
        }

        if (isset($data['faqs'])) {
            $tour->faqs()->sync($data['faqs']);
        }

        if (isset($data['itineraries']) && is_array($data['itineraries'])) {
            foreach ($data['itineraries'] as $index => $itineraryData) {
                if (!empty($itineraryData['title'])) {
                    $tour->itineraries()->create([
                        'day_number' => $index + 1,
                        'title' => $itineraryData['title'],
                        'description' => $itineraryData['description'] ?? null,
                    ]);
                }
            }
        }

        return $tour;
    }

    public function updateTour(Tour $tour, array $data)
    {
        $tour->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'overview' => $data['overview'] ?? null,
            'inclusions' => $data['inclusions'] ?? null,
            'exclusions' => $data['exclusions'] ?? null,
            'terms_and_conditions' => $data['terms_and_conditions'] ?? null,
            'category_id' => $data['category_id'],
            'destination_id' => $data['destination_id'],
            'original_price' => $data['original_price'],
            'discount_price' => $data['discount_price'] ?? null,
            'price_type' => $data['price_type'],
            'duration_days' => $data['duration_days'] ?? 0,
            'duration_nights' => $data['duration_nights'] ?? 0,
            'duration_hours' => $data['duration_hours'] ?? 0,
            'duration_minutes' => $data['duration_minutes'] ?? 0,
            'min_guests' => $data['min_guests'] ?? null,
            'max_guests' => $data['max_guests'] ?? null,
            'additional_inclusions' => $data['additional_inclusions'] ?? null,
            'related_tours' => $data['related_tours'] ?? null,
        ]);

        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $image) {
                if ($image->isValid()) {
                    $imagePath = $this->uploadImage($image);
                    $tour->images()->create(['image_path' => $imagePath]);
                }
            }
        }

        if (isset($data['faqs'])) {
            $tour->faqs()->sync($data['faqs']);
        } else {
            $tour->faqs()->sync([]);
        }

        // Delete existing itineraries and recreate them to keep it simple
        $tour->itineraries()->delete();
        if (isset($data['itineraries']) && is_array($data['itineraries'])) {
            foreach ($data['itineraries'] as $index => $itineraryData) {
                if (!empty($itineraryData['title'])) {
                    $tour->itineraries()->create([
                        'day_number' => $index + 1,
                        'title' => $itineraryData['title'],
                        'description' => $itineraryData['description'] ?? null,
                    ]);
                }
            }
        }

        return $tour;
    }

    public function updateTourSeo(Tour $tour, array $data, $ogImage = null)
    {
        $seoData = [
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
            'og_title' => $data['og_title'] ?? null,
            'og_description' => $data['og_description'] ?? null,
        ];

        if ($ogImage && $ogImage->isValid()) {
            $seoData['og_image_path'] = $this->uploadImage($ogImage);
        }

        if ($tour->seo) {
            $tour->seo()->update($seoData);
        } else {
            $tour->seo()->create($seoData);
        }

        return $tour->seo;
    }

    public function deleteTour(Tour $tour)
    {
        return $tour->delete();
    }

    protected function uploadImage($file): string
    {
        $uploadPath = public_path('uploads/tours');
        if (!\Illuminate\Support\Facades\File::exists($uploadPath)) {
            \Illuminate\Support\Facades\File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        return 'uploads/tours/' . $filename;
    }

    public function deleteImage(\App\Models\TourImage $tourImage)
    {
        $fullPath = public_path($tourImage->image_path);
        if (\Illuminate\Support\Facades\File::exists($fullPath)) {
            \Illuminate\Support\Facades\File::delete($fullPath);
        }
        return $tourImage->delete();
    }

    public function getAllInclusions()
    {
        return \App\Models\AdditionalInclusion::latest()->get();
    }

    public function createInclusion(array $data)
    {
        return \App\Models\AdditionalInclusion::create([
            'name' => $data['name'],
            'icon' => $data['icon']
        ]);
    }

    public function updateInclusion(\App\Models\AdditionalInclusion $inclusion, array $data)
    {
        $inclusion->update([
            'name' => $data['name'],
            'icon' => $data['icon']
        ]);
        return $inclusion;
    }

    public function deleteInclusion(\App\Models\AdditionalInclusion $inclusion)
    {
        return $inclusion->delete();
    }

    public function getAllExclusions()
    {
        return \App\Models\AdditionalExclusion::latest()->get();
    }

    public function createExclusion(array $data)
    {
        return \App\Models\AdditionalExclusion::create([
            'name' => $data['name'],
            'icon' => $data['icon']
        ]);
    }

    public function updateExclusion(\App\Models\AdditionalExclusion $exclusion, array $data)
    {
        $exclusion->update([
            'name' => $data['name'],
            'icon' => $data['icon']
        ]);
        return $exclusion;
    }

    public function deleteExclusion(\App\Models\AdditionalExclusion $exclusion)
    {
        return $exclusion->delete();
    }

    public function getAllMeals()
    {
        return \App\Models\Meal::latest()->get();
    }

    public function createMeal(array $data)
    {
        return \App\Models\Meal::create([
            'meal' => $data['meal'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function updateMeal(\App\Models\Meal $meal, array $data)
    {
        $meal->update([
            'meal' => $data['meal'],
            'description' => $data['description'] ?? null,
        ]);
        return $meal;
    }

    public function deleteMeal(\App\Models\Meal $meal)
    {
        return $meal->delete();
    }
}
