@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-plus"></i> Add New Destination</h3>
            <a href="{{ url('/admin/destinations') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Destinations
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/destinations') }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Destination Details</h4>
                    
                    <div class="form-group">
                        <label for="name">Destination Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="modern-input" placeholder="Enter destination name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Destination Description</label>
                        <textarea name="description" id="description" class="modern-input ckeditor-init" rows="10">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Right Side: Destination Image -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-image"></i> Destination Image</h4>
                    
                    <div class="form-group">
                        <label>Image Upload</label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="image" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload Image</span>
                            </div>
                            <img src="" class="image-preview" alt="Destination Preview" style="border-radius: 8px;">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        @error('image')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Supported: JPG, PNG, GIF, SVG, WEBP. Max: 4MB.</p>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ url('/admin/destinations') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Destination
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
@endsection
