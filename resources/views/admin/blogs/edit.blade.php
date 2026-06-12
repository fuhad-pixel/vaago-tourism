@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/blogs.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-pen-to-square"></i> Edit Blog</h3>
            <a href="{{ url('/admin/blogs') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Blogs
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/blogs/' . $blog->id) }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Blog Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="modern-input" placeholder="Enter blog title" value="{{ old('title', $blog->title) }}" required>
                @error('title')
                    <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="slug">Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="modern-input" placeholder="Enter unique slug" value="{{ old('slug', $blog->slug) }}" required>
                @error('slug')
                    <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Blog Description</label>
                <textarea name="description" id="description" class="modern-input ckeditor-init" rows="10">{{ old('description', $blog->description) }}</textarea>
                @error('description')
                    <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            @if($blog->images->count() > 0)
                <div class="form-group">
                    <label>Existing Images (Click 'x' to delete permanently)</label>
                    <div class="existing-images-gallery">
                        @foreach($blog->images as $image)
                            <div class="image-preview-card existing-image-card">
                                <img src="{{ asset($image->image_path) }}" alt="Blog Image">
                                <button type="button" class="delete-btn delete-existing-btn" data-image-id="{{ $image->id }}" data-delete-url="{{ url('/admin/blogs/image/' . $image->id) }}">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label>Add More Images</label>
                <div class="multiple-image-upload-container" id="multiple-upload-container">
                    <i class="fa-solid fa-images"></i>
                    <h5>Drag or Click to Upload Multiple Images</h5>
                    <p>Supported: JPG, PNG, GIF, WEBP. Max size: 4MB per image.</p>
                    <input type="file" name="images[]" id="blogs-image-input" class="image-upload-input" accept="image/*" multiple style="display: none;">
                </div>
                <div class="blog-image-preview-grid" id="blogs-preview-grid"></div>
                @error('images')
                    <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ url('/admin/blogs') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Update Blog
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/blogs.js') }}"></script>
@endsection
