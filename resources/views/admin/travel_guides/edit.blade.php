@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-pen-to-square"></i> Edit Travel Guide</h3>
            <a href="{{ url('/admin/travel-guides') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Guides
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/travel-guides/' . $guide->id) }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            @method('PUT')
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Guide Details</h4>
                    
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="modern-input" placeholder="Enter guide name" value="{{ old('name', $guide->name) }}" required>
                        @error('name')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <input type="text" name="designation" id="designation" class="modern-input" placeholder="e.g. Senior Tour Guide" value="{{ old('designation', $guide->designation) }}">
                        @error('designation')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="modern-input" placeholder="Enter email" value="{{ old('email', $guide->email) }}">
                            @error('email')
                                <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="modern-input" placeholder="Enter phone number" value="{{ old('phone', $guide->phone) }}">
                            @error('phone')
                                <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="modern-input" rows="4" placeholder="Enter address">{{ old('address', $guide->address) }}</textarea>
                        @error('address')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Right Side: Guide Image -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-image"></i> Guide Photo</h4>
                    
                    <div class="form-group">
                        <label>Photo Upload</label>
                        <div class="image-upload-wrapper {{ $guide->photo ? 'has-image' : '' }}">
                            <input type="file" name="photo" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload Photo</span>
                            </div>
                            <img src="{{ $guide->photo ? asset($guide->photo) : '' }}" class="image-preview" alt="Guide Preview" style="border-radius: 8px;">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        @error('photo')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Supported: JPG, PNG, GIF, WEBP. Max: 4MB.</p>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ url('/admin/travel-guides') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Update Travel Guide
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
@endsection
