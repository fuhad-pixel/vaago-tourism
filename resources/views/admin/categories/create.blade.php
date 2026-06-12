@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-plus"></i> Add New Category</h3>
            <a href="{{ url('/admin/categories') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Categories
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/categories') }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Category Details</h4>
                    
                    <div class="form-group">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="modern-input" placeholder="Enter category name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Parent Category</label>
                        <select name="parent_id" id="parent_id" class="modern-input">
                            <option value="">None (Root Category)</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Category Description</label>
                        <textarea name="description" id="description" class="modern-input ckeditor-init" rows="10">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Right Side: Category Image -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-image"></i> Category Image</h4>
                    
                    <div class="form-group">
                        <label>Image Upload</label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="image" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload Image</span>
                            </div>
                            <img src="" class="image-preview" alt="Category Preview" style="border-radius: 8px;">
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
                <a href="{{ url('/admin/categories') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
@endsection
