@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <h3><i class="fa-solid fa-pen-to-square"></i> Edit Testimonial</h3>
    </div>
    <div class="page-panel-body">
        
        <form action="{{ url('/admin/settings/testimonial/' . $testimonial->id) }}" method="POST" enctype="multipart/form-data" class="validate-form">
            @csrf
            @method('PUT')
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Client Details</h4>
                    
                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Client Name <span class="text-danger">*</span></label>
                            <input type="text" name="client_name" class="modern-input" value="{{ old('client_name', $testimonial->client_name) }}" placeholder="e.g. John Doe" required>
                        </div>

                        <div class="form-group">
                            <label>Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="modern-input" value="{{ old('designation', $testimonial->designation) }}" placeholder="e.g. CEO, Travel Agent" required>
                        </div>
                    </div>

                    <div class="form-input-grid">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="modern-input" value="{{ old('email', $testimonial->email) }}" placeholder="john@example.com" email="true">
                        </div>

                        <div class="form-group">
                            <label>Rating <span class="text-danger">*</span></label>
                            <select name="rating" class="modern-input" required>
                                <option value="" disabled>Select Rating</option>
                                <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>5 Stars</option>
                                <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4 Stars</option>
                                <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3 Stars</option>
                                <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>2 Stars</option>
                                <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>1 Star</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Review <span class="text-danger">*</span></label>
                        <textarea name="review" class="modern-input" rows="5" placeholder="Enter testimonial review..." required>{{ old('review', $testimonial->review) }}</textarea>
                    </div>
                </div>

                <!-- Right Side: Profile Picture Upload -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-image"></i> Client Profile Picture</h4>
                    
                    <div class="form-group">
                        <label>Profile Image (DP)</label>
                        <div class="image-upload-wrapper">
                            <input type="hidden" name="remove_client_dp" class="remove-input" value="0">
                            <input type="file" name="client_dp" class="image-upload-input" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Upload DP</span>
                            </div>
                            <img src="{{ $testimonial->client_dp ? asset($testimonial->client_dp) : '' }}" class="image-preview" alt="DP Preview" style="border-radius: 50%;">
                            <div class="image-remove-btn"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Supported: JPG, PNG, GIF, SVG, WEBP. Max: 4MB.</p>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">
            
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ url('/admin/settings/testimonial') }}" class="modern-btn" style="background-color: #6B7280; border-color: #6B7280; text-decoration: none;">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Update Testimonial
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
@endsection
