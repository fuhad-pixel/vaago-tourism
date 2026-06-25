@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-plus"></i> Add New Activity</h3>
            <a href="{{ route('activities.index') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Activities
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ route('activities.store') }}" method="POST" class="validate-form">
            @csrf
            
            <div class="form-section-grid" style="grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Column 1: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Basic Details</h4>
                    
                    <div class="form-group">
                        <label for="name">Activity Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="modern-input" placeholder="e.g. Scuba Diving" value="{{ old('name') }}" required>
                        @error('name')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="destination_id">Destination <span class="text-danger">*</span></label>
                        <select name="destination_id" id="destination_id" class="modern-input select2-init" required>
                            <option value="">Select Destination</option>
                            @foreach($destinations as $destination)
                                <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                            @endforeach
                        </select>
                        @error('destination_id')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Column 2: Pricing -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-dollar-sign"></i> Pricing Details</h4>
                    
                    <div class="form-group">
                        <label for="cost_adult">Adult Cost <span class="text-danger">*</span></label>
                        <input type="number" name="cost_adult" id="cost_adult" class="modern-input" placeholder="0.00" step="0.01" min="0" value="{{ old('cost_adult') }}" required>
                        @error('cost_adult')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div style="display: flex; gap: 16px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="cost_child">Child Cost</label>
                            <input type="number" name="cost_child" id="cost_child" class="modern-input" placeholder="0.00" step="0.01" min="0" value="{{ old('cost_child') }}">
                            <small style="color: #9CA3AF; font-size: 0.75rem;">Leave empty if free or N/A</small>
                            @error('cost_child')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="cost_infant">Infant Cost</label>
                            <input type="number" name="cost_infant" id="cost_infant" class="modern-input" placeholder="0.00" step="0.01" min="0" value="{{ old('cost_infant') }}">
                            <small style="color: #9CA3AF; font-size: 0.75rem;">Leave empty if free or N/A</small>
                            @error('cost_infant')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('activities.index') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Activity
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
