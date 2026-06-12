@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <h3><i class="fa-solid fa-envelope"></i> SMTP Settings</h3>
    </div>
    <div class="page-panel-body">

        <form action="{{ url('/admin/settings/smtp') }}" method="POST" class="validate-form">
            @csrf
            
            <div class="form-section-grid-equal">
                
                <!-- Server Configuration -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-server"></i> Server Configuration</h4>
                    
                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Mail Mailer <span class="text-danger">*</span></label>
                            <input type="text" name="mail_mailer" class="modern-input" value="{{ old('mail_mailer', $setting->mail_mailer ?? 'smtp') }}" placeholder="smtp" required>
                        </div>
                        <div class="form-group">
                            <label>Mail Host <span class="text-danger">*</span></label>
                            <input type="text" name="mail_host" class="modern-input" value="{{ old('mail_host', $setting->mail_host) }}" placeholder="smtp.mailtrap.io" required>
                        </div>
                    </div>
                    
                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Mail Port <span class="text-danger">*</span></label>
                            <input type="text" name="mail_port" class="modern-input" value="{{ old('mail_port', $setting->mail_port) }}" placeholder="2525" required>
                        </div>
                        <div class="form-group">
                            <label>Encryption</label>
                            <input type="text" name="mail_encryption" class="modern-input" value="{{ old('mail_encryption', $setting->mail_encryption) }}" placeholder="tls">
                        </div>
                    </div>
                </div>

                <!-- Authentication -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-lock"></i> Authentication & Identity</h4>
                    
                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Mail Username <span class="text-danger">*</span></label>
                            <input type="text" name="mail_username" class="modern-input" value="{{ old('mail_username', $setting->mail_username) }}" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label>Mail Password <span class="text-danger">*</span></label>
                            <input type="password" name="mail_password" class="modern-input" value="{{ old('mail_password', $setting->mail_password) }}" placeholder="Password" required>
                        </div>
                    </div>

                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>From Address <span class="text-danger">*</span></label>
                            <input type="email" name="mail_from_address" class="modern-input" value="{{ old('mail_from_address', $setting->mail_from_address) }}" placeholder="noreply@example.com" email="true" required>
                        </div>
                        <div class="form-group">
                            <label>From Name <span class="text-danger">*</span></label>
                            <input type="text" name="mail_from_name" class="modern-input" value="{{ old('mail_from_name', $setting->mail_from_name) }}" placeholder="Pacific Travel" required>
                        </div>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">
            
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save SMTP Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
