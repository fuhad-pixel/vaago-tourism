<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\SmtpSetting;
use App\Mail\EnquiryMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class EnquiryController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'arrival_date' => 'nullable|date',
            'nights' => 'required|integer|min:1',
            'accommodation_type' => 'nullable|string|max:255',
            'honeymoon' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $enquiry = Enquiry::create($validated);

        // Configure SMTP dynamically
        $smtp = SmtpSetting::first();
        if ($smtp) {
            Config::set('mail.mailers.smtp.transport', $smtp->mail_mailer ?? 'smtp');
            Config::set('mail.mailers.smtp.host', $smtp->mail_host);
            Config::set('mail.mailers.smtp.port', $smtp->mail_port);
            Config::set('mail.mailers.smtp.username', $smtp->mail_username);
            Config::set('mail.mailers.smtp.password', $smtp->mail_password);
            Config::set('mail.mailers.smtp.encryption', $smtp->mail_encryption);
            Config::set('mail.from.address', $smtp->mail_from_address);
            Config::set('mail.from.name', $smtp->mail_from_name);
        }

        try {
            // Send email to admin (SMTP From Address)
            if ($smtp && $smtp->mail_from_address) {
                Mail::to($smtp->mail_from_address)->send(new EnquiryMail($enquiry, 'admin'));
            }
            
            // Send auto-responder to user
            Mail::to($enquiry->email)->send(new EnquiryMail($enquiry, 'user'));

        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your holiday inquiry has been received. Our team will get back to you shortly.'
        ]);
    }
}
