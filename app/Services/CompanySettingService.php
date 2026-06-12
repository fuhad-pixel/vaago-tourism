<?php

namespace App\Services;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompanySettingService
{
    /**
     * Update the company settings.
     *
     * @param array $data
     * @param Request $request
     * @return CompanySetting
     */
    public function updateSettings(array $data, Request $request)
    {
        $setting = CompanySetting::first() ?? new CompanySetting();
        $setting->fill($data);

        $uploadPath = public_path('uploads/settings');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Handle removals
        $this->handleRemovals($setting, $request);

        // Handle uploads
        $this->handleUploads($setting, $request, $uploadPath);

        $setting->save();

        return $setting;
    }

    /**
     * Handle file deletions if requested.
     */
    protected function handleRemovals(CompanySetting $setting, Request $request)
    {
        if ($request->has('remove_logo') && $request->remove_logo == '1') {
            $this->deleteFile($setting->logo_path);
            $setting->logo_path = null;
        }
        if ($request->has('remove_favicon') && $request->remove_favicon == '1') {
            $this->deleteFile($setting->favicon_path);
            $setting->favicon_path = null;
        }
        if ($request->has('remove_og_image') && $request->remove_og_image == '1') {
            $this->deleteFile($setting->og_image_path);
            $setting->og_image_path = null;
        }
    }

    /**
     * Handle new file uploads.
     */
    protected function handleUploads(CompanySetting $setting, Request $request, string $uploadPath)
    {
        if ($request->hasFile('logo')) {
            $this->deleteFile($setting->logo_path);
            $file = $request->file('logo');
            $filename = time() . '_logo.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $setting->logo_path = 'uploads/settings/' . $filename;
        }

        if ($request->hasFile('favicon')) {
            $this->deleteFile($setting->favicon_path);
            $file = $request->file('favicon');
            $filename = time() . '_favicon.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $setting->favicon_path = 'uploads/settings/' . $filename;
        }

        if ($request->hasFile('og_image')) {
            $this->deleteFile($setting->og_image_path);
            $file = $request->file('og_image');
            $filename = time() . '_og.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $setting->og_image_path = 'uploads/settings/' . $filename;
        }
    }

    /**
     * Delete a file from the public path if it exists.
     */
    protected function deleteFile(?string $path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
