@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-plus"></i> Add New Vehicle</h3>
            <a href="{{ url('/admin/vehicles') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Vehicles
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/vehicles') }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Vehicle Details</h4>
                    
                    <div class="form-group">
                        <label for="vehicle_name">Vehicle Name <span class="text-danger">*</span></label>
                        <input type="text" name="vehicle_name" id="vehicle_name" class="modern-input" placeholder="Enter vehicle name" value="{{ old('vehicle_name') }}" required>
                        @error('vehicle_name')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Type <span class="text-danger">*</span></label>
                        <input type="text" name="type" id="type" class="modern-input" placeholder="e.g., SUV, Sedan, Minivan" value="{{ old('type') }}" required>
                        @error('type')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="seating">Seating Capacity <span class="text-danger">*</span></label>
                        <input type="number" name="seating" id="seating" class="modern-input" placeholder="Enter number of seats" value="{{ old('seating') }}" min="1" required>
                        @error('seating')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="cost_type">Cost Type <span class="text-danger">*</span></label>
                            <select name="cost_type" id="cost_type" class="modern-input" required>
                                <option value="per_day" {{ old('cost_type') == 'per_day' ? 'selected' : '' }}>Cost Per Day</option>
                                <option value="per_km" {{ old('cost_type') == 'per_km' ? 'selected' : '' }}>Cost Per KM</option>
                            </select>
                            @error('cost_type')
                                <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cost">Cost Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="cost" id="cost" class="modern-input" placeholder="Enter cost amount" value="{{ old('cost') }}" min="0" required>
                            @error('cost')
                                <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Side: Vehicle Image -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-image"></i> Vehicle Image</h4>
                    
                    <div class="form-group">
                        <label>Image Upload</label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="image" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload Image</span>
                            </div>
                            <img src="" class="image-preview" alt="Vehicle Preview" style="border-radius: 8px;">
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
                <a href="{{ url('/admin/vehicles') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Vehicle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
@endsection
