@extends('admin.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
<style>
    .sortable-row {
        cursor: grab;
    }
    .sortable-row:active {
        cursor: grabbing;
    }
    .service-icon-preview {
        width: 40px;
        height: 40px;
        object-fit: contain;
        background-color: #1E293B;
        border-radius: 8px;
        padding: 4px;
    }
    .service-bg-preview {
        width: 80px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    /* Image Upload Preview Styling */
    .image-upload-wrapper {
        border: 2px dashed #CBD5E1;
        border-radius: 8px;
        padding: 15px 10px;
        text-align: center;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #F8FAFC;
        min-height: 90px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
    }
    .image-upload-wrapper:hover {
        border-color: #0284C7;
        background-color: #F0F9FF;
    }
    .image-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }
    .image-upload-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        background-color: #1E293B;
        padding: 5px;
        z-index: 5;
        display: none;
    }
    .image-upload-placeholder {
        color: #94A3B8;
    }
    .image-upload-placeholder i {
        font-size: 20px;
        margin-bottom: 5px;
        color: #64748B;
    }
</style>
<style>
/* Custom Modal Styling */
.custom-modal {
    display: none; 
    position: fixed; 
    z-index: 9999; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow-y: auto; 
    overflow-x: hidden;
    background-color: rgba(0,0,0,0.5); 
    align-items: center;
    justify-content: center;
}
.custom-modal.show-modal {
    display: flex !important;
}
.custom-modal-content {
    background-color: #fefefe;
    margin: auto; /* centered via flex */
    padding: 25px;
    border: 1px solid #888;
    width: 90%; 
    max-width: 650px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    position: relative;
    animation: modalFadeIn 0.3s;
    max-height: 90vh;
    overflow-y: auto;
}
.custom-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 15px;
}
.custom-modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    color: #334155;
}
.custom-modal-close {
    color: #94a3b8;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    border: none;
    background: none;
}
.custom-modal-close:hover {
    color: #0f172a;
}

/* Tab Styling */
.modern-tabs-header {
    background: #ffffff;
    border-radius: 12px;
    padding: 10px 20px;
    margin-bottom: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    border: 1px solid #E2E8F0;
}

.home-tabs-nav {
    display: flex;
    gap: 12px;
}

.home-tab-btn {
    padding: 12px 24px;
    font-weight: 600;
    font-size: 14px;
    color: #64748B;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.home-tab-btn:hover {
    background-color: #F8FAFC;
    color: var(--primary);
}

.home-tab-btn.active {
    background: #FFF5F2;
    color: var(--primary);
    box-shadow: none;
}

.home-tab-content {
    display: none;
}

.home-tab-content.active {
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

/* Modal Form Grid */
.modal-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
    width: 100%;
}
.full-width {
    grid-column: span 2;
}
@media (max-width: 768px) {
    .modal-form-grid {
        grid-template-columns: 1fr;
    }
    .full-width {
        grid-column: span 1;
    }
}
</style>
@endsection

@section('content')
<div class="modern-tabs-header">
    <div class="home-tabs-nav">
        <button class="home-tab-btn active" data-tab="home">
            <i class="fa-solid fa-layer-group"></i> Service Section
        </button>
        <button class="home-tab-btn" data-tab="about">
            <i class="fa-solid fa-address-card"></i> About Us
        </button>
    </div>
</div>

