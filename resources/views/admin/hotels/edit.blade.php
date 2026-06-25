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
        }
        .image-preview-content {
            text-align: center;
            color: #6B7280;
        }
        .btn-delete-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 0.8rem;
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
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-pen-to-square"></i> Edit Hotel</h3>
            <a href="{{ route('hotels.index') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Hotels
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ route('hotels.update', $hotel->id) }}" method="POST" class="validate-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-section-grid" style="grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Column 1: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-hotel"></i> Basic Details</h4>
                    
                    <div class="form-group">
                        <label for="hotel_name">Hotel Name <span class="text-danger">*</span></label>
                        <input type="text" name="hotel_name" id="hotel_name" class="modern-input" placeholder="Enter hotel name" value="{{ old('hotel_name', $hotel->hotel_name) }}" required>
                        @error('hotel_name')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div style="display: flex; gap: 16px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="destination_id">Destination <span class="text-danger">*</span></label>
                            <select name="destination_id" id="destination_id" class="modern-input select2-init" required>
                                <option value="">Select Destination</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}" {{ old('destination_id', $hotel->destination_id) == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                                @endforeach
                            </select>
                            @error('destination_id')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="category">Category <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="modern-input select2-init" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category', $hotel->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="star_rating">Star Rating (1-5)</label>
                        <input type="number" name="star_rating" id="star_rating" class="modern-input" placeholder="e.g. 5" min="1" max="5" value="{{ old('star_rating', $hotel->star_rating) }}">
                        @error('star_rating')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="modern-input" rows="5" placeholder="Hotel description...">{{ old('description', $hotel->description) }}</textarea>
                        @error('description')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Column 2: Media & Contact Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-address-book"></i> Media & Contact</h4>
                    
                    <div class="form-group">
                        <label>Featured Image</label>
                        <div class="image-preview-container" id="image-preview-btn">
                            @if($hotel->image)
                                <img id="image-preview-img" src="{{ asset($hotel->image) }}" alt="Preview" style="display: block;">
                                <button type="button" class="btn-delete-image" id="delete-image-btn" data-id="{{ $hotel->id }}">
                                    <i class="fa-solid fa-trash"></i> Remove
                                </button>
                                <div class="image-preview-content" id="image-preview-content" style="display: none;">
                                    <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2rem; margin-bottom: 8px;"></i>
                                    <p>Click to browse new image</p>
                                </div>
                            @else
                                <img id="image-preview-img" src="#" alt="Preview" style="display: none;">
                                <div class="image-preview-content" id="image-preview-content">
                                    <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2rem; margin-bottom: 8px;"></i>
                                    <p>Click to browse image</p>
                                </div>
                            @endif
                            <input type="file" name="image" id="image" style="display: none;" accept="image/*">
                        </div>
                        @error('image')<span class="text-danger" style="font-size: 0.85rem; margin-top:4px; display:block;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person" class="modern-input" placeholder="Manager or Receptionist Name" value="{{ old('contact_person', $hotel->contact_person) }}">
                        @error('contact_person')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="modern-input" placeholder="e.g. +1 234 567 8900" value="{{ old('phone', $hotel->phone) }}">
                        @error('phone')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="modern-input" rows="2" placeholder="Full address...">{{ old('address', $hotel->address) }}</textarea>
                        @error('address')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Update Hotel
                </button>
            </div>
        </form>

        <!-- Room Rates Management Section -->
        <div class="room-rates-section">
            <h4 class="form-section-title"><i class="fa-solid fa-bed"></i> Room Rates Management</h4>
            
            <!-- Existing Rates Table -->
            @if($hotel->roomRates->count() > 0)
                <table class="rates-table">
                    <thead>
                        <tr>
                            <th>Room Type</th>
                            <th>Meal Plan</th>
                            <th>Season</th>
                            <th>Cost Price</th>
                            <th>Selling Price</th>
                            <th style="width: 80px; text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotel->roomRates as $rate)
                            <tr>
                                <td><strong>{{ $rate->room_type }}</strong></td>
                                <td>{{ $rate->meal_plan ?? 'N/A' }}</td>
                                <td>{{ $rate->season ?? 'N/A' }}</td>
                                <td>${{ number_format($rate->cost_price, 2) }}</td>
                                <td>${{ number_format($rate->selling_price, 2) }}</td>
                                <td style="text-align:center;">
                                    <form action="{{ route('hotels.rates.destroy', [$hotel->id, $rate->id]) }}" method="POST" class="delete-confirm-form" data-message="Delete this room rate?" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-table-action btn-delete" title="Delete" style="border:none; background:none; cursor:pointer; color:#EF4444;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: #6B7280; font-style: italic; margin-top: 16px;">No room rates have been added to this hotel yet.</p>
            @endif

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 24px 0;">

            <!-- Add New Rate Form -->
            <h5>Add New Room Rate</h5>
            <form action="{{ route('hotels.rates.store', $hotel->id) }}" method="POST" style="margin-top: 16px;">
                @csrf
                <div style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
                    <div class="form-group" style="flex: 1; min-width: 150px; margin-bottom: 0;">
                        <label for="room_type">Room Type *</label>
                        <input type="text" name="room_type" id="room_type" class="modern-input" placeholder="e.g. Deluxe Double" required>
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 150px; margin-bottom: 0;">
                        <label for="meal_plan">Meal Plan</label>
                        <input type="text" name="meal_plan" id="meal_plan" class="modern-input" placeholder="e.g. Bed & Breakfast">
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 150px; margin-bottom: 0;">
                        <label for="season">Season</label>
                        <input type="text" name="season" id="season" class="modern-input" placeholder="e.g. High Season">
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 120px; margin-bottom: 0;">
                        <label for="cost_price">Cost Price *</label>
                        <input type="number" name="cost_price" id="cost_price" class="modern-input" placeholder="0.00" step="0.01" required>
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 120px; margin-bottom: 0;">
                        <label for="selling_price">Selling Price *</label>
                        <input type="number" name="selling_price" id="selling_price" class="modern-input" placeholder="0.00" step="0.01" required>
                    </div>
                    <div>
                        <button type="submit" class="modern-btn" style="background: #10B981;">
                            <i class="fa-solid fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('image-preview-btn').addEventListener('click', function(e) {
        if(e.target.id !== 'delete-image-btn' && e.target.parentElement.id !== 'delete-image-btn') {
            document.getElementById('image').click();
        }
    });

    document.getElementById('image').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview-img').src = e.target.result;
                document.getElementById('image-preview-img').style.display = 'block';
                document.getElementById('image-preview-content').style.display = 'none';
                let deleteBtn = document.getElementById('delete-image-btn');
                if(deleteBtn) deleteBtn.style.display = 'none';
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    let deleteBtn = document.getElementById('delete-image-btn');
    if(deleteBtn) {
        deleteBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if(confirm('Are you sure you want to remove the current image?')) {
                let hotelId = this.getAttribute('data-id');
                fetch(`/admin/hotels/image/${hotelId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById('image-preview-img').style.display = 'none';
                        document.getElementById('image-preview-img').src = '#';
                        document.getElementById('image-preview-content').style.display = 'block';
                        deleteBtn.style.display = 'none';
                    } else {
                        alert('Failed to delete image.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            }
        });
    }
</script>
@endsection
