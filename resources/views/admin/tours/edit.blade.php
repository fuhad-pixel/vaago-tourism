@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/tour.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-pen-to-square"></i> Edit Tour: {{ $tour->tour_code }}</h3>
            <a href="{{ url('/admin/tours') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Tours
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/tours/' . $tour->id) }}" method="POST" class="validate-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-section-grid">
                <!-- Left Side: Basic Info, Pricing, Additional Inclusions, Related Tours, Itineraries -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Basic Information</h4>
                    
                    <div class="form-group">
                        <label for="name">Tour Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="modern-input" placeholder="Enter tour name" value="{{ old('name', $tour->name) }}" required>
                        @error('name')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Tour Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slug" class="modern-input" placeholder="tour-slug" value="{{ old('slug', $tour->slug) }}" required>
                        @error('slug')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="overview">Overview</label>
                        <textarea name="overview" id="overview" class="modern-input ckeditor-init" rows="5">{{ old('overview', $tour->overview) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="inclusions">Inclusions</label>
                        <textarea name="inclusions" id="inclusions" class="modern-input ckeditor-init" rows="5">{{ old('inclusions', $tour->inclusions) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="exclusions">Exclusions</label>
                        <textarea name="exclusions" id="exclusions" class="modern-input ckeditor-init" rows="5">{{ old('exclusions', $tour->exclusions) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="terms_and_conditions">Terms & Conditions</label>
                        <textarea name="terms_and_conditions" id="terms_and_conditions" class="modern-input ckeditor-init" rows="5">{{ old('terms_and_conditions', $tour->terms_and_conditions) }}</textarea>
                    </div>



                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-folder-plus"></i> Additional Inclusions</h4>
                    <div class="form-group multi-select-container">
                        <label for="additional_inclusions">Select Additional Inclusions</label>
                        @php
                            $selectedInclusions = old('additional_inclusions', $tour->additional_inclusions ?? []);
                        @endphp
                        <select name="additional_inclusions[]" id="additional_inclusions" class="modern-input select2-init" multiple>
                            @foreach($additionalInclusions as $inclusion)
                                <option value="{{ $inclusion->id }}" {{ (is_array($selectedInclusions) && in_array($inclusion->id, $selectedInclusions)) ? 'selected' : '' }}>
                                    {{ $inclusion->name }}
                                </option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</p>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-earth-americas"></i> Destinations</h4>
                    <div class="form-group multi-select-container">
                        <label for="destination_id">Select Destinations <span class="text-danger">*</span></label>
                        @php
                            $selectedDestinations = old('destination_id', $tour->destination_id ?? []);
                        @endphp
                        <select name="destination_id[]" id="destination_id" class="modern-input select2-init" multiple required>
                            @foreach($destinations as $destination)
                                <option value="{{ $destination->id }}" {{ (is_array($selectedDestinations) && in_array($destination->id, $selectedDestinations)) ? 'selected' : '' }}>
                                    {{ $destination->name }}
                                </option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</p>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-link"></i> Related Tours</h4>
                    <div class="form-group multi-select-container">
                        <label for="related_tours">Select Related Tours</label>
                        @php
                            $selectedRelatedTours = old('related_tours', $tour->related_tours ?? []);
                        @endphp
                        <select name="related_tours[]" id="related_tours" class="modern-input select2-init" multiple>
                            @foreach($allTours as $t)
                                <option value="{{ $t->id }}" {{ (is_array($selectedRelatedTours) && in_array($t->id, $selectedRelatedTours)) ? 'selected' : '' }}>
                                    {{ $t->name }} ({{ $t->tour_code }})
                                </option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</p>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-map-location-dot"></i> Itineraries</h4>
                    <div id="itineraries-container">
                        @php
                            $itineraries = old('itineraries', $tour->itineraries->toArray());
                        @endphp
                        @if($itineraries)
                            @foreach($itineraries as $index => $itinerary)
                            <div class="repeater-block itinerary-block">
                                <div class="repeater-header">
                                    <i class="fa-solid fa-calendar-day"></i> Day <span class="day-number">{{ $index + 1 }}</span>
                                </div>
                                <div class="btn-duplicate" title="Duplicate Itinerary"><i class="fa-regular fa-copy"></i></div>
                                <div class="btn-remove" title="Remove Itinerary"><i class="fa-solid fa-trash-can"></i></div>
                                <div class="form-group">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="itineraries[{{ $index }}][title]" class="modern-input required-itinerary-title" placeholder="Enter title" value="{{ $itinerary['title'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="itineraries[{{ $index }}][description]" class="modern-input ckeditor-init" rows="5">{{ $itinerary['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <button id="btn-add-itinerary" class="btn-add-repeater" type="button"><i class="fa-solid fa-plus"></i> Add Itinerary Day</button>
                    @error('itineraries.*.title')<span class="error-message text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <!-- Right Side: Categorization, FAQs, Images, Duration, Guest Capacity -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-list"></i> Categorization</h4>
                    <div class="form-group">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="modern-input select2-init" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $tour->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-circle-question"></i> Global FAQs</h4>
                    <div class="form-group multi-select-container">
                        <label for="faqs">Select FAQs</label>
                        @php
                            $selectedFaqs = old('faqs', $tour->faqs->pluck('id')->toArray());
                        @endphp
                        <select name="faqs[]" id="faqs" class="modern-input select2-init" multiple>
                            @foreach($faqs as $faq)
                                <option value="{{ $faq->id }}" {{ (is_array($selectedFaqs) && in_array($faq->id, $selectedFaqs)) ? 'selected' : '' }}>
                                    {{ $faq->question }}
                                </option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</p>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-tags"></i> Pricing</h4>
                    <div class="form-group">
                        <label for="original_price">Original Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="original_price" id="original_price" class="modern-input" value="{{ old('original_price', $tour->original_price) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="discount_price">Discount Price ($)</label>
                        <input type="number" step="0.01" name="discount_price" id="discount_price" class="modern-input" value="{{ old('discount_price', $tour->discount_price) }}">
                    </div>
                    <div class="form-group">
                        <label for="price_type">Price Type <span class="text-danger">*</span></label>
                        <select name="price_type" id="price_type" class="modern-input select2-init" required>
                            <option value="per_person" {{ old('price_type', $tour->price_type) == 'per_person' ? 'selected' : '' }}>Per Person</option>
                            <option value="per_vehicle" {{ old('price_type', $tour->price_type) == 'per_vehicle' ? 'selected' : '' }}>Per Vehicle</option>
                            <option value="per_group" {{ old('price_type', $tour->price_type) == 'per_group' ? 'selected' : '' }}>Per Group</option>
                        </select>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-images"></i> Tour Images</h4>
                    <div class="form-group">
                        <label>Upload New Images</label>
                        <div class="multi-image-upload-wrapper">
                            <input type="file" name="images[]" class="multi-image-input" accept="image/*" multiple>
                            <div class="upload-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span>Drag & Drop or Click to Upload Multiple Images</span>
                            </div>
                        </div>
                        <div class="multi-image-preview-container" id="image-preview-container"></div>

                        @if($tour->images && $tour->images->count() > 0)
                            <label style="margin-top: 16px;">Existing Images</label>
                            <div class="multi-image-preview-container existing-images-container">
                                @foreach($tour->images as $image)
                                    <div class="preview-item existing-image" data-id="{{ $image->id }}">
                                        <img src="{{ asset($image->image_path) }}" alt="Tour Image">
                                        <div class="remove-btn existing-remove-btn" title="Remove Image"><i class="fa-solid fa-xmark"></i></div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-clock"></i> Tour Duration</h4>
                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="duration_days">Days</label>
                                <input type="number" name="duration_days" id="duration_days" class="modern-input" min="0" value="{{ old('duration_days', $tour->duration_days ?? 0) }}">
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="duration_nights">Nights</label>
                                <input type="number" name="duration_nights" id="duration_nights" class="modern-input" min="0" value="{{ old('duration_nights', $tour->duration_nights ?? 0) }}">
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="duration_hours">Hours</label>
                                <input type="number" name="duration_hours" id="duration_hours" class="modern-input" min="0" max="23" value="{{ old('duration_hours', $tour->duration_hours ?? 0) }}">
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="duration_minutes">Minutes</label>
                                <input type="number" name="duration_minutes" id="duration_minutes" class="modern-input" min="0" max="59" value="{{ old('duration_minutes', $tour->duration_minutes ?? 0) }}">
                            </div>
                        </div>
                    </div>

                    <h4 class="form-section-title" style="margin-top: 24px;"><i class="fa-solid fa-users"></i> Guest Capacity</h4>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="min_guests">Minimum Guests</label>
                                <input type="number" name="min_guests" id="min_guests" class="modern-input" min="1" value="{{ old('min_guests', $tour->min_guests) }}" placeholder="No minimum">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="max_guests">Maximum Guests</label>
                                <input type="number" name="max_guests" id="max_guests" class="modern-input" min="1" value="{{ old('max_guests', $tour->max_guests) }}" placeholder="No maximum">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ url('/admin/tours') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Update Tour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/tour.js') }}"></script>
@endsection