<div class="home-tab-content active" id="tab-home">
    <div class="admin-page-panel">
        <div class="page-panel-header">
            <h3><i class="fa-solid fa-layer-group"></i> Service Section</h3>
        </div>
        <div class="page-panel-body">

            <!-- HEADER SECTION -->
        <h4 class="form-section-title" style="margin-bottom: 20px;">
            <i class="fa-solid fa-heading"></i> Service Section Header
        </h4>
        <form action="{{ route('admin.settings.pages.home.header') }}" method="POST" class="validate-form" style="margin-bottom: 40px;">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="font-weight: 600; display: block; margin-bottom: 8px; color: #334155;">
                            Section Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title" class="modern-input"
                            value="{{ old('title', $header->title ?? '') }}"
                            placeholder="e.g. It’s Time to Travel with our Company" required
                            style="width: 100%; height: 50px; padding: 0 16px; border-radius: 10px; border: 1px solid #CBD5E1; font-weight: 500;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="font-weight: 600; display: block; margin-bottom: 8px; color: #334155;">
                            Section Subtitle <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="description" class="modern-input"
                            value="{{ old('description', $header->description ?? '') }}"
                            placeholder="e.g. our services" required
                            style="width: 100%; height: 50px; padding: 0 16px; border-radius: 10px; border: 1px solid #CBD5E1; font-weight: 500;">
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Header
                </button>
            </div>
        </form>

        <hr style="border: 0; border-top: 1px solid #E2E8F0; margin: 32px 0;">

        <!-- SERVICE CARDS SECTION -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h4 class="form-section-title" style="margin-bottom: 0;">
                <i class="fa-solid fa-layer-group"></i> Service Cards
            </h4>
            <button type="button" class="modern-btn" onclick="openModal('addServiceModal')">
                <i class="fa-solid fa-plus"></i> Add New Service
            </button>
        </div>

        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="services-table">
                <thead>
                    <tr>
                        <th width="50"></th>
                        <th>Icon</th>
                        <th>Background</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th class="text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable-services">
                    @forelse($services as $service)
                    <tr class="sortable-row" data-id="{{ $service->id }}">
                        <td class="text-center align-middle drag-handle" style="color: #94A3B8; cursor: grab;">
                            <i class="fa-solid fa-grip-vertical"></i>
                        </td>
                        <td class="align-middle">
                            @if($service->icon_path)
                                <img src="{{ asset($service->icon_path) }}" class="service-icon-preview" alt="Icon">
                            @else
                                <span class="badge bg-secondary">No Icon</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($service->image_path)
                                <img src="{{ asset($service->image_path) }}" class="service-bg-preview" alt="BG">
                            @else
                                <span class="badge bg-secondary">No Image</span>
                            @endif
                        </td>
                        <td class="align-middle font-weight-bold" style="font-weight: 700;">{{ $service->title }}</td>
                        <td class="align-middle text-muted">{{ Str::limit($service->description, 50) }}</td>
                        <td class="text-center align-middle">
                            <div class="table-actions" style="justify-content: center;">
                                <button type="button" class="btn-table-action" onclick="openModal('editServiceModal{{ $service->id }}')" title="Edit" style="background-color: #E0F2FE; color: #0284C7; border:none; padding:8px 12px; border-radius:8px;">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.settings.pages.home.service.destroy', $service->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this service card?')" style="border:none; padding:8px 12px; border-radius:8px;">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr class="empty-row">
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 40px;">
                            <i class="fa-solid fa-layer-group" style="font-size: 2.5rem; display: block; margin-bottom: 15px; opacity: 0.5;"></i>
                            No service cards found. Click "Add New Service" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @foreach($services as $service)
        <!-- Edit Modal for each service -->
        <div class="custom-modal" id="editServiceModal{{ $service->id }}">
            <div class="custom-modal-content">
                <div class="custom-modal-header">
                    <h5 class="custom-modal-title">Edit Service Card</h5>
                    <button type="button" class="custom-modal-close" onclick="closeModal('editServiceModal{{ $service->id }}')">&times;</button>
                </div>
                <form action="{{ route('admin.settings.pages.home.service.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="validate-form">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <div style="margin-bottom: 20px;">
                        <div class="modal-form-grid">
                            <div class="form-group">
                                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="modern-input" value="{{ $service->title }}" required style="width: 100%; height: 45px; padding: 0 16px; border-radius: 8px; border: 1px solid #CBD5E1;">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Link (Optional)</label>
                                <input type="text" name="link" class="modern-input" value="{{ $service->link }}" style="width: 100%; height: 45px; padding: 0 16px; border-radius: 8px; border: 1px solid #CBD5E1;">
                            </div>
                            <div class="form-group full-width">
                                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="modern-input" rows="3" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #CBD5E1;">{{ $service->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Upload Icon Image/SVG</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="icon" class="image-upload-input" accept="image/*" onchange="previewImage(this)">
                                    <div class="image-upload-placeholder">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <div style="font-size: 12px; font-weight: 500;">Click or drag to upload icon</div>
                                    </div>
                                    <img src="{{ $service->icon_path ? asset($service->icon_path) : '' }}" class="image-upload-preview" style="{{ $service->icon_path ? 'display: block;' : '' }}">
                                </div>
                                @if(old('service_id') == $service->id)
                                    @error('icon')<span class="text-danger" style="font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>@enderror
                                @endif
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Upload Background Image</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="image" class="image-upload-input" accept="image/*" onchange="previewImage(this)">
                                    <div class="image-upload-placeholder">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <div style="font-size: 12px; font-weight: 500;">Click or drag to upload image</div>
                                    </div>
                                    <img src="{{ $service->image_path ? asset($service->image_path) : '' }}" class="image-upload-preview" style="object-fit: cover; background: none; padding: 0; {{ $service->image_path ? 'display: block;' : '' }}">
                                </div>
                                @if(old('service_id') == $service->id)
                                    @error('image')<span class="text-danger" style="font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>@enderror
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                        <button type="button" class="modern-btn" style="background: #94A3B8; box-shadow: none;" onclick="closeModal('editServiceModal{{ $service->id }}')">Cancel</button>
                        <button type="submit" class="modern-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach

        </div>
    </div>
