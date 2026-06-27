@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/quotation.css') }}">
    <style>
        /* Custom enhancements for premium aesthetics */
        .q-input-group {
            position: relative;
        }
        .q-input-group .input-addon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-secondary);
        }
        .q-input-group input {
            padding-right: 50px;
        }
        /* Rich Text Custom Layout */
        .editor-container-custom {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            display: flex;
            flex-direction: column;
        }
        .editor-container-custom .ck-editor__editable_inline {
            min-height: 160px !important;
        }
        .editor-toolbar-custom {
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .editor-btn-custom {
            background: none;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            color: #475569;
            font-size: 0.85rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .editor-btn-custom:hover {
            background: #E2E8F0;
            color: #0f172a;
        }
        .editor-btn-custom.active {
            background: rgba(41, 108, 114, 0.1);
            color: var(--primary);
        }
        .editor-area-custom {
            padding: 16px;
            min-height: 140px;
            outline: none;
            font-size: 0.9rem;
            line-height: 1.6;
            overflow-y: auto;
        }
        .editor-footer-custom {
            padding: 6px 12px;
            background: #F8FAFC;
            border-top: 1px solid #E2E8F0;
            text-align: right;
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 600;
        }
        /* 2-column grid layout */
        .form-row-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 16px;
        }
        body.sidebar-collapsed .form-row-grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }
        @media (max-width: 576px) {
            .form-row-grid-2,
            body.sidebar-collapsed .form-row-grid-2 {
                grid-template-columns: 1fr;
            }
        }
        /* Prevent table and layout horizontal overflow */
        .quotation-middle-column {
            min-width: 0;
        }
        .activities-table-wrapper {
            overflow-x: auto !important;
        }
        /* Ensure select options and background colors are legible and visible */
        select.q-select, select.q-select option, select option {
            color: #1e293b !important;
            background-color: #ffffff !important;
            color-scheme: light !important;
        }

        /* Custom Highlights Modal Styling */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        .custom-modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        .custom-modal-box {
            background: #ffffff;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: scale(0.9);
            transition: transform 0.3s ease;
            overflow: hidden;
        }
        .custom-modal-overlay.active .custom-modal-box {
            transform: scale(1);
        }
        .custom-modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .custom-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
        }
        .custom-modal-close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #64748b;
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
            padding: 0;
        }
        .custom-modal-close-btn:hover {
            color: #0f172a;
        }
        .custom-modal-body {
            padding: 24px;
        }
        .custom-modal-body label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }
        .custom-modal-body input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .custom-modal-body input:focus {
            border-color: var(--primary, #296c72);
            box-shadow: 0 0 0 3px rgba(41, 108, 114, 0.15);
        }
        .custom-modal-footer {
            padding: 16px 24px;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .custom-modal-btn {
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }
        .custom-modal-btn-cancel {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
        }
        .custom-modal-btn-cancel:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .custom-modal-btn-submit {
            background: var(--primary, #296c72);
            color: #ffffff;
        }
        .custom-modal-btn-submit:hover {
            opacity: 0.9;
        }
    </style>
@endsection

@section('content')
<script>
    // Collapse the main admin sidebar immediately to show the premium 3-column layout
    document.body.classList.add('sidebar-collapsed');
</script>
<div class="container-fluid" style="padding: 0;">

    <!-- Top Quotation Bar -->
    <div class="quotation-header-bar">
        <div class="qh-left">
            <div class="qh-title-group">
                <h2 id="page-title-display">Edit Itinerary - Day 1</h2>
                @if($quotation->quotation_code)
                    <span class="qh-status-badge" style="background: rgba(41, 108, 114, 0.1); color: var(--primary); margin-right: 6px;">{{ $quotation->quotation_code }}</span>
                @endif
                <span class="qh-status-badge">{{ $quotation->status ?? 'Draft' }}</span>
            </div>
            <div class="qh-subtitle">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span id="autosave-timestamp">Autosaved a few seconds ago</span>
            </div>
        </div>
        <div class="qh-right">
            <a href="{{ url('/admin/quotations') }}" class="q-btn-outline" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fa-solid fa-arrow-left"></i> Back to Quotations
            </a>
            <button type="button" class="q-btn-outline" onclick="openPreviewModal('all')">
                <i class="fa-solid fa-eye"></i> Preview Itinerary
            </button>
            <button type="button" class="q-btn-outline" onclick="triggerSave('draft')">
                <i class="fa-solid fa-floppy-disk"></i> Save as Draft
            </button>
            <button type="button" class="q-btn-primary" onclick="triggerSave('save')">
                <i class="fa-solid fa-circle-check"></i> Save Itinerary
            </button>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="quotation-grid-layout">

        <!-- Column 1: Itinerary Days Sidebar -->
        <div class="q-glass-panel days-sidebar">
            <div class="q-panel-header">
                <span class="q-panel-title"><i class="fa-solid fa-calendar-days"></i> Itinerary Days</span>
            </div>
            
            <ul class="days-list" id="sidebar-days-list">
                <!-- Days will be loaded here dynamically -->
            </ul>

            <div class="sidebar-actions-footer">
                <button type="button" class="btn-add-day" id="btn-add-new-day">
                    <i class="fa-solid fa-plus"></i> Add New Day
                </button>
                <div class="sidebar-row-btns">
                    <button type="button" class="btn-dup-day" id="btn-duplicate-day">
                        <i class="fa-regular fa-copy"></i> Duplicate Day
                    </button>
                    <button type="button" class="btn-del-day" id="btn-delete-day">
                        <i class="fa-regular fa-trash-can"></i> Delete Day
                    </button>
                </div>
            </div>
        </div>

        <!-- Column 2: Itinerary Form (Middle) -->
        <div class="quotation-middle-column">
            <div class="q-glass-panel" style="margin-bottom: 16px;">
                <h4 class="form-section-title"><i class="fa-solid fa-file-signature"></i> Quotation Setup</h4>
                
                <div class="form-row-grid-2">
                    <div class="form-group-custom">
                        <label for="input-lead-id">Select Lead <span class="text-danger">*</span></label>
                        <select id="input-lead-id" class="q-select">
                            <option value="">-- Choose Lead --</option>
                            @foreach($leads as $lead)
                                <option value="{{ $lead->id }}" @selected($quotation->lead_id == $lead->id) data-adults="{{ $lead->adults ?? 0 }}" data-children="{{ $lead->children ?? 0 }}" data-infants="{{ $lead->infants ?? 0 }}">{{ $lead->name }} ({{ $lead->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label for="input-quotation-title">Quotation Title</label>
                        <input type="text" id="input-quotation-title" class="q-input" placeholder="e.g. Kerala Family Tour" value="{{ $quotation->title }}">
                    </div>
                </div>

                <div class="form-row-grid trans-row-1" style="margin-top: 16px;">
                    <div class="form-group-custom">
                        <label for="input-global-adults">Adults</label>
                        <input type="number" id="input-global-adults" class="q-input" value="{{ $quotation->adults ?? 0 }}" min="0">
                    </div>
                    <div class="form-group-custom">
                        <label for="input-global-children">Children</label>
                        <input type="number" id="input-global-children" class="q-input" value="{{ $quotation->children ?? 0 }}" min="0">
                    </div>
                    <div class="form-group-custom">
                        <label for="input-global-infants">Infants</label>
                        <input type="number" id="input-global-infants" class="q-input" value="{{ $quotation->infants ?? 0 }}" min="0">
                    </div>
                </div>

                <div class="form-group-custom" style="margin-top: 16px;">
                    <label>Banner Image</label>
                    <div class="image-upload-wrapper {{ $quotation->banner_image ? 'has-image' : '' }}">
                        <input type="file" id="input-banner-image" class="image-upload-input" accept="image/*">
                        <div class="upload-placeholder" style="{{ $quotation->banner_image ? 'display: none;' : '' }}">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Upload Banner Image</span>
                        </div>
                        <img src="{{ $quotation->banner_image ? asset($quotation->banner_image) : '' }}" class="image-preview" alt="Banner Preview" style="border-radius: 8px; {{ $quotation->banner_image ? 'display: block;' : '' }}">
                        <div class="image-remove-btn" style="{{ $quotation->banner_image ? 'display: flex;' : '' }}"><i class="fa-solid fa-xmark"></i></div>
                    </div>
                </div>
                <div class="form-group-custom" style="margin-top: 16px;">
                    <label for="input-terms-conditions">Terms & Conditions</label>
                    <textarea class="ckeditor-init" id="input-terms-conditions" name="terms_and_conditions">{{ old('terms_and_conditions', $quotation->terms_and_conditions) }}</textarea>
                </div>
            </div>

            <div class="q-glass-panel">
                <form id="quotation-day-form" onsubmit="event.preventDefault();">
                    
                    <!-- Basic Information -->
                <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Basic Information</h4>
                <div class="form-row-grid-2">
                    <div class="form-group-custom">
                        <label for="input-day-number">Day Number</label>
                        <input type="number" id="input-day-number" class="q-input" min="1" required>
                    </div>
                    <div class="form-group-custom">
                        <label for="input-date">Date</label>
                        <input type="date" id="input-date" class="q-input" required>
                    </div>
                </div>

                <div class="form-row-grid-2">
                    <div class="form-group-custom">
                        <label for="input-start-point">Start Point</label>
                        <select id="input-start-point" class="q-select">
                            <option value="">-- Select Destination --</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label for="input-end-point">End Point</label>
                        <select id="input-end-point" class="q-select">
                            <option value="">-- Select Destination --</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row-grid-2">
                    <div class="form-group-custom">
                        <label for="input-distance">Distance</label>
                        <div class="q-input-group">
                            <input type="number" id="input-distance" class="q-input" min="0" placeholder="e.g. 15">
                            <span class="input-addon">KM</span>
                        </div>
                    </div>
                    <div class="form-group-custom">
                        <label for="input-travel-time">Travel Time</label>
                        <div class="q-input-group">
                            <input type="text" id="input-travel-time" class="q-input" placeholder="e.g. 00:45">
                            <span class="input-addon">Hours</span>
                        </div>
                    </div>
                </div>

                <div class="form-row-grid-2">
                    <div class="form-group-custom" style="grid-column: span 2;">
                        <label for="input-day-title">Day Title (For Display)</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="input-day-title" class="q-input" style="flex: 1;" placeholder="e.g. Kochi - Fort Kochi">
                            <button type="button" class="btn-map-select" onclick="simulateMapSelection();">
                                <i class="fa-solid fa-map-pin"></i> Select on Map
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Accommodation Details -->
                <h4 class="form-section-title"><i class="fa-solid fa-hotel"></i> Accommodation Details</h4>
                <div class="form-row-grid-2">
                    <div class="form-group-custom">
                        <label for="input-hotel-id">Select Hotel</label>
                        <select id="input-hotel-id" class="q-select" onchange="onHotelSelected(this.value)">
                            <option value="">-- No Accommodation --</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label for="input-room-type">Room Type</label>
                        <select id="input-room-type" class="q-select" onchange="onRoomTypeSelected(this.value)">
                            <option value="">-- Select Room Type --</option>
                        </select>
                    </div>
                </div>

                <!-- Description & Hotel Card Preview -->
                <h4 class="form-section-title"><i class="fa-solid fa-align-left"></i> Description</h4>
                <div class="editor-layout-row">
                    <!-- Custom rich text area -->
                    <div class="editor-container-custom" style="padding: 10px;">
                        <textarea class="ckeditor-init" id="input-description" name="description"></textarea>
                    </div>

                    <!-- Hotel Preview Card -->
                    <div class="hotel-card-preview">
                        <div class="hotel-card-image">
                            <img id="hotel-card-image-display" src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400&q=80" alt="Hotel Room">
                        </div>
                        <div class="hotel-card-body">
                            <div class="hotel-card-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="hotel-card-title" id="hotel-card-title-display">Brunton Boatyard</div>
                            <div class="hotel-card-reviews" id="hotel-card-reviews-display">4.5 (320 Reviews)</div>
                            <div class="hotel-card-links">
                                <a href="javascript:void(0)" class="hotel-card-link" onclick="simulateHotelLink('website')"><i class="fa-solid fa-globe"></i> Website</a>
                                <a href="javascript:void(0)" class="hotel-card-link" onclick="simulateHotelLink('details')"><i class="fa-solid fa-eye"></i> View Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Highlights -->
                <h4 class="form-section-title"><i class="fa-solid fa-circle-check"></i> Highlights</h4>
                <div class="highlights-checkbox-grid" id="highlights-container">
                    <!-- Highlights list checkboxes will load here dynamically -->
                </div>
                <button type="button" class="btn-add-highlight-link" onclick="addNewHighlightPrompt();">
                    <i class="fa-solid fa-plus"></i> Add New Highlight
                </button>

                <!-- Activities -->
                <h4 class="form-section-title"><i class="fa-solid fa-person-walking-luggage"></i> Activities <span style="font-weight: 500; font-size: 0.8rem; color: var(--text-secondary); margin-left: 4px;">(Optional)</span></h4>
                <div class="activities-table-wrapper">
                    <table class="activities-table">
                        <thead>
                            <tr>
                                <th style="width: 45%; min-width: 250px;">Activity Name</th>
                                <th style="width: 10%; min-width: 80px;">Adults</th>
                                <th style="width: 10%; min-width: 80px;">Children</th>
                                <th style="width: 10%; min-width: 80px;">Infants</th>
                                <th style="width: 15%; min-width: 120px;">Cost (INR)</th>
                                <th style="width: 10%; min-width: 60px; text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="activities-table-body">
                            <!-- Activities rows will load here dynamically -->
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn-add-activity-link" onclick="addNewActivityRow();">
                    <i class="fa-solid fa-plus"></i> Add Activity
                </button>

                <!-- Images Gallery tabs -->
                <h4 class="form-section-title"><i class="fa-solid fa-images"></i> Media Gallery</h4>
                <div class="images-tabs-bar">
                    <button type="button" class="img-tab-btn active" id="tab-btn-destination" onclick="switchImageTab('destination')">Destination Images</button>
                    <button type="button" class="img-tab-btn" id="tab-btn-custom" onclick="switchImageTab('custom')">Custom Images</button>
                </div>
                <div class="images-upload-grid" id="images-gallery-container">
                    <!-- Images will load here dynamically -->
                </div>
                <p class="img-caption-note">* Drag & drop to reorder images. First image will be the cover.</p>

                <!-- Transportation details -->
                <h4 class="form-section-title"><i class="fa-solid fa-bus"></i> Transportation Details</h4>
                <div class="form-row-grid trans-row-1">
                    <div class="form-group-custom">
                        <label for="input-vehicle">Vehicle</label>
                        <select id="input-vehicle" class="q-select">
                            <option value="">Select Vehicle</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->vehicle_name }}">{{ $vehicle->vehicle_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label for="input-driver-id">Driver</label>
                        <select id="input-driver-id" class="q-select" onchange="onDriverSelected(this.value)">
                            <option value="">-- No Driver --</option>
                            @foreach($drivers as $drv)
                                <option value="{{ $drv->driver_name }}">{{ $drv->driver_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label for="input-driver-mobile">Driver Mobile</label>
                        <input type="text" id="input-driver-mobile" class="q-input" placeholder="e.g. +91 98765 43210" readonly>
                    </div>
                </div>

                <div class="form-row-grid trans-row-2">
                    <div class="form-group-custom">
                        <label for="input-pickup-location">Pickup Location</label>
                        <input type="text" id="input-pickup-location" class="q-input" placeholder="e.g. Kochi Airport">
                    </div>
                    <div class="form-group-custom">
                        <label for="input-drop-location">Drop Location</label>
                        <input type="text" id="input-drop-location" class="q-input" placeholder="e.g. Fort Kochi">
                    </div>
                    <div class="form-group-custom">
                        <label for="input-km-included">KM Included</label>
                        <div class="q-input-group">
                            <input type="number" id="input-km-included" class="q-input" min="0" placeholder="e.g. 80">
                            <span class="input-addon">KM</span>
                        </div>
                    </div>
                    <div class="form-group-custom">
                        <label for="input-extra-km-charge">Extra KM Charge</label>
                        <div class="q-input-group">
                            <input type="number" id="input-extra-km-charge" class="q-input" min="0" placeholder="e.g. 15">
                            <span class="input-addon">/ KM</span>
                        </div>
                    </div>
                </div>

                <!-- Meal Details -->
                <h4 class="form-section-title"><i class="fa-solid fa-bowl-food"></i> Meal Details</h4>
                <div class="meals-checkbox-group" id="meals-container">
                    @foreach($meals as $meal)
                    <label class="meal-checkbox-item">
                        <input type="checkbox" value="{{ $meal->meal }}" class="meal-cb"> {{ $meal->meal }}
                    </label>
                    @endforeach
                </div>
            </form>
        </div>
        </div>

        <!-- Column 3: Itinerary Summary and Costing Summary (Right) -->
        <div class="summary-sidebar-wrapper">
            
            <!-- Itinerary Summary -->
            <div class="itinerary-summary-card">
                <div class="itinerary-sum-image">
                    <img id="summary-card-image" src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=400&q=80" alt="Itinerary summary cover image">
                </div>
                <div class="itinerary-sum-details">
                    <h3 class="itinerary-sum-title" id="summary-card-title">Day 1: Kochi - Fort Kochi</h3>
                    <div class="itinerary-sum-meta" id="summary-card-date">
                        <i class="fa-regular fa-calendar"></i> 10 May 2024
                    </div>
                    <div class="itinerary-sum-meta" id="summary-card-distance-time">
                        <i class="fa-solid fa-route"></i> 15 KM - 00:45 Hrs
                    </div>
                    <div class="itinerary-sum-meta" id="summary-card-stay">
                        <i class="fa-solid fa-bed"></i> 1 Night Stay
                    </div>
                </div>
            </div>

            <!-- Costing Summary -->
            <div class="costing-card">
                <div class="costing-header">
                    <span class="costing-title">Costing Summary</span>
                    <select class="currency-select" id="costing-currency">
                        <option value="INR" @selected($quotation->currency == 'INR')>INR (₹)</option>
                        <option value="USD" @selected($quotation->currency == 'USD')>USD ($)</option>
                    </select>
                </div>
                <div class="costing-rows">
                    <div class="costing-row-item">
                        <span class="costing-row-label">Hotel Cost</span>
                        <input type="number" class="costing-row-input cost-calc-trigger" id="cost-hotel" value="6000" min="0">
                    </div>
                    <div class="costing-row-item">
                        <span class="costing-row-label">Vehicle Cost</span>
                        <input type="number" class="costing-row-input cost-calc-trigger" id="cost-vehicle" value="2000" min="0">
                    </div>
                    <div class="costing-row-item">
                        <span class="costing-row-label">Activity Cost</span>
                        <input type="number" class="costing-row-input" id="display-cost-activity" value="0" readonly style="background: #F8FAFC; color: var(--text-secondary); cursor: not-allowed;">
                    </div>
                    <div class="costing-row-item">
                        <span class="costing-row-label">Extra Charges</span>
                        <input type="number" class="costing-row-input cost-calc-trigger" id="cost-extra" value="0" min="0">
                    </div>
                    <div class="costing-row-item">
                        <span class="costing-row-label">Discount</span>
                        <input type="number" class="costing-row-input cost-calc-trigger" id="cost-discount" value="0" min="0" style="color: #EF4444;">
                    </div>
                    <hr class="costing-divider">
                    <div class="costing-row-item">
                        <span class="costing-row-label">Sub Total</span>
                        <span class="costing-row-display" id="display-cost-subtotal">₹8,500</span>
                    </div>
                    <div class="costing-row-item">
                        <span class="costing-row-label">GST (5%)</span>
                        <span class="costing-row-display" id="display-cost-gst">₹425</span>
                    </div>
                    <hr class="costing-divider" style="margin: 6px 0;">
                    <div class="costing-total-row">
                        <span class="costing-total-label">Total Amount</span>
                        <span class="costing-total-value" id="display-cost-total">₹8,925</span>
                    </div>
                </div>
            </div>

            <!-- Inclusions -->
            <div class="inc-exc-card">
                <div class="inc-exc-title"><i class="fa-solid fa-circle-check"></i> Inclusions</div>
                <div class="inc-exc-list" id="inclusions-container">
                    <!-- Dynamic inclusions list checkable -->
                </div>
            </div>

            <!-- Exclusions -->
            <div class="inc-exc-card">
                <div class="inc-exc-title"><i class="fa-solid fa-circle-xmark"></i> Exclusions</div>
                <div class="inc-exc-list" id="exclusions-container">
                    <!-- Dynamic exclusions list checkable -->
                </div>
            </div>

        </div>

    </div>

    <!-- Bottom Actions Bar -->
    <div class="quotation-bottom-actions">
        <button type="button" class="q-btn-outline" onclick="triggerSave('draft')">
            <i class="fa-regular fa-floppy-disk"></i> Save as Draft
        </button>
        <div style="display: flex; gap: 12px;">
            <button type="button" class="q-btn-outline" onclick="openPreviewModal('all')">
                <i class="fa-solid fa-eye"></i> Preview Itinerary
            </button>
            <button type="button" class="q-btn-primary" onclick="triggerSave('save')">
                <i class="fa-solid fa-circle-check"></i> Save Itinerary
            </button>
        </div>
    </div>

</div>

<!-- Preview Modal -->
<div class="preview-modal-overlay" id="itinerary-preview-modal">
    <div class="preview-modal-container">
        <div class="preview-modal-header">
            <div class="preview-modal-title" id="preview-modal-heading">Preview Itinerary - Day Detail</div>
            <button type="button" class="preview-modal-close-btn" onclick="closePreviewModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="preview-modal-body">
            <div class="itinerary-print-wrapper" id="preview-print-content">
                <!-- Content injected dynamically -->
            </div>
            <div style="text-align: right; margin-top: 24px; border-top: 1px solid #E2E8F0; padding-top: 20px;">
                <button type="button" class="q-btn-outline" onclick="closePreviewModal()">Close Preview</button>
                <button type="button" class="q-btn-dark" onclick="window.print()"><i class="fa-solid fa-print"></i> Print / Save PDF</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Highlight Modal -->
<div class="custom-modal-overlay" id="add-highlight-modal">
    <div class="custom-modal-box">
        <div class="custom-modal-header">
            <h3>Add Day Highlight</h3>
            <button type="button" class="custom-modal-close-btn" onclick="closeHighlightModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <label for="new-highlight-input">Highlight Name</label>
            <input type="text" id="new-highlight-input" placeholder="e.g. Guided Historical Walk" onkeydown="if(event.key === 'Enter') submitHighlightModal()">
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="custom-modal-btn custom-modal-btn-cancel" onclick="closeHighlightModal()">Cancel</button>
            <button type="button" class="custom-modal-btn custom-modal-btn-submit" onclick="submitHighlightModal()">Add Highlight</button>
        </div>
    </div>
</div>

<!-- Hidden File Uploader for Media Gallery -->
<input type="file" id="upload-image-input" style="display: none;" multiple accept="image/*" onchange="handleImageUploadEvent(this)">

@endsection

<!-- File Input for Image Upload (Hidden) -->
@section('scripts')
<script src="{{ asset('assets/js/admin/image-preview.js') }}"></script>
<script>
    // State management for Itinerary Days - Pre-populated from database
    let days = @json($formattedDays);

    // Master JSON lists from Backend
    const masterHighlights = @json($savedHighlights ?? []);
    const masterInclusions = @json($inclusions->pluck('name'));
    const masterExclusions = @json($exclusions->pluck('name'));
    
    const masterHotels = @json($hotels);
    const masterDrivers = @json($drivers);
    const masterVehicles = @json($vehicles);
    const masterActivities = @json($activities);

    let currentDayIndex = 0;

    // Local storage key - unique for this quotation
    const quotationId = "{{ $quotation->id }}";
    const STORAGE_KEY = "vaago_quotation_edit_draft_" + quotationId;

    // Helper to compress images on the client-side to fit within localStorage limits (approx 5MB)
    function compressImage(base64Str, maxWidth, maxHeight, quality = 0.7) {
        return new Promise((resolve) => {
            const img = new Image();
            img.src = base64Str;
            img.onload = function() {
                let width = img.width;
                let height = img.height;

                if (width > maxWidth || height > maxHeight) {
                    if (width > height) {
                        height = Math.round((height * maxWidth) / width);
                        width = maxWidth;
                    } else {
                        width = Math.round((width * maxHeight) / height);
                        height = maxHeight;
                    }
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;

                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                const compressed = canvas.toDataURL('image/jpeg', quality);
                resolve(compressed);
            };
            img.onerror = function() {
                resolve(base64Str);
            };
        });
    }

    // Helper to convert base64 dataURL to Blob
    function dataURLtoBlob(dataurl) {
        try {
            var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new Blob([u8arr], {type:mime});
        } catch (e) {
            console.error("dataURLtoBlob error:", e);
            return null;
        }
    }

    // Load draft from local storage if it exists
    function loadDraftFromLocalStorage() {
        try {
            const rawDraft = localStorage.getItem(STORAGE_KEY);
            if (rawDraft) {
                if (confirm("You have unsaved changes from a previous session. Would you like to restore them?")) {
                    const draft = JSON.parse(rawDraft);
                    
                    // Restore top-level inputs if the element exists and draft value exists
                    if (draft.leadId) {
                        const el = document.getElementById("input-lead-id");
                        if (el) el.value = draft.leadId;
                    }
                    if (draft.title) {
                        const el = document.getElementById("input-quotation-title");
                        if (el) el.value = draft.title;
                    }
                    if (draft.adults) {
                        const el = document.getElementById("input-global-adults");
                        if (el) el.value = draft.adults;
                    }
                    if (draft.children) {
                        const el = document.getElementById("input-global-children");
                        if (el) el.value = draft.children;
                    }
                    if (draft.infants) {
                        const el = document.getElementById("input-global-infants");
                        if (el) el.value = draft.infants;
                    }
                    if (draft.currency) {
                        const el = document.getElementById("costing-currency");
                        if (el) el.value = draft.currency;
                    }
                    if (draft.bannerImage) {
                        const preview = document.querySelector(".image-preview");
                        const wrapper = document.querySelector(".image-upload-wrapper");
                        if (preview && wrapper) {
                            preview.src = draft.bannerImage;
                            preview.style.display = "block";
                            wrapper.classList.add("has-image");
                            const placeholder = wrapper.querySelector(".upload-placeholder");
                            if (placeholder) placeholder.style.display = "none";
                            const removeBtn = wrapper.querySelector(".image-remove-btn");
                            if (removeBtn) removeBtn.style.display = "flex";
                        }
                    }
                    
                    // Restore days
                    if (draft.days && draft.days.length > 0) {
                        days = draft.days;
                    }
                    
                    showToast("info", "Draft Restored", "Your unsaved progress has been restored.");
                }
            }
        } catch (e) {
            console.error("Error loading draft from local storage:", e);
        }
    }

    // Save draft to local storage
    function saveDraftToLocalStorage() {
        try {
            const preview = document.querySelector(".image-preview");
            let bannerBase64 = "";
            if (preview && preview.src && preview.src.startsWith("data:image/")) {
                bannerBase64 = preview.src;
            }

            const draft = {
                leadId: document.getElementById("input-lead-id")?.value || "",
                title: document.getElementById("input-quotation-title")?.value || "",
                adults: document.getElementById("input-global-adults")?.value || 0,
                children: document.getElementById("input-global-children")?.value || 0,
                infants: document.getElementById("input-global-infants")?.value || 0,
                currency: document.getElementById("costing-currency")?.value || "INR",
                bannerImage: bannerBase64,
                days: days
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(draft));
            updateAutosaveTimestamp();
        } catch (e) {
            console.error("Error saving draft to local storage:", e);
            if (e.name === 'QuotaExceededError' || e.code === 22) {
                showToast("warning", "Storage Limit Reached", "Your custom images are too large for offline draft storage. Please save as Draft to store them permanently on the server.");
            }
        }
    }

    // Clear local storage draft
    function clearLocalStorageDraft() {
        try {
            localStorage.removeItem(STORAGE_KEY);
        } catch (e) {
            console.error("Error clearing local storage draft:", e);
        }
    }

    function autosaveState() {
        saveCurrentDayData();
        saveDraftToLocalStorage();
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Clear draft on page load to ensure fresh database values are loaded
        clearLocalStorageDraft();
        
        // Initialize state
        renderDaysSidebar();
        loadDayData(currentDayIndex);
        
        // Wire up change events to automatically save updates
        const inputsToBind = [
            "input-day-number", "input-date", "input-start-point", "input-end-point",
            "input-distance", "input-travel-time", "input-day-title",
            "input-driver-id", "input-pickup-location", "input-drop-location", 
            "input-km-included", "input-extra-km-charge"
        ];
        
        inputsToBind.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener("input", autosaveState);
                el.addEventListener("change", autosaveState);
            }
        });

        // Wire up top-level setup fields
        const setupInputs = [
            "input-lead-id", "input-quotation-title", "input-global-adults", 
            "input-global-children", "input-global-infants"
        ];
        setupInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener("input", saveDraftToLocalStorage);
                el.addEventListener("change", saveDraftToLocalStorage);
            }
        });

        const vehicleSel = document.getElementById("input-vehicle");
        if(vehicleSel) {
            vehicleSel.addEventListener("change", function() {
                autosaveState();
                onVehicleSelected(this.value);
            });
        }
        
        const kmInc = document.getElementById("input-km-included");
        if(kmInc) {
            kmInc.addEventListener("input", function() {
                onVehicleSelected(document.getElementById("input-vehicle").value);
            });
        }

        $("#input-description").on("input change", function() {
            autosaveState();
            updateWordCount();
        });

        // Setup cost calculation binders
        document.querySelectorAll(".cost-calc-trigger").forEach(input => {
            input.addEventListener("input", function () {
                saveCostData();
                saveDraftToLocalStorage();
            });
        });

        // Currency change
        document.getElementById("costing-currency").addEventListener("change", function() {
            recalcCosting(days[currentDayIndex]);
            saveDraftToLocalStorage();
        });

        // Setup banner image change listener to compress and trigger local storage autosave
        const bannerImageInputObj = document.getElementById("input-banner-image");
        if (bannerImageInputObj) {
            bannerImageInputObj.addEventListener("change", function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        compressImage(evt.target.result, 1200, 800, 0.7).then(compressedBase64 => {
                            const preview = document.querySelector(".image-preview");
                            const wrapper = document.querySelector(".image-upload-wrapper");
                            if (preview && wrapper) {
                                preview.src = compressedBase64;
                                preview.style.display = "block";
                                wrapper.classList.add("has-image");
                                const placeholder = wrapper.querySelector(".upload-placeholder");
                                if (placeholder) placeholder.style.display = "none";
                                const removeBtn = wrapper.querySelector(".image-remove-btn");
                                if (removeBtn) removeBtn.style.display = "flex";
                            }
                            saveDraftToLocalStorage();
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        const bannerRemoveBtnObj = document.querySelector(".image-upload-wrapper .image-remove-btn");
        if (bannerRemoveBtnObj) {
            bannerRemoveBtnObj.addEventListener("click", function() {
                setTimeout(saveDraftToLocalStorage, 50);
            });
        }

        // Set up left sidebar buttons
        document.getElementById("btn-add-new-day").addEventListener("click", addNewDay);
        document.getElementById("btn-duplicate-day").addEventListener("click", duplicateDay);
        document.getElementById("btn-delete-day").addEventListener("click", deleteDay);

        // Word count init
        updateWordCount();
    });

    // Helper: Rich text formatting simulator
    function toggleStyle(btn) {
        btn.classList.toggle("active");
        showToast("info", "Style Toggled", "Formatting applied locally to selection.");
    }

    function updateWordCount() {
        let text = "";
        if (window.editorInstances && window.editorInstances['input-description']) {
            text = window.editorInstances['input-description'].getData();
            text = text.replace(/<[^>]*>/g, ' '); // Strip HTML tags
        } else {
            const el = document.getElementById("input-description");
            text = el ? el.value : "";
        }
        const cleanText = text.trim().replace(/\s+/g, ' ');
        const words = cleanText === "" ? 0 : cleanText.split(' ').length;
        
        const countDisplay = document.getElementById("word-count-display");
        if (countDisplay) {
            countDisplay.innerText = words;
        }
    }

    // Render left sidebar
    function renderDaysSidebar() {
        const container = document.getElementById("sidebar-days-list");
        container.innerHTML = "";
        
        days.forEach((day, index) => {
            const formattedDate = formatDateString(day.date);
            const activeClass = (index === currentDayIndex) ? "active" : "";
            
            const li = document.createElement("li");
            li.className = `day-item ${activeClass}`;
            li.onclick = () => selectDay(index);
            
            li.innerHTML = `
                <div class="day-item-left">
                    <div class="day-item-num">
                        Day ${day.dayNumber}
                        <span class="day-date">${formattedDate}</span>
                    </div>
                    <div class="day-item-title">${day.dayTitle || 'New Day'}</div>
                </div>
                <div class="day-item-actions" onclick="event.stopPropagation(); showDayOptions(${index}, this)">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            `;
            container.appendChild(li);
        });
    }

    // Select Day
    function selectDay(index) {
        saveCurrentDayData();
        currentDayIndex = index;
        renderDaysSidebar();
        loadDayData(currentDayIndex);
    }

    // Format YYYY-MM-DD to DD Month YYYY
    function formatDateString(str) {
        if (!str) return "";
        const parts = str.split('-');
        if (parts.length !== 3) return str;
        const date = new Date(parts[0], parts[1] - 1, parts[2]);
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    }

    // Load day data into forms
    function loadDayData(index) {
        const day = days[index];
        if (!day) return;

        // Defensive checks to prevent JS crashes on null/undefined properties
        day.highlights = day.highlights || [];
        day.activities = day.activities || [];
        day.meals = day.meals || [];
        day.inclusions = day.inclusions || [];
        day.exclusions = day.exclusions || [];
        day.images = day.images || { destination: [], custom: [] };
        day.images.destination = day.images.destination || [];
        day.images.custom = day.images.custom || [];

        // Basic Info
        document.getElementById("input-day-number").value = day.dayNumber;
        document.getElementById("input-date").value = day.date;
        document.getElementById("input-start-point").value = day.startPointId || "";
        document.getElementById("input-end-point").value = day.endPointId || "";
        document.getElementById("input-distance").value = day.distance;
        document.getElementById("input-travel-time").value = day.travelTime;
        document.getElementById("input-day-title").value = day.dayTitle;

        // Description
        if (window.editorInstances && window.editorInstances['input-description']) {
            window.editorInstances['input-description'].setData(day.description);
        } else {
            document.getElementById("input-description").value = day.description;
        }

        // Accommodation
        document.getElementById("input-hotel-id").value = day.hotelId || "";
        onHotelSelected(day.hotelId || "", day.roomTypeId || "", false);

        // Hotel display card
        document.getElementById("hotel-card-title-display").innerText = day.hotelName || "No Accommodation";
        document.getElementById("hotel-card-image-display").src = day.hotelImage || "https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400&q=80";
        document.getElementById("hotel-card-reviews-display").innerText = day.hotelReviews || "No reviews";

        // Highlights checkboxes
        renderHighlights(day);

        // Activities Table
        renderActivitiesTable(day);

        // Images Gallery
        switchImageTab(day.imagesTab || "destination");

        // Transportation
        const vehicleInput = document.getElementById("input-vehicle");
        vehicleInput.value = day.vehicle || "";
        
        const driverInput = document.getElementById("input-driver-id");
        driverInput.value = day.driverName || "";
        
        document.getElementById("input-driver-mobile").value = day.driverMobile || "";
        document.getElementById("input-pickup-location").value = day.pickupLocation;
        document.getElementById("input-drop-location").value = day.dropLocation;
        document.getElementById("input-km-included").value = day.kmIncluded;
        document.getElementById("input-extra-km-charge").value = day.extraKmCharge;

        // Meals Checkboxes
        document.querySelectorAll(".meal-cb").forEach(cb => {
            cb.checked = day.meals.includes(cb.value);
            cb.onchange = function() {
                saveCurrentDayData();
                saveDraftToLocalStorage();
            };
        });

        // Right summary card
        document.getElementById("summary-card-title").innerText = `Day ${day.dayNumber}: ${day.dayTitle || 'New Itinerary Day'}`;
        document.getElementById("summary-card-date").innerHTML = `<i class="fa-regular fa-calendar"></i> ${formatDateString(day.date)}`;
        document.getElementById("summary-card-distance-time").innerHTML = `<i class="fa-solid fa-route"></i> ${day.distance || 0} KM - ${day.dayTitle ? day.travelTime + ' Hrs' : '00:00 Hrs'}`;
        document.getElementById("summary-card-stay").innerHTML = `<i class="fa-solid fa-bed"></i> 1 Night Stay (${day.hotelName || 'No Accommodation'})`;
        
        // If image exists for this day, update summary cover image
        if (day.images.destination && day.images.destination.length > 0) {
            document.getElementById("summary-card-image").src = day.images.destination[0];
        } else {
            document.getElementById("summary-card-image").src = "https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=400&q=80";
        }

        // Costing Summary
        document.getElementById("cost-hotel").value = day.hotelCost;
        document.getElementById("cost-vehicle").value = day.vehicleCost;
        document.getElementById("cost-extra").value = day.extraCharges;
        document.getElementById("cost-discount").value = day.discount;

        // Inclusions / Exclusions
        renderInclusionsExclusions(day);

        // Recalc costing
        recalcCosting(day);

        // Update page title
        document.getElementById("page-title-display").innerText = `Edit Itinerary - Day ${day.dayNumber}`;
    }

    // Save form data into active day object
    function saveCurrentDayData() {
        const day = days[currentDayIndex];
        if (!day) return;

        // Basic Info
        day.dayNumber = parseInt(document.getElementById("input-day-number").value) || day.dayNumber;
        day.date = document.getElementById("input-date").value;
        
        const startPointSel = document.getElementById("input-start-point");
        day.startPointId = startPointSel.value;
        day.startPoint = startPointSel.options[startPointSel.selectedIndex]?.text || "";

        const endPointSel = document.getElementById("input-end-point");
        day.endPointId = endPointSel.value;
        day.endPoint = endPointSel.options[endPointSel.selectedIndex]?.text || "";

        day.distance = parseFloat(document.getElementById("input-distance").value) || 0;
        day.travelTime = document.getElementById("input-travel-time").value;
        day.dayTitle = document.getElementById("input-day-title").value;

        // Description
        if (window.editorInstances && window.editorInstances['input-description']) {
            day.description = window.editorInstances['input-description'].getData();
        } else {
            day.description = document.getElementById("input-description").value;
        }

        // Accommodation
        day.hotelId = document.getElementById("input-hotel-id").value;
        
        const roomTypeSel = document.getElementById("input-room-type");
        day.roomTypeId = roomTypeSel.value;
        if(day.roomTypeId) {
            day.roomTypeName = roomTypeSel.options[roomTypeSel.selectedIndex]?.text || "";
        } else {
            day.roomTypeName = "";
        }

        // Transportation
        const vehicleSel = document.getElementById("input-vehicle");
        day.vehicleId = "";
        day.vehicle = vehicleSel.value;
        
        const driverSel = document.getElementById("input-driver-id");
        day.driverId = "";
        day.driverName = driverSel.value;
        day.driverMobile = document.getElementById("input-driver-mobile").value;

        day.pickupLocation = document.getElementById("input-pickup-location").value;
        day.dropLocation = document.getElementById("input-drop-location").value;
        day.kmIncluded = parseFloat(document.getElementById("input-km-included").value) || 0;
        day.extraKmCharge = parseFloat(document.getElementById("input-extra-km-charge").value) || 0;

        // Meals
        day.meals = [];
        document.querySelectorAll(".meal-cb:checked").forEach(cb => {
            day.meals.push(cb.value);
        });

        // Update sidebar and summary immediately
        const formattedDate = formatDateString(day.date);
        const activeItem = document.querySelector("#sidebar-days-list .day-item.active");
        if (activeItem) {
            activeItem.querySelector(".day-item-num").innerHTML = `Day ${day.dayNumber} <span class="day-date">${formattedDate}</span>`;
            activeItem.querySelector(".day-item-title").innerText = day.dayTitle || 'New Day';
        }

        document.getElementById("summary-card-title").innerText = `Day ${day.dayNumber}: ${day.dayTitle || 'New Itinerary Day'}`;
        document.getElementById("summary-card-date").innerHTML = `<i class="fa-regular fa-calendar"></i> ${formattedDate}`;
        document.getElementById("summary-card-distance-time").innerHTML = `<i class="fa-solid fa-route"></i> ${day.distance} KM - ${day.travelTime} Hrs`;
        document.getElementById("page-title-display").innerText = `Edit Itinerary - Day ${day.dayNumber}`;

        updateAutosaveTimestamp();
    }

    // Save costing fields
    function saveCostData() {
        const day = days[currentDayIndex];
        if (!day) return;

        day.hotelCost = parseFloat(document.getElementById("cost-hotel").value) || 0;
        day.vehicleCost = parseFloat(document.getElementById("cost-vehicle").value) || 0;
        day.extraCharges = parseFloat(document.getElementById("cost-extra").value) || 0;
        day.discount = parseFloat(document.getElementById("cost-discount").value) || 0;

        recalcCosting(day);
        updateAutosaveTimestamp();
    }

    // Recalculate Subtotal, GST, and Total
    function recalcCosting(day) {
        const currencySymbol = document.getElementById("costing-currency").value === "USD" ? "$" : "₹";
        
        // Sum activity costs
        let activityCost = 0;
        day.activities.forEach(act => {
            activityCost += parseFloat(act.cost) || 0;
        });

        document.getElementById("display-cost-activity").value = activityCost;

        // Calculations
        const subtotal = day.hotelCost + day.vehicleCost + activityCost + day.extraCharges - day.discount;
        const gst = Math.round(subtotal * 0.05);
        const total = subtotal + gst;

        document.getElementById("display-cost-subtotal").innerText = `${currencySymbol}${formatNumber(subtotal)}`;
        document.getElementById("display-cost-gst").innerText = `${currencySymbol}${formatNumber(gst)}`;
        document.getElementById("display-cost-total").innerText = `${currencySymbol}${formatNumber(total)}`;
    }

    // Helper functions for dynamic lookups
    function onHotelSelected(hotelId, roomTypeId = "", shouldSave = true) {
        const day = days[currentDayIndex];
        const roomTypeSel = document.getElementById("input-room-type");
        roomTypeSel.innerHTML = '<option value="">-- Select Room Type --</option>';

        if (!hotelId) {
            day.hotelName = "";
            day.hotelImage = "";
            day.hotelReviews = "";
            return;
        }
        
        const hotel = masterHotels.find(h => h.id == hotelId);
        if (hotel) {
            day.hotelName = hotel.hotel_name;
            day.hotelImage = hotel.image ? '/' + hotel.image : '';
            day.hotelReviews = hotel.category + ' | ' + (hotel.star_rating || 3) + ' Star';
            
            // Populate room types
            if (hotel.room_rates && hotel.room_rates.length > 0) {
                hotel.room_rates.forEach(room => {
                    const option = document.createElement("option");
                    option.value = room.id;
                    option.text = room.room_type + (room.meal_plan ? ` (${room.meal_plan})` : '');
                    option.dataset.cost = room.selling_price;
                    if (room.id == roomTypeId) option.selected = true;
                    roomTypeSel.appendChild(option);
                });
            }
        }
        
        // Update display card
        document.getElementById("hotel-card-title-display").innerText = day.hotelName || "No Accommodation";
        document.getElementById("hotel-card-image-display").src = day.hotelImage || "https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400&q=80";
        document.getElementById("hotel-card-reviews-display").innerText = day.hotelReviews || "No reviews";
        
        if (shouldSave) {
            saveCurrentDayData();
            saveDraftToLocalStorage();
        }
    }

    function onRoomTypeSelected(roomTypeId) {
        const roomTypeSel = document.getElementById("input-room-type");
        if (roomTypeSel.selectedIndex > 0) {
            const cost = parseFloat(roomTypeSel.options[roomTypeSel.selectedIndex].dataset.cost) || 0;
            document.getElementById("cost-hotel").value = cost;
            saveCostData();
        }
        saveCurrentDayData();
        saveDraftToLocalStorage();
    }

    function onDriverSelected(driverName) {
        if (!driverName) {
            document.getElementById("input-driver-mobile").value = "";
            saveCurrentDayData();
            return;
        }
        const driver = masterDrivers.find(d => d.driver_name === driverName);
        if (driver) {
            document.getElementById("input-driver-mobile").value = driver.phone || driver.whatsapp_number || "";
            saveCurrentDayData();
        }
    }

    function onVehicleSelected(vehicleName) {
        if (!vehicleName) return;
        
        const vehicle = masterVehicles.find(v => v.vehicle_name === vehicleName);
        if (vehicle) {
            const kmIncluded = parseFloat(document.getElementById("input-km-included").value) || 0;
            let cost = 0;
            if (vehicle.cost_type === 'per_km') {
                cost = parseFloat(vehicle.cost) * kmIncluded;
            } else {
                cost = parseFloat(vehicle.cost);
            }
            document.getElementById("cost-vehicle").value = cost;
            saveCostData();
        }
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Render Highlights checkboxes
    function renderHighlights(day) {
        const container = document.getElementById("highlights-container");
        container.innerHTML = "";

        masterHighlights.forEach(hl => {
            const isChecked = day.highlights.includes(hl);
            const label = document.createElement("label");
            label.className = "highlight-checkbox-item";
            
            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.value = hl;
            checkbox.checked = isChecked;
            checkbox.onchange = function() {
                if (this.checked) {
                    if (!day.highlights.includes(hl)) day.highlights.push(hl);
                } else {
                    day.highlights = day.highlights.filter(item => item !== hl);
                }
                saveCurrentDayData();
                saveDraftToLocalStorage();
            };

            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(` ${hl}`));
            container.appendChild(label);
        });
    }

    // Add new custom highlight to master list and active day
    function addNewHighlightPrompt() {
        document.getElementById("new-highlight-input").value = "";
        document.getElementById("add-highlight-modal").classList.add("active");
        document.getElementById("new-highlight-input").focus();
    }

    function closeHighlightModal() {
        document.getElementById("add-highlight-modal").classList.remove("active");
    }

    function submitHighlightModal() {
        const input = document.getElementById("new-highlight-input");
        const text = input.value;
        if (text && text.trim() !== "") {
            const cleanText = text.trim();
            if (!masterHighlights.includes(cleanText)) {
                masterHighlights.push(cleanText);
            }
            if (!days[currentDayIndex].highlights.includes(cleanText)) {
                days[currentDayIndex].highlights.push(cleanText);
            }
            renderHighlights(days[currentDayIndex]);
            saveDraftToLocalStorage();
            showToast("success", "Highlight Added", `"${cleanText}" has been added and checked.`);
            closeHighlightModal();
        } else {
            showToast("error", "Error", "Highlight name cannot be empty.");
        }
    }

    // Render Activities Table
    function renderActivitiesTable(day) {
        const tbody = document.getElementById("activities-table-body");
        tbody.innerHTML = "";

        if (day.activities.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 20px;">
                        No activities added for this day. Click "+ Add Activity" to add one.
                    </td>
                </tr>
            `;
            return;
        }

        let activityOptions = `<option value="">-- Select Activity --</option>`;
        masterActivities.forEach(act => {
            activityOptions += `<option value="${act.id}" data-adult="${act.cost_adult || 0}" data-child="${act.cost_child || 0}" data-infant="${act.cost_infant || 0}">${act.name}</option>`;
        });

        day.activities.forEach((act, idx) => {
            const tr = document.createElement("tr");
            
            tr.innerHTML = `
                <td>
                    <select class="q-select activity-select act-name-input">
                        ${activityOptions}
                    </select>
                </td>
                <td>
                    <input type="number" class="activity-input act-adult-input" value="${act.adults || 0}" min="0">
                </td>
                <td>
                    <input type="number" class="activity-input act-child-input" value="${act.children || 0}" min="0">
                </td>
                <td>
                    <input type="number" class="activity-input act-infant-input" value="${act.infants || 0}" min="0">
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 4px;">
                        <input type="number" class="activity-input act-cost-input" value="${act.cost || 0}" min="0" style="text-align: left; width: 100%;">
                    </div>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="activity-delete-btn" onclick="deleteActivityRow(${idx})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            `;

            // Set selected activity
            if (act.id) {
                tr.querySelector(".act-name-input").value = act.id;
            }

            const calcCost = () => {
                const sel = tr.querySelector(".act-name-input");
                if (sel.selectedIndex > 0) {
                    const opt = sel.options[sel.selectedIndex];
                    const cAdult = parseFloat(opt.dataset.adult) || 0;
                    const cChild = parseFloat(opt.dataset.child) || 0;
                    const cInfant = parseFloat(opt.dataset.infant) || 0;
                    
                    const numAdults = parseInt(tr.querySelector(".act-adult-input").value) || 0;
                    const numChildren = parseInt(tr.querySelector(".act-child-input").value) || 0;
                    const numInfants = parseInt(tr.querySelector(".act-infant-input").value) || 0;

                    const totalCost = (cAdult * numAdults) + (cChild * numChildren) + (cInfant * numInfants);
                    tr.querySelector(".act-cost-input").value = totalCost;
                    
                    act.id = sel.value;
                    act.name = opt.text;
                    act.adults = numAdults;
                    act.children = numChildren;
                    act.infants = numInfants;
                    act.cost = totalCost;
                    
                    recalcCosting(day);
                    updateAutosaveTimestamp();
                }
            };

            // Bind events
            tr.querySelector(".act-name-input").addEventListener("change", calcCost);
            tr.querySelector(".act-adult-input").addEventListener("input", calcCost);
            tr.querySelector(".act-child-input").addEventListener("input", calcCost);
            tr.querySelector(".act-infant-input").addEventListener("input", calcCost);

            tr.querySelector(".act-cost-input").addEventListener("input", function() {
                act.cost = parseFloat(this.value) || 0;
                recalcCosting(day);
                updateAutosaveTimestamp();
            });

            tbody.appendChild(tr);
        });
    }

    // Add new activity row
    function addNewActivityRow() {
        const day = days[currentDayIndex];
        const gAdults = parseInt(document.getElementById("input-global-adults").value) || 0;
        const gChildren = parseInt(document.getElementById("input-global-children").value) || 0;
        const gInfants = parseInt(document.getElementById("input-global-infants").value) || 0;

        day.activities.push({ id: "", name: "", adults: gAdults, children: gChildren, infants: gInfants, cost: 0 });
        renderActivitiesTable(day);
        recalcCosting(day);
    }

    // Delete activity row
    function deleteActivityRow(idx) {
        const day = days[currentDayIndex];
        day.activities.splice(idx, 1);
        renderActivitiesTable(day);
        recalcCosting(day);
        showToast("info", "Activity Deleted", "The activity was removed successfully.");
    }

    // Switch image tab
    function switchImageTab(tabName) {
        const day = days[currentDayIndex];
        day.imagesTab = tabName;

        document.querySelectorAll(".img-tab-btn").forEach(btn => btn.classList.remove("active"));
        document.getElementById(`tab-btn-${tabName}`).classList.add("active");

        const container = document.getElementById("images-gallery-container");
        container.innerHTML = "";

        const imgList = day.images[tabName] || [];
        imgList.forEach((url, idx) => {
            const card = document.createElement("div");
            card.className = "img-thumb-card";
            card.innerHTML = `
                <img src="${url}" alt="Thumbnail">
                <div class="img-thumb-remove" onclick="removeImage(${idx})"><i class="fa-solid fa-xmark"></i></div>
            `;
            container.appendChild(card);
        });

        const addCard = document.createElement("div");
        addCard.className = "img-add-card-placeholder";
        addCard.onclick = () => document.getElementById("upload-image-input").click();
        addCard.innerHTML = `
            <i class="fa-solid fa-plus"></i>
            <span>Add Images</span>
        `;
        container.appendChild(addCard);
    }

    // Remove image from tab gallery
    function removeImage(idx) {
        const day = days[currentDayIndex];
        const tab = day.imagesTab;
        day.images[tab].splice(idx, 1);
        switchImageTab(tab);
        
        if (tab === "destination" && idx === 0) {
            if (day.images.destination.length > 0) {
                document.getElementById("summary-card-image").src = day.images.destination[0];
            } else {
                document.getElementById("summary-card-image").src = "https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=400&q=80";
            }
        }
        showToast("info", "Image Removed", "Image removed from local list.");
    }

    // Trigger image input click & handle uploads client-side
    function handleImageUploadEvent(input) {
        if (input.files && input.files.length > 0) {
            const day = days[currentDayIndex];
            const tab = day.imagesTab;
            
            const filePromises = Array.from(input.files).map(file => {
                return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        compressImage(evt.target.result, 800, 600, 0.7).then(compressedBase64 => {
                            resolve(compressedBase64);
                        });
                    };
                    reader.readAsDataURL(file);
                });
            });

            Promise.all(filePromises).then(compressedImages => {
                compressedImages.forEach(base64 => {
                    day.images[tab].push(base64);
                });
                
                switchImageTab(tab);

                // Update summary cover image if destination image added and it's the first
                if (tab === "destination" && day.images.destination.length === compressedImages.length) {
                    const coverEl = document.getElementById("summary-card-image");
                    if (coverEl) coverEl.src = day.images.destination[0];
                }
                
                showToast("success", "Images Added", `${compressedImages.length} images added to ${tab} gallery.`);
                input.value = ""; // reset input
                
                // Save state to local storage
                autosaveState();
            });
        }
    }

    // Render checkable Inclusions and Exclusions
    function renderInclusionsExclusions(day) {
        const incContainer = document.getElementById("inclusions-container");
        incContainer.innerHTML = "";
        
        masterInclusions.forEach(inc => {
            const isChecked = day.inclusions.includes(inc);
            const item = document.createElement("div");
            item.className = "inc-exc-item";
            
            item.innerHTML = `
                <div class="inc-exc-item-left">
                    <i class="fa-solid fa-check"></i>
                    <span>${inc}</span>
                </div>
                <input type="checkbox" class="inc-exc-checkbox" ${isChecked ? 'checked' : ''}>
            `;

            item.querySelector(".inc-exc-checkbox").onchange = function() {
                if (this.checked) {
                    if (!day.inclusions.includes(inc)) day.inclusions.push(inc);
                } else {
                    day.inclusions = day.inclusions.filter(item => item !== inc);
                }
                updateAutosaveTimestamp();
                saveDraftToLocalStorage();
            };

            incContainer.appendChild(item);
        });

        const excContainer = document.getElementById("exclusions-container");
        excContainer.innerHTML = "";
        
        masterExclusions.forEach(exc => {
            const isChecked = day.exclusions.includes(exc);
            const item = document.createElement("div");
            item.className = "inc-exc-item";
            
            item.innerHTML = `
                <div class="inc-exc-item-left">
                    <i class="fa-solid fa-xmark"></i>
                    <span>${exc}</span>
                </div>
                <input type="checkbox" class="inc-exc-checkbox" ${isChecked ? 'checked' : ''}>
            `;

            item.querySelector(".inc-exc-checkbox").onchange = function() {
                if (this.checked) {
                    if (!day.exclusions.includes(exc)) day.exclusions.push(exc);
                } else {
                    day.exclusions = day.exclusions.filter(item => item !== exc);
                }
                updateAutosaveTimestamp();
                saveDraftToLocalStorage();
            };

            excContainer.appendChild(item);
        });
    }

    // Add New Day in sidebar
    function addNewDay() {
        saveCurrentDayData();
        
        const lastDay = days[days.length - 1];
        const nextNum = lastDay ? lastDay.dayNumber + 1 : 1;
        
        let nextDateStr = "2024-05-10";
        if (lastDay && lastDay.date) {
            const parts = lastDay.date.split('-');
            const d = new Date(parts[0], parts[1] - 1, parts[2]);
            d.setDate(d.getDate() + 1);
            
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const dayStr = String(d.getDate()).padStart(2, '0');
            nextDateStr = `${y}-${m}-${dayStr}`;
        }

        const newDay = {
            dayNumber: nextNum,
            date: nextDateStr,
            startPoint: lastDay ? lastDay.endPoint : "",
            startPointId: lastDay ? lastDay.endPointId : "",
            endPoint: "",
            endPointId: "",
            distance: 0,
            travelTime: "00:00",
            dayTitle: "",
            description: "",
            highlights: [],
            activities: [],
            imagesTab: "destination",
            images: { destination: [], hotel: [], custom: [] },
            vehicleId: "",
            vehicle: "",
            driverId: "",
            driverName: "",
            driverMobile: "",
            pickupLocation: "",
            dropLocation: "",
            kmIncluded: 0,
            extraKmCharge: 0,
            meals: [],
            hotelId: "",
            hotelName: "",
            hotelImage: "",
            hotelRating: 0,
            hotelReviews: "",
            hotelCost: 0,
            vehicleCost: 0,
            roomTypeId: "",
            roomTypeName: "",
            extraCharges: 0,
            discount: 0,
            inclusions: [],
            exclusions: []
        };

        days.push(newDay);
        currentDayIndex = days.length - 1;
        
        renderDaysSidebar();
        loadDayData(currentDayIndex);
        showToast("success", "Day Added", `Itinerary Day ${nextNum} has been added.`);
    }

    // Duplicate Day
    function duplicateDay() {
        saveCurrentDayData();
        const activeDay = days[currentDayIndex];
        if (!activeDay) return;

        const clone = JSON.parse(JSON.stringify(activeDay));
        
        clone.dayNumber = days.length + 1;
        clone.dayTitle = `${clone.dayTitle} (Copy)`;
        
        const lastDay = days[days.length - 1];
        if (lastDay && lastDay.date) {
            const parts = lastDay.date.split('-');
            const d = new Date(parts[0], parts[1] - 1, parts[2]);
            d.setDate(d.getDate() + 1);
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const dayStr = String(d.getDate()).padStart(2, '0');
            clone.date = `${y}-${m}-${dayStr}`;
        }

        days.push(clone);
        currentDayIndex = days.length - 1;

        renderDaysSidebar();
        loadDayData(currentDayIndex);
        showToast("success", "Day Duplicated", `Day ${activeDay.dayNumber} copied to Day ${clone.dayNumber}.`);
    }

    // Delete Day
    function deleteDay() {
        if (days.length <= 1) {
            showToast("error", "Cannot Delete", "You must have at least one day in your itinerary.");
            return;
        }

        const activeDay = days[currentDayIndex];
        if (!confirm(`Are you sure you want to delete Day ${activeDay.dayNumber}?`)) {
            return;
        }

        days.splice(currentDayIndex, 1);
        
        days.forEach((day, index) => {
            day.dayNumber = index + 1;
        });

        currentDayIndex = Math.max(0, currentDayIndex - 1);

        renderDaysSidebar();
        loadDayData(currentDayIndex);
        showToast("warning", "Day Deleted", "Itinerary day deleted and subsequent days renumbered.");
    }

    function showDayOptions(idx, el) {
        showToast("info", `Day ${days[idx].dayNumber} Options`, "You can reorder days or mark them as optional (feature mockup).");
    }

    function updateAutosaveTimestamp() {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById("autosave-timestamp").innerText = `Autosaved at ${time}`;
    }

    function simulateMapSelection() {
        const locationName = prompt("Enter location address to find on map:", `${days[currentDayIndex].startPoint} to ${days[currentDayIndex].endPoint}`);
        if (locationName) {
            showToast("success", "Location Selected", `Map coordinates updated for: "${locationName}"`);
        }
    }

    function simulateHotelLink(type) {
        const hName = days[currentDayIndex].hotelName;
        showToast("info", "Opening Hotel Info", `Simulating navigation to ${hName}'s ${type}...`);
    }

    // Save/Update Quotation trigger
    function triggerSave(mode) {
        saveCurrentDayData();
        saveCostData();
        
        const leadId = document.getElementById("input-lead-id").value;
        if (!leadId) {
            showToast("error", "Validation Error", "Please select a Lead in Quotation Setup first.");
            return;
        }

        const currency = document.getElementById("costing-currency").value;
        const title = document.getElementById("input-quotation-title").value;
        const bannerImageInput = document.getElementById("input-banner-image");
        const adults = document.getElementById("input-global-adults").value;
        const children = document.getElementById("input-global-children").value;
        const infants = document.getElementById("input-global-infants").value;
        
        // Create a dynamic hidden form to perform a standard browser redirect save
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('quotations.update', $quotation->id) }}";
        form.enctype = 'multipart/form-data';
        form.style.display = 'none';

        // Add csrf token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Add method spoofing for PUT
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        let termsAndConditions = "";
        if (window.editorInstances && window.editorInstances['input-terms-conditions']) {
            termsAndConditions = window.editorInstances['input-terms-conditions'].getData();
        } else {
            termsAndConditions = document.getElementById("input-terms-conditions")?.value || "";
        }

        // Add fields
        const fields = {
            'lead_id': leadId,
            'status': mode === "draft" ? "Draft" : "Saved",
            'currency': currency,
            'title': title,
            'adults': adults,
            'children': children,
            'infants': infants,
            'days': JSON.stringify(days),
            'terms_and_conditions': termsAndConditions
        };

        for (const [key, value] of Object.entries(fields)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        // Add banner image file if exists
        if (bannerImageInput && bannerImageInput.files.length > 0) {
            const clonedInput = bannerImageInput.cloneNode(true);
            const dt = new DataTransfer();
            dt.items.add(bannerImageInput.files[0]);
            clonedInput.files = dt.files;
            clonedInput.name = 'banner_image';
            form.appendChild(clonedInput);
        } else {
            const preview = document.querySelector(".image-preview");
            if (preview && preview.src && preview.src.startsWith("data:image/")) {
                const blob = dataURLtoBlob(preview.src);
                if (blob) {
                    const file = new File([blob], "banner_image.png", {type: "image/png"});
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    const hiddenFileInput = document.createElement('input');
                    hiddenFileInput.type = 'file';
                    hiddenFileInput.name = 'banner_image';
                    hiddenFileInput.files = dt.files;
                    form.appendChild(hiddenFileInput);
                }
            }
        }

        // Clear local storage draft
        clearLocalStorageDraft();

        document.body.appendChild(form);
        form.submit();
    }

    // Open Preview Modal
    function openPreviewModal(scope) {
        saveCurrentDayData();
        
        const heading = document.getElementById("preview-modal-heading");
        const printContent = document.getElementById("preview-print-content");
        const currencySymbol = document.getElementById("costing-currency").value === "USD" ? "$" : "₹";
        
        let html = "";
        
        if (scope === "day") {
            const day = days[currentDayIndex];
            heading.innerText = `Preview - Day ${day.dayNumber}: ${day.dayTitle}`;
            html = renderDayPreviewHtml(day, currencySymbol);
        } else {
            heading.innerText = `Preview Full Itinerary - ${days.length} Days`;
            
            days.forEach(day => {
                html += renderDayPreviewHtml(day, currencySymbol);
            });
            
            let totalHotel = 0, totalVehicle = 0, totalActivity = 0, totalExtra = 0, totalDiscount = 0;
            days.forEach(day => {
                totalHotel += day.hotelCost;
                totalVehicle += day.vehicleCost;
                day.activities.forEach(act => totalActivity += act.cost);
                totalExtra += day.extraCharges;
                totalDiscount += day.discount;
            });
            
            const subtotal = totalHotel + totalVehicle + totalActivity + totalExtra - totalDiscount;
            const gst = Math.round(subtotal * 0.05);
            const grandTotal = subtotal + gst;

            html += `
                <div style="margin-top: 40px; border-top: 2px solid var(--primary); padding-top: 20px;">
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--primary); margin-bottom: 16px;">Itinerary Costing Summary</h3>
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                        <tr style="border-bottom: 1px solid #E2E8F0;">
                            <td style="padding: 10px 0; font-weight: 600;">Total Accommodation Cost</td>
                            <td style="text-align: right; font-weight: 700;">${currencySymbol}${formatNumber(totalHotel)}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #E2E8F0;">
                            <td style="padding: 10px 0; font-weight: 600;">Total Transport & Driver Cost</td>
                            <td style="text-align: right; font-weight: 700;">${currencySymbol}${formatNumber(totalVehicle)}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #E2E8F0;">
                            <td style="padding: 10px 0; font-weight: 600;">Total Activities Fee</td>
                            <td style="text-align: right; font-weight: 700;">${currencySymbol}${formatNumber(totalActivity)}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #E2E8F0;">
                            <td style="padding: 10px 0; font-weight: 600;">Other Special Charges</td>
                            <td style="text-align: right; font-weight: 700;">${currencySymbol}${formatNumber(totalExtra)}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #E2E8F0; color: #EF4444;">
                            <td style="padding: 10px 0; font-weight: 600;">Campaign Discount</td>
                            <td style="text-align: right; font-weight: 700;">-${currencySymbol}${formatNumber(totalDiscount)}</td>
                        </tr>
                        <tr style="border-bottom: 2px solid var(--primary); font-size: 1.05rem; font-weight: 800;">
                            <td style="padding: 12px 0;">Sub Total Amount</td>
                            <td style="text-align: right; color: var(--primary);">${currencySymbol}${formatNumber(subtotal)}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #E2E8F0; font-size: 0.9rem;">
                            <td style="padding: 8px 0; font-weight: 600;">GST (5%)</td>
                            <td style="text-align: right; font-weight: 700;">${currencySymbol}${formatNumber(gst)}</td>
                        </tr>
                        <tr style="font-size: 1.3rem; font-weight: 800; color: var(--primary);">
                            <td style="padding: 16px 0;">Grand Total Quote</td>
                            <td style="text-align: right;">${currencySymbol}${formatNumber(grandTotal)}</td>
                        </tr>
                    </table>
                </div>
            `;
        }

        printContent.innerHTML = html;
        document.getElementById("itinerary-preview-modal").style.display = "flex";
    }

    function closePreviewModal() {
        document.getElementById("itinerary-preview-modal").style.display = "none";
    }

    function renderDayPreviewHtml(day, currencySymbol) {
        let highlightsHtml = "";
        day.highlights.forEach(hl => {
            highlightsHtml += `<span class="print-highlight-tag"><i class="fa-solid fa-tag" style="font-size: 0.75rem; margin-right: 4px;"></i> ${hl}</span>`;
        });

        let activitiesHtml = "";
        if (day.activities && day.activities.length > 0) {
            activitiesHtml += `
                <div class="print-day-activities">
                    <h5>Scheduled Activities</h5>
                    <ul class="print-activities-list">
            `;
            day.activities.forEach(act => {
                activitiesHtml += `
                    <li class="print-activity-item">
                        <span>${act.name}</span>
                        <span style="font-weight: 700;">${currencySymbol}${formatNumber(act.cost)}</span>
                    </li>
                `;
            });
            activitiesHtml += `
                    </ul>
                </div>
            `;
        }

        let imageSrc = "https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=400&q=80";
        if (day.images.destination && day.images.destination.length > 0) {
            imageSrc = day.images.destination[0];
        }

        let mealsList = day.meals && day.meals.length > 0 ? day.meals.join(", ") : "None";

        return `
            <div class="print-day-block">
                <div class="print-day-header">
                    <span class="print-day-title">Day ${day.dayNumber}: ${day.dayTitle || 'Leisure Day'}</span>
                    <span class="print-day-meta"><i class="fa-regular fa-clock"></i> ${day.travelTime || '00:00'} Hrs travel time (${day.distance || 0} KM)</span>
                </div>
                <div class="print-day-content-grid">
                    <div>
                        <div class="print-day-desc">
                            <strong>Date:</strong> ${formatDateString(day.date)}<br>
                            <strong>Route:</strong> ${day.startPoint || 'Unknown'} &rarr; ${day.endPoint || 'Unknown'}<br><br>
                            ${day.description || 'No description provided.'}
                        </div>
                        
                        <div class="print-day-highlights" style="margin-top: 16px;">
                            <h5>Day Highlights</h5>
                            <div>${highlightsHtml || 'No highlights selected.'}</div>
                        </div>

                        ${activitiesHtml}
                        
                        <div style="margin-top: 12px; font-size: 0.85rem; border-top: 1px solid #E2E8F0; padding-top: 8px;">
                            <strong>Accommodation:</strong> ${day.hotelName || 'No Accommodation'} &nbsp;|&nbsp; 
                            <strong>Meals Provided:</strong> ${mealsList}
                        </div>
                        <div style="margin-top: 6px; font-size: 0.85rem;">
                            <strong>Transport Details:</strong> ${day.vehicle || 'Not Specified'} &nbsp;|&nbsp; 
                            <strong>Driver details:</strong> ${day.driverName || 'Not Assigned'} (${day.driverMobile || 'N/A'})
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <img src="${imageSrc}" style="width: 100%; border-radius: 8px; max-height: 120px; object-fit: cover; border: 1px solid #E2E8F0;" alt="Day Cover">
                        <div style="margin-top: 8px; font-size: 0.75rem; font-weight: 700; color: var(--text-secondary);">
                            Cover Image
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Auto-fill global pax count based on selected lead
    $(document).ready(function() {
        $('#input-lead-id').on('change', function() {
            var $option = $(this).find('option:selected');
            if ($option.val()) {
                $('#input-global-adults').val($option.data('adults') || 0);
                $('#input-global-children').val($option.data('children') || 0);
                $('#input-global-infants').val($option.data('infants') || 0);
                
                if (typeof saveDraftToLocalStorage === 'function') {
                    saveDraftToLocalStorage();
                }
            }
        });
    });
</script>
@endsection
