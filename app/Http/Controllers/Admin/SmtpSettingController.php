<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmtpSetting;
use App\Services\SmtpSettingService;
use Illuminate\Http\Request;

class SmtpSettingController extends Controller
{
    protected $smtpSettingService;

    public function __construct(SmtpSettingService $smtpSettingService)
    {
        $this->smtpSettingService = $smtpSettingService;
    }

    public function index()
    {
        $setting = SmtpSetting::first() ?? new SmtpSetting();
        return view('admin.settings.smtp', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer' => 'required|string|max:255',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|string|max:255',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string|max:255',
            'mail_encryption' => 'nullable|string|max:255',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        $this->smtpSettingService->updateSettings($validated);

        return redirect()->back()->with('success', 'SMTP settings updated successfully.');
    }
}
