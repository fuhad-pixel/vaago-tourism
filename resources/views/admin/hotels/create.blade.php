@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        .image-preview-container {
            width: 100%;
            height: 200px;
            border: 2px dashed #E5E7EB;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #F9FAFB;
            cursor: pointer;
            position: relative;
        }
        .image-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        .image-preview-content {
            text-align: center;
            color: #6B7280;
        }

        /* Room Rates Section Styling */
        .room-rates-section {
            margin-top: 40px;
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 24px;
        }
        .rates-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        .rates-table th, .rates-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #F3F4F6;
        }
        .rates-table th {
            font-weight: 600;
            color: #4B5563;
            background: #F9FAFB;
        }
        .btn-remove-rate {
            color: #EF4444;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }
        .btn-remove-rate:hover {
            color: #B91C1C;
        }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-plus"></i> Add New Hotel</h3>
            <a href="{{ route('hotels.index') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Hotels
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ route('hotels.store') }}" method="POST" class="validate-form" enctype="multipart/form-data">
            @csrf
            
            <div class="form-section-grid" style="grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Column 1: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-hotel"></i> Basic Details</h4>
                    
                    <div class="form-group">
                        <label for="hotel_name">Hotel Name <span class="text-danger">*</span></label>
                        <input type="text" name="hotel_name" id="hotel_name" class="modern-input" placeholder="Enter hotel name" value="{{ old('hotel_name') }}" required>
                        @error('hotel_name')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div style="display: flex; gap: 16px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="destination_id">Destination <span class="text-danger">*</span></label>
                            <select name="destination_id" id="destination_id" class="modern-input select2-init" required>
                                <option value="">Select Destination</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                                @endforeach
                            </select>
                            @error('destination_id')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="category">Category <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="modern-input select2-init" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="star_rating">Star Rating (1-5)</label>
                        <input type="number" name="star_rating" id="star_rating" class="modern-input" placeholder="e.g. 5" min="1" max="5" value="{{ old('star_rating') }}">
                        @error('star_rating')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="modern-input" rows="5" placeholder="Hotel description...">{{ old('description') }}</textarea>
                        @error('description')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Column 2: Media & Contact Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-address-book"></i> Media & Contact</h4>
                    
                    <div class="form-group">
                        <label>Featured Image</label>
                        <div class="image-preview-container" id="image-preview-btn">
                            <div class="image-preview-content" id="image-preview-content">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2rem; margin-bottom: 8px;"></i>
                                <p>Click to browse image</p>
                            </div>
                            <img id="image-preview-img" src="#" alt="Preview">
                            <input type="file" name="image" id="image" style="display: none;" accept="image/*">
                        </div>
                        @error('image')<span class="text-danger" style="font-size: 0.85rem; margin-top:4px; display:block;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person" class="modern-input" placeholder="Manager or Receptionist Name" value="{{ old('contact_person') }}">
                        @error('contact_person')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="modern-input" placeholder="e.g. +1 234 567 8900" value="{{ old('phone') }}">
                        @error('phone')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="modern-input" rows="2" placeholder="Full address...">{{ old('address') }}</textarea>
                        @error('address')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <!-- Room Rates Management Section -->
            <div class="room-rates-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h4 class="form-section-title" style="margin: 0;"><i class="fa-solid fa-bed"></i> Room Rates Configuration</h4>
                    <button type="button" class="modern-btn" id="add-room-rate-btn" style="background: #10B981; padding: 8px 16px; font-size: 0.9rem;">
                        <i class="fa-solid fa-plus"></i> Add Room Rate
                    </button>
                </div>
                
                <table class="rates-table" id="room-rates-table">
                    <thead>
                        <tr>
                            <th>Room Type <span class="text-danger">*</span></th>
                            <th>Meal Plan</th>
                            <th>Season</th>
                            <th>Cost Price <span class="text-danger">*</span></th>
                            <th>Selling Price <span class="text-danger">*</span></th>
                            <th style="width: 60px; text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="room-rates-body">
                        <!-- Dynamic rows will go here -->
                        @if(old('room_rates'))
                            @foreach(old('room_rates') as $index => $rate)
                                <tr>
                                    <td>
                                        <input type="text" name="room_rates[{{ $index }}][room_type]" class="modern-input" placeholder="e.g. Deluxe Double" value="{{ $rate['room_type'] }}" required style="margin-bottom: 0; padding: 8px;">
                                    </td>
                                    <td>
                                        <input type="text" name="room_rates[{{ $index }}][meal_plan]" class="modern-input" placeholder="e.g. Bed & Breakfast" value="{{ $rate['meal_plan'] ?? '' }}" style="margin-bottom: 0; padding: 8px;">
                                    </td>
                                    <td>
                                        <input type="text" name="room_rates[{{ $index }}][season]" class="modern-input" placeholder="e.g. High Season" value="{{ $rate['season'] ?? '' }}" style="margin-bottom: 0; padding: 8px;">
                                    </td>
                                    <td>
                                        <input type="number" name="room_rates[{{ $index }}][cost_price]" class="modern-input" placeholder="0.00" step="0.01" value="{{ $rate['cost_price'] }}" required style="margin-bottom: 0; padding: 8px;">
                                    </td>
                                    <td>
                                        <input type="number" name="room_rates[{{ $index }}][selling_price]" class="modern-input" placeholder="0.00" step="0.01" value="{{ $rate['selling_price'] }}" required style="margin-bottom: 0; padding: 8px;">
                                    </td>
                                    <td style="text-align:center;">
                                        <button type="button" class="btn-remove-rate" title="Remove"><i class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <p id="no-rates-msg" style="color: #6B7280; font-style: italic; margin-top: 16px; {{ old('room_rates') ? 'display: none;' : '' }}">Click "Add Room Rate" to add room configurations.</p>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('hotels.index') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Hotel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('image-preview-btn').addEventListener('click', function() {
        document.getElementById('image').click();
    });

    document.getElementById('image').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview-img').src = e.target.result;
                document.getElementById('image-preview-img').style.display = 'block';
                document.getElementById('image-preview-content').style.display = 'none';
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Room Rates Dynamic Addition
    let rateIndex = {{ old('room_rates') ? count(old('room_rates')) : 0 }};
    const addRateBtn = document.getElementById('add-room-rate-btn');
    const ratesBody = document.getElementById('room-rates-body');
    const noRatesMsg = document.getElementById('no-rates-msg');

    addRateBtn.addEventListener('click', function() {
        noRatesMsg.style.display = 'none';
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" name="room_rates[${rateIndex}][room_type]" class="modern-input" placeholder="e.g. Deluxe Double" required style="margin-bottom: 0; padding: 8px;">
            </td>
            <td>
                <input type="text" name="room_rates[${rateIndex}][meal_plan]" class="modern-input" placeholder="e.g. Bed & Breakfast" style="margin-bottom: 0; padding: 8px;">
            </td>
            <td>
                <input type="text" name="room_rates[${rateIndex}][season]" class="modern-input" placeholder="e.g. High Season" style="margin-bottom: 0; padding: 8px;">
            </td>
            <td>
                <input type="number" name="room_rates[${rateIndex}][cost_price]" class="modern-input" placeholder="0.00" step="0.01" required style="margin-bottom: 0; padding: 8px;">
            </td>
            <td>
                <input type="number" name="room_rates[${rateIndex}][selling_price]" class="modern-input" placeholder="0.00" step="0.01" required style="margin-bottom: 0; padding: 8px;">
            </td>
            <td style="text-align:center;">
                <button type="button" class="btn-remove-rate" title="Remove"><i class="fa-solid fa-trash-can"></i></button>
            </td>
        `;
        
        ratesBody.appendChild(tr);
        rateIndex++;
    });

    ratesBody.addEventListener('click', function(e) {
        if(e.target.classList.contains('btn-remove-rate') || e.target.parentElement.classList.contains('btn-remove-rate')) {
            const tr = e.target.closest('tr');
            if(tr) {
                tr.remove();
                if(ratesBody.children.length === 0) {
                    noRatesMsg.style.display = 'block';
                }
            }
        }
    });
</script>
@endsection
