@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/tour.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-magnifying-glass-chart"></i> SEO Settings for: {{ $tour->name }}</h3>
            <a href="{{ url('/admin/tours') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Tours
            </a>
        </div>
    </div>

    <div class="page-panel-body">
        <form action="{{ route('tours.seo.update', $tour->id) }}" method="POST" enctype="multipart/form-data" class="validate-form draft-enabled">
            @csrf
            @method('PUT')

            <div class="form-section-grid" style="grid-template-columns: 1fr;">
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-tag"></i> Standard SEO Tags</h4>
                    
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="modern-input" placeholder="Enter meta title" value="{{ old('meta_title', $tour->seo->meta_title ?? '') }}">
                        @error('meta_title')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="modern-input" rows="3" placeholder="Enter meta description">{{ old('meta_description', $tour->seo->meta_description ?? '') }}</textarea>
                        @error('meta_description')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords (comma separated)</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="modern-input" placeholder="e.g., travel, tour, vacation" value="{{ old('meta_keywords', $tour->seo->meta_keywords ?? '') }}">
                        @error('meta_keywords')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <h4 class="form-section-title"><i class="fa-solid fa-share-nodes"></i> Open Graph (Social Media) Tags</h4>
                    
                    <div class="form-group">
                        <label for="og_title">OG Title <small style="color:#6b7280; font-weight:normal;">(Leave blank to use Meta Title)</small></label>
                        <input type="text" name="og_title" id="og_title" class="modern-input" placeholder="Enter OG title" value="{{ old('og_title', $tour->seo->og_title ?? '') }}">
                        @error('og_title')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="og_description">OG Description <small style="color:#6b7280; font-weight:normal;">(Leave blank to use Meta Description)</small></label>
                        <textarea name="og_description" id="og_description" class="modern-input" rows="3" placeholder="Enter OG description">{{ old('og_description', $tour->seo->og_description ?? '') }}</textarea>
                        @error('og_description')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group" style="max-width: 400px;">
                        <label for="og_image">OG Image <small style="color:#6b7280; font-weight:normal;">(Recommended size: 1200x630 pixels)</small></label>
                        <div class="image-upload-wrapper {{ (isset($tour->seo) && $tour->seo->og_image_path) ? 'has-image' : '' }}">
                            <input type="hidden" name="remove_og_image" class="remove-input" value="0">
                            <input type="file" name="og_image" id="og_image" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload OG Image</span>
                            </div>
                            <img src="{{ (isset($tour->seo) && $tour->seo->og_image_path) ? asset($tour->seo->og_image_path) : '' }}" class="image-preview" alt="OG Image Preview">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        @error('og_image')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            
            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ url('/admin/tours') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save SEO Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
    <script src="{{ asset('assets/js/admin/form-draft.js') }}"></script>
@endsection
