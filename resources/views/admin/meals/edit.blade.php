@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-pen-to-square"></i> Edit Meal</h3>
            <a href="{{ url('/admin/meals') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Meals
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/meals/' . $meal->id) }}" method="POST" class="validate-form">
            @csrf
            @method('PUT')
            
            <div class="form-section-grid" style="grid-template-columns: 1fr;">
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Meal Details</h4>
                    
                    <div class="form-group">
                        <label for="meal">Meal Name <span class="text-danger">*</span></label>
                        <input type="text" name="meal" id="meal" class="modern-input" placeholder="Enter meal name" value="{{ old('meal', $meal->meal) }}" required>
                        @error('meal')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="modern-input" rows="4" placeholder="Enter meal description">{{ old('description', $meal->description) }}</textarea>
                        @error('description')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-start; gap: 12px;">
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Update Meal
                </button>
                <a href="{{ url('/admin/meals') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
