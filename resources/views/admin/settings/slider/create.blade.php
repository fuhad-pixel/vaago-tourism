@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <h3><i class="fa-solid fa-plus"></i> Add New Slide</h3>
    </div>
    <div class="page-panel-body">
        
        <form action="{{ url('/admin/settings/slider') }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Slide Information</h4>
                    
                    <div class="form-group">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="modern-input" value="{{ old('title') }}" placeholder="e.g. Discover the Luxury of Travel" required>
                    </div>

                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" class="modern-input" value="{{ old('subtitle') }}" placeholder="e.g. Premium Travel Agency">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="modern-input" rows="4" placeholder="Enter slide description...">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Video URL</label>
                        <input type="url" name="video_url" class="modern-input" value="{{ old('video_url') }}" placeholder="e.g. https://www.youtube.com/watch?v=..." url="true">
                    </div>
                </div>

                <!-- Right Side: Image Upload -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-image"></i> Slide Image</h4>
                    
                    <div class="form-group">
                        <label>Image</label>
                        <div class="image-upload-wrapper">
                            <input type="hidden" name="remove_image" class="remove-input" value="0">
                            <input type="file" name="image" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload Slide Image</span>
                            </div>
                            <img src="" class="image-preview" alt="Image Preview">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Supported: JPG, PNG, GIF, SVG, WEBP. Max: 4MB.</p>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">
            
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ url('/admin/settings/slider') }}" class="modern-btn" style="background-color: #6B7280; border-color: #6B7280; text-decoration: none;">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Create Slide
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
@endsection
