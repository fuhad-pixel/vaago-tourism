<?php

namespace App\Services;

use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WebsiteService
{
    /**
     * Store a new slider.
     */
    public function createSlider(array $data, Request $request): Slider
    {
        $slider = new Slider();
        $slider->fill($data);

        $uploadPath = public_path('uploads/sliders');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $slider->image_path = 'uploads/sliders/' . $filename;
        }

        $slider->save();

        return $slider;
    }

    /**
     * Update an existing slider.
     */
    public function updateSlider(Slider $slider, array $data, Request $request): Slider
    {
        $slider->fill($data);

        $uploadPath = public_path('uploads/sliders');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Handle image removal if requested
        if ($request->has('remove_image') && $request->remove_image == '1') {
            $this->deleteFile($slider->image_path);
            $slider->image_path = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            $this->deleteFile($slider->image_path);
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $slider->image_path = 'uploads/sliders/' . $filename;
        }

        $slider->save();

        return $slider;
    }

    /**
     * Delete (soft delete) a slider.
     */
    public function deleteSlider(Slider $slider): bool
    {
        return $slider->delete();
    }

    /**
     * Store a new testimonial.
     */
    public function createTestimonial(array $data, Request $request): Testimonial
    {
        $testimonial = new Testimonial();
        $testimonial->fill($data);

        $uploadPath = public_path('uploads/testimonials');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        if ($request->hasFile('client_dp')) {
            $file = $request->file('client_dp');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $testimonial->client_dp = 'uploads/testimonials/' . $filename;
        }

        $testimonial->save();

        return $testimonial;
    }

    /**
     * Update an existing testimonial.
     */
    public function updateTestimonial(Testimonial $testimonial, array $data, Request $request): Testimonial
    {
        $testimonial->fill($data);

        $uploadPath = public_path('uploads/testimonials');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Handle image removal if requested
        if ($request->has('remove_client_dp') && $request->remove_client_dp == '1') {
            $this->deleteFile($testimonial->client_dp);
            $testimonial->client_dp = null;
        }

        // Handle new image upload
        if ($request->hasFile('client_dp')) {
            $this->deleteFile($testimonial->client_dp);
            $file = $request->file('client_dp');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $testimonial->client_dp = 'uploads/testimonials/' . $filename;
        }

        $testimonial->save();

        return $testimonial;
    }

    /**
     * Delete (soft delete) a testimonial.
     */
    public function deleteTestimonial(Testimonial $testimonial): bool
    {
        return $testimonial->delete();
    }

    /**
     * Delete a file from public storage.
     */
    protected function deleteFile(?string $path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
