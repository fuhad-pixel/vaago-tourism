@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <h3><i class="fa-solid fa-building"></i> Company Settings</h3>
    </div>
    <div class="page-panel-body">
        
        <form action="{{ url('/admin/settings/company') }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Basic Information</h4>
                    
                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="modern-input" value="{{ old('company_name', $setting->company_name) }}" placeholder="e.g. Pacific Travel Agency" required>
                        </div>
                        <div class="form-group">
                            <label>Company Email <span class="text-danger">*</span></label>
                            <input type="email" name="company_email" class="modern-input" value="{{ old('company_email', $setting->company_email) }}" placeholder="contact@example.com" email="true" required>
                        </div>
                    </div>
                    
                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="modern-input" value="{{ old('phone', $setting->phone) }}" placeholder="+1 234 567 8900" required>
                        </div>
                        <div class="form-group">
                            <label>WhatsApp Number <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp" class="modern-input" value="{{ old('whatsapp', $setting->whatsapp) }}" placeholder="+1 234 567 8900" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="modern-input" rows="3" placeholder="123 Luxury Street, New York, NY">{{ old('address', $setting->address) }}</textarea>
                    </div>

                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Working Days</label>
                            <input type="text" name="working_days" class="modern-input" value="{{ old('working_days', $setting->working_days) }}" placeholder="e.g. Monday - Friday">
                        </div>
                        <div class="form-group">
                            <label>Working Time</label>
                            <input type="text" name="working_time" class="modern-input" value="{{ old('working_time', $setting->working_time) }}" placeholder="e.g. 09:00 AM - 05:00 PM">
                        </div>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 32px;"><i class="fa-solid fa-file-invoice-dollar"></i> Tax Information</h4>
                    
                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>GST Percentage (%)</label>
                            <input type="number" step="0.01" name="gst" class="modern-input" value="{{ old('gst', $setting->gst) }}" placeholder="e.g. 18">
                        </div>
                        <div class="form-group">
                            <label>GST Number</label>
                            <input type="text" name="gst_number" class="modern-input" value="{{ old('gst_number', $setting->gst_number) }}" placeholder="e.g. 22AAAAA0000A1Z5">
                        </div>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 32px;"><i class="fa-solid fa-share-nodes"></i> Social Links</h4>
                    
                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Facebook URL</label>
                            <input type="url" name="facebook" class="modern-input" value="{{ old('facebook', $setting->facebook) }}">
                        </div>
                        <div class="form-group">
                            <label>Twitter URL</label>
                            <input type="url" name="twitter" class="modern-input" value="{{ old('twitter', $setting->twitter) }}">
                        </div>
                        <div class="form-group">
                            <label>Instagram URL</label>
                            <input type="url" name="instagram" class="modern-input" value="{{ old('instagram', $setting->instagram) }}">
                        </div>
                        <div class="form-group">
                            <label>LinkedIn URL</label>
                            <input type="url" name="linkedin" class="modern-input" value="{{ old('linkedin', $setting->linkedin) }}">
                        </div>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 32px;"><i class="fa-solid fa-code"></i> Google Tag Manager</h4>
                    
                    <div class="form-group">
                        <label>GTM Head Section (&#x3C;head&#x3E;)</label>
                        <textarea name="gtm_head" class="modern-input" rows="4" placeholder="Paste your GTM head script here...">{{ old('gtm_head', $gtm_head) }}</textarea>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;">Code to be placed in the &lt;head&gt; of the page.</p>
                    </div>
                    
                    <div class="form-group">
                        <label>GTM Body Section (&#x3C;body&#x3E;)</label>
                        <textarea name="gtm_body" class="modern-input" rows="4" placeholder="Paste your GTM body script here...">{{ old('gtm_body', $gtm_body) }}</textarea>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;">Code to be placed immediately after the opening &lt;body&gt; tag.</p>
                    </div>
                </div>

                <!-- Right Side: Images -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-images"></i> Media Assets</h4>
                    
                    <div class="form-group">
                        <label>Company Logo <span class="text-danger">*</span></label>
                        <div class="image-upload-wrapper">
                            <input type="hidden" name="remove_logo" class="remove-input" value="0">
                            <input type="file" name="logo" class="image-upload-input" accept="image/*" {{ !$setting->logo_path ? 'required' : '' }}>
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload Logo</span>
                            </div>
                            <img src="{{ $setting->logo_path ? asset($setting->logo_path) : '' }}" class="image-preview" alt="Logo Preview">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Supported: JPG, PNG, GIF, SVG. Max: 2MB.</p>
                    </div>

                    <div class="form-group">
                        <label>Favicon (Browser Icon) <span class="text-danger">*</span></label>
                        <div class="image-upload-wrapper">
                            <input type="hidden" name="remove_favicon" class="remove-input" value="0">
                            <input type="file" name="favicon" class="image-upload-input" accept="image/*,.ico" {{ !$setting->favicon_path ? 'required' : '' }}>
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload Favicon</span>
                            </div>
                            <img src="{{ $setting->favicon_path ? asset($setting->favicon_path) : '' }}" class="image-preview" alt="Favicon Preview">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Supported: JPG, PNG, ICO, SVG. Max: 1MB.</p>
                    </div>

                    <div class="form-group">
                        <label>OG Image (Social Sharing)</label>
                        <div class="image-upload-wrapper">
                            <input type="hidden" name="remove_og_image" class="remove-input" value="0">
                            <input type="file" name="og_image" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload OG Image</span>
                            </div>
                            <img src="{{ $setting->og_image_path ? asset($setting->og_image_path) : '' }}" class="image-preview" alt="OG Image Preview">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Supported: JPG, PNG, GIF. Max: 2MB.</p>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">
            
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
@endsection
