@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-user-plus"></i> Add New Lead</h3>
            <a href="{{ route('leads.index') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Leads
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ route('leads.store') }}" method="POST" class="validate-form">
            @csrf
            
            <div class="form-section-grid" style="grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Column 1: Basic Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-address-card"></i> Lead Information</h4>
                    
                    <div class="form-group">
                        <label for="name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="modern-input" placeholder="Enter full name" value="{{ old('name') }}" required>
                        @error('name')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="modern-input" placeholder="Enter email address" value="{{ old('email') }}" required>
                        @error('email')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="modern-input" placeholder="Enter phone number" value="{{ old('phone') }}">
                        @error('phone')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" name="country" id="country" class="modern-input" placeholder="Enter country" value="{{ old('country') }}">
                        @error('country')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>
                    
                    <div style="display: flex; gap: 16px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="adults">Adults</label>
                            <input type="number" name="adults" id="adults" class="modern-input" placeholder="0" min="0" value="{{ old('adults') }}">
                            @error('adults')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="children">Children</label>
                            <input type="number" name="children" id="children" class="modern-input" placeholder="0" min="0" value="{{ old('children') }}">
                            @error('children')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="infants">Infants</label>
                            <input type="number" name="infants" id="infants" class="modern-input" placeholder="0" min="0" value="{{ old('infants') }}">
                            @error('infants')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <!-- Column 2: Trip & CRM Info -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-plane-departure"></i> Trip & CRM Details</h4>
                    
                    <div style="display: flex; gap: 16px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="arrival_date">Arrival Date</label>
                            <input type="date" name="arrival_date" id="arrival_date" class="modern-input" value="{{ old('arrival_date') }}">
                            @error('arrival_date')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="departure_date">Departure Date</label>
                            <input type="date" name="departure_date" id="departure_date" class="modern-input" value="{{ old('departure_date') }}">
                            @error('departure_date')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="display: flex; gap: 16px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="source">Source</label>
                            <input type="text" name="source" id="source" class="modern-input" placeholder="e.g. Website, Walk-in, Referral" value="{{ old('source') }}">
                            @error('source')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="budget">Budget</label>
                            <input type="number" name="budget" id="budget" class="modern-input" placeholder="e.g. 5000" step="0.01" min="0" value="{{ old('budget') }}">
                            @error('budget')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Lead Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="modern-input select2-init" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="assigned_to">Assign To</label>
                        <select name="assigned_to" id="assigned_to" class="modern-input select2-init">
                            <option value="">-- Unassigned --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('assigned_to')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <!-- Full Width Notes -->
            <div class="form-section-grid" style="grid-template-columns: 1fr; margin-top: 16px;">
                <div>
                    <div class="form-group">
                        <label for="notes">Notes / Special Requirements</label>
                        <textarea name="notes" id="notes" class="modern-input" rows="4" placeholder="Enter any additional notes here...">{{ old('notes') }}</textarea>
                        @error('notes')<span class="text-danger" style="font-size: 0.85rem;">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('leads.index') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Lead
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
