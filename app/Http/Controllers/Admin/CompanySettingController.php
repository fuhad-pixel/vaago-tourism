<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Services\CompanySettingService;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    protected $companySettingService;

    public function __construct(CompanySettingService $companySettingService)
    {
        $this->companySettingService = $companySettingService;
    }

    public function index()
    {
        $setting = CompanySetting::first() ?? new CompanySetting();
        $gtm_head = \App\Models\SystemModule::where('key', 'gtm_head')->first()->value ?? '';
        $gtm_body = \App\Models\SystemModule::where('key', 'gtm_body')->first()->value ?? '';
        return view('admin.settings.company', compact('setting', 'gtm_head', 'gtm_body'));
    }

    public function update(Request $request)
    {
        $setting = CompanySetting::first();
        
        $logoRule = ($setting && $setting->logo_path) ? 'nullable' : 'required';
        $favRule = ($setting && $setting->favicon_path) ? 'nullable' : 'required';

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'address' => 'nullable|string',
            'working_days' => 'nullable|string|max:255',
            'working_time' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'gst' => 'nullable|numeric|min:0|max:100',
            'gst_number' => 'nullable|string|max:255',
            'logo' => "$logoRule|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            'favicon' => "$favRule|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024",
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gtm_head' => 'nullable|string',
            'gtm_body' => 'nullable|string',
        ]);

        $this->companySettingService->updateSettings($request->except(['gtm_head', 'gtm_body']), $request);

        \App\Models\SystemModule::updateOrCreate(['key' => 'gtm_head'], ['value' => $request->gtm_head]);
        \App\Models\SystemModule::updateOrCreate(['key' => 'gtm_body'], ['value' => $request->gtm_body]);

        return redirect()->back()->with('success', 'Company settings updated successfully.');
    }

    public function editPolicies()
    {
        $setting = CompanySetting::first() ?? new CompanySetting();
        return view('admin.settings.policies', compact('setting'));
    }

    public function updatePolicies(Request $request)
    {
        $validated = $request->validate([
            'privacy_policy' => 'nullable|string',
            'return_policy' => 'nullable|string',
        ]);

        $this->companySettingService->updateSettings($validated, $request);

        return redirect()->back()->with('success', 'Policies updated successfully.');
    }
}
