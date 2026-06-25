@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-plus"></i> Add New Driver</h3>
            <a href="{{ url('/admin/drivers') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Drivers
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/drivers') }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Driver Details</h4>
                    
                    <div class="form-group">
                        <label for="driver_name">Driver Name <span class="text-danger">*</span></label>
                        <input type="text" name="driver_name" id="driver_name" class="modern-input" placeholder="Enter driver name" value="{{ old('driver_name') }}" required>
                        @error('driver_name')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="modern-input" placeholder="Enter phone number" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="whatsapp_number">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" id="whatsapp_number" class="modern-input" placeholder="Enter WhatsApp number" value="{{ old('whatsapp_number') }}">
                            @error('whatsapp_number')
                                <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="modern-input" placeholder="Enter email address" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="modern-input" rows="4" placeholder="Enter full address">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Right Side: Driver Image -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-image"></i> Driver Photo</h4>
                    
                    <div class="form-group">
                        <label>Photo Upload</label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="photo" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload Photo</span>
                            </div>
                            <img src="" class="image-preview" alt="Driver Preview" style="border-radius: 50%; max-width: 200px; aspect-ratio: 1; object-fit: cover;">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        @error('photo')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Supported: JPG, PNG, GIF, SVG, WEBP. Max: 4MB.</p>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ url('/admin/drivers') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Driver
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
@endsection
