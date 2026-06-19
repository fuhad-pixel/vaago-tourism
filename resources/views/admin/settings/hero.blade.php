@extends('admin.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
<style>
    /* Tab Styling */
    .hero-tabs-nav {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        border-bottom: 2px solid #F1F5F9;
        padding-bottom: 12px;
    }

    .hero-tab-btn {
        padding: 12px 24px;
        font-weight: 600;
        font-size: 14px;
        color: #64748B;
        background: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .hero-tab-btn:hover {
        background-color: #FFF5F2;
        color: var(--primary);
    }

    .hero-tab-btn.active {
        background: var(--grad-orange);
        color: #ffffff;
        box-shadow: var(--shadow-glow-orange);
    }

    .hero-tab-content {
        display: none;
    }

    .hero-tab-content.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(4px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Drag and Drop Container */
    .drag-drop-zone {
        border: 2px dashed #CBD5E1;
        border-radius: 16px;
        background-color: #F8FAFC;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        min-height: 240px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .drag-drop-zone:hover,
    .drag-drop-zone.dragover {
        border-color: var(--primary);
        background-color: #FFF5F2;
    }

    .drag-drop-icon {
        font-size: 48px;
        color: #94A3B8;
        transition: all 0.3s ease;
    }

    .drag-drop-zone:hover .drag-drop-icon,
    .drag-drop-zone.dragover .drag-drop-icon {
        color: var(--primary);
        transform: translateY(-4px);
    }

    .drag-drop-text {
        font-weight: 600;
        color: #475569;
    }

    .drag-drop-subtext {
        font-size: 12px;
        color: #64748B;
    }

    .drag-drop-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.15;
        z-index: 1;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .drag-drop-zone:hover .drag-drop-preview {
        opacity: 0.35;
    }

    .drag-drop-file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 5;
    }

    /* Layout grid for Settings Form */
    .hero-form-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 32px;
    }

    @media (max-width: 991px) {
        .hero-form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <h3><i class="fa-solid fa-panorama"></i> Hero Sections Settings</h3>
    </div>
    <div class="page-panel-body">

        <div class="hero-tabs-nav">
            <button class="hero-tab-btn active" data-tab="about">
                <i class="fa-solid fa-address-card"></i> About Us Page
            </button>
            <button class="hero-tab-btn" data-tab="destinations">
                <i class="fa-solid fa-earth-americas"></i> Destinations Page
            </button>
            <button class="hero-tab-btn" data-tab="blog">
                <i class="fa-solid fa-blog"></i> Blogs Page
            </button>
            <button class="hero-tab-btn" data-tab="contact">
                <i class="fa-solid fa-envelope"></i> Contact Page
            </button>
            <button class="hero-tab-btn" data-tab="tours">
                <i class="fa-solid fa-route"></i> Tours Page
            </button>
        </div>

        <form action="{{ url('/admin/settings/hero') }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf

            @foreach(['about', 'destinations', 'blog', 'contact', 'tours'] as $page)
            @php
            $setting = $settings[$page] ?? null;
            @endphp
            <div class="hero-tab-content @if($loop->first) active @endif" id="tab-{{ $page }}">
                <div class="hero-form-grid">
                    <!-- Left Side: Details -->
                    <div>
                        <h4 class="form-section-title" style="margin-bottom: 20px;">
                            <i class="fa-solid fa-pen-to-square"></i> Configure Section Details
                        </h4>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px; color: #334155;">
                                Hero Section Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="{{ $page }}_title" class="modern-input"
                                value="{{ old($page . '_title', $setting ? $setting->title : '') }}"
                                placeholder="e.g. Explore Destinations" required
                                style="width: 100%; height: 50px; padding: 0 16px; border-radius: 10px; border: 1px solid #CBD5E1; font-weight: 500;">
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px; color: #334155;">
                                Hero Section Description / Subtitle
                            </label>
                            <textarea name="{{ $page }}_description" class="modern-input" rows="5"
                                placeholder="A short subtitle displaying under the page title"
                                style="width: 100%; padding: 16px; border-radius: 10px; border: 1px solid #CBD5E1; font-weight: 500; resize: vertical;">{{ old($page . '_description', $setting ? $setting->description : '') }}</textarea>
                        </div>
                    </div>

                    <!-- Right Side: Background Image Drag and Drop -->
                    <div>
                        <h4 class="form-section-title" style="margin-bottom: 20px;">
                            <i class="fa-solid fa-image"></i> Background Image Banner
                        </h4>

                        <div class="form-group">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px; color: #334155;">
                                Upload / Drag Banner Image
                            </label>

                            <div class="drag-drop-zone" id="dropzone-{{ $page }}">
                                <!-- Image Preview -->
                                <img src="{{ $setting && $setting->image_path ? asset($setting->image_path) : asset('assets/img/bg/breadcrumb-bg.png') }}"
                                    class="drag-drop-preview" id="preview-{{ $page }}" alt="Background Preview">

                                <!-- File input -->
                                <input type="file" name="{{ $page }}_image" class="drag-drop-file-input"
                                    id="input-{{ $page }}" accept="image/*">

                                <i class="fa-solid fa-cloud-arrow-up drag-drop-icon"></i>
                                <p class="drag-drop-text">Drag & Drop Image here or click to upload</p>
                                <p class="drag-drop-subtext">Recommended: 1920x532px landscape image. Max file size: 5MB.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <hr style="border: 0; border-top: 1px solid #E2E8F0; margin: 32px 0;">

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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching logic
        const tabBtns = document.querySelectorAll('.hero-tab-btn');
        const tabContents = document.querySelectorAll('.hero-tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTab = this.getAttribute('data-tab');

                // Toggle active tab buttons
                tabBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Toggle active tab content containers
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    if (content.id === `tab-${targetTab}`) {
                        content.classList.add('active');
                    }
                });
            });
        });

        // Drag and drop event listeners
        const pages = ['about', 'destinations', 'blog', 'contact', 'tours'];

        pages.forEach(page => {
            const dropzone = document.getElementById(`dropzone-${page}`);
            const fileInput = document.getElementById(`input-${page}`);
            const preview = document.getElementById(`preview-${page}`);

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            // Toggle dropzone visual states
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => {
                    dropzone.classList.add('dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => {
                    dropzone.classList.remove('dragover');
                }, false);
            });

            // Handle dropped files
            dropzone.addEventListener('drop', handleDrop, false);

            // Handle standard file selection changes
            fileInput.addEventListener('change', handleFileSelect, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            }

            function handleFileSelect(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                        preview.style.display = 'block';
                        preview.style.opacity = '0.35'; // Make preview visible when uploaded
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    });
</script>
@endsection