</div> <!-- End tab-home content -->

<!-- Add Modal -->
<div class="custom-modal" id="addServiceModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Add Service Card</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('addServiceModal')">&times;</button>
        </div>
        <form action="{{ route('admin.settings.pages.home.service.store') }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            <div style="margin-bottom: 20px;">
                <div class="modal-form-grid">
                    <div class="form-group">
                        <label style="font-weight: 600; display: block; margin-bottom: 8px;">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="modern-input" required placeholder="e.g. Adventures" style="width: 100%; height: 45px; padding: 0 16px; border-radius: 8px; border: 1px solid #CBD5E1;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 600; display: block; margin-bottom: 8px;">Link (Optional)</label>
                        <input type="text" name="link" class="modern-input" placeholder="e.g. tours" style="width: 100%; height: 45px; padding: 0 16px; border-radius: 8px; border: 1px solid #CBD5E1;">
                    </div>
                    <div class="form-group full-width">
                        <label style="font-weight: 600; display: block; margin-bottom: 8px;">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="modern-input" rows="3" required placeholder="Service description..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #CBD5E1;"></textarea>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 600; display: block; margin-bottom: 8px;">Upload Icon Image/SVG (Optional)</label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="icon" class="image-upload-input" accept="image/*" onchange="previewImage(this)">
                            <div class="image-upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <div style="font-size: 12px; font-weight: 500;">Click or drag to upload icon</div>
                            </div>
                            <img src="" class="image-upload-preview">
                        </div>
                        @if(!old('service_id'))
                            @error('icon')<span class="text-danger" style="font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>@enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label style="font-weight: 600; display: block; margin-bottom: 8px;">Upload Background Image (Optional)</label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="image" class="image-upload-input" accept="image/*" onchange="previewImage(this)">
                            <div class="image-upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <div style="font-size: 12px; font-weight: 500;">Click or drag to upload image</div>
                            </div>
                            <img src="" class="image-upload-preview" style="object-fit: cover; background: none; padding: 0;">
                        </div>
                        @if(!old('service_id'))
                            @error('image')<span class="text-danger" style="font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>@enderror
                        @endif
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                <button type="button" class="modern-btn" style="background: #94A3B8; box-shadow: none;" onclick="$('#addServiceModal').hide()">Cancel</button>
                <button type="submit" class="modern-btn">Save Service</button>
            </div>
        </form>
    </div>
</div>

<div class="home-tab-content" id="tab-about">
    <div class="admin-page-panel">
        <div class="page-panel-header">
            <h3><i class="fa-solid fa-address-card"></i> About Us Section</h3>
        </div>
        <div class="page-panel-body">
            <form action="{{ route('admin.settings.pages.home.about.update') }}" method="POST" enctype="multipart/form-data" class="validate-form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Header Title</label>
                            <textarea name="header_title" class="modern-input" placeholder="e.g. Discover Organized Adventures&#10;Ultimate Travel Hack" style="width: 100%; height: 75px; padding: 12px 16px; border-radius: 10px; border: 1px solid #CBD5E1; resize: vertical;">{{ old('header_title', $about->header_title ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Subtitle</label>
                            <input type="text" name="subtitle" class="modern-input" value="{{ old('subtitle', $about->subtitle ?? '') }}" placeholder="e.g. Explore our trip" style="width: 100%; height: 50px; padding: 0 16px; border-radius: 10px; border: 1px solid #CBD5E1;">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Title</label>
                            <input type="text" name="title" class="modern-input" value="{{ old('title', $about->title ?? '') }}" placeholder="e.g. Discover safe and memorable tours" style="width: 100%; height: 50px; padding: 0 16px; border-radius: 10px; border: 1px solid #CBD5E1;">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Description (with bullet points)</label>
                            <textarea name="description" class="ckeditor-init" style="width: 100%; min-height: 150px; padding: 12px 16px; border-radius: 10px; border: 1px solid #CBD5E1;">{{ old('description', $about->description ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Upload Image (Optional)</label>
                            <div class="image-upload-wrapper">
                                <input type="file" name="image" class="image-upload-input" accept="image/*" onchange="previewImage(this)">
                                <div class="image-upload-placeholder">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <div style="font-size: 12px; font-weight: 500;">Click or drag to upload image (640x491 recommended)</div>
                                </div>
                                <img src="{{ isset($about) && $about->image_path ? asset($about->image_path) : '' }}" class="image-upload-preview" style="{{ isset($about) && $about->image_path ? 'display: block; object-fit: cover;' : 'display: none;' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; padding-top: 20px;">
                    <button type="submit" class="modern-btn"><i class="fa-solid fa-save"></i> Save About Us Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching logic
        const tabBtns = document.querySelectorAll('.home-tab-btn');
        const tabContents = document.querySelectorAll('.home-tab-content');

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
    });

    function openModal(id) {
        $('#' + id).addClass('show-modal');
        $('body').css('overflow', 'hidden'); // Prevent background scrolling
    }

    function closeModal(id) {
        $('#' + id).removeClass('show-modal');
        $('body').css('overflow', ''); // Restore background scrolling
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            // Client-side file size validation (5MB max)
            var maxFileSize = 5 * 1024 * 1024; // 5MB
            if (input.files[0].size > maxFileSize) {
                alert('File is too large. Maximum size allowed is 5 MB.');
                input.value = '';
                $(input).siblings('.image-upload-preview').hide().attr('src', '');
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                $(input).siblings('.image-upload-preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-reopen modal if there are validation errors
    @if($errors->any())
        $(document).ready(function() {
            var serviceId = "{{ old('service_id') }}";
            if (serviceId) {
                openModal('editServiceModal' + serviceId);
            } else {
                openModal('addServiceModal');
            }
        });
    @endif

    $(document).ready(function() {
        // Initialize DataTable but disable ordering to allow drag-and-drop
        if ($('#services-table tbody tr.empty-row').length === 0) {
            $('#services-table').DataTable({
                "ordering": false,
                "paging": false,
                "info": false,
                "searching": false
            });
        }

        // Initialize Sortable
        $("#sortable-services").sortable({
            handle: ".drag-handle",
            update: function(event, ui) {
                let order = [];
                $('#sortable-services tr.sortable-row').each(function(index, element) {
                    let rowId = $(this).data('id');
                    if (rowId) {
                        order.push({
                            id: rowId,
                            position: index + 1
                        });
                    }
                });

                $.ajax({
                    url: '{{ route("admin.settings.pages.home.service.reorder") }}',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        order: order
                    }),
                    success: function(response) {
                        if (response.success) {
                            console.log('Order updated');
                            // Use toastr if available, otherwise silent or alert
                            if (typeof toastr !== 'undefined') {
                                toastr.success('Service order updated successfully');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating order:', error);
                        console.error(xhr.responseText);
                        alert('Failed to save new order. Check console for details.');
                    }
                });
            }
        });
    });
</script>
@endsection
