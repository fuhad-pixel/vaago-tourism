@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-pen-to-square"></i> Edit Inclusion</h3>
            <a href="{{ url('/admin/additional-inclusions') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Inclusions
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/additional-inclusions/' . $inclusion->id) }}" method="POST" class="validate-form">
            @csrf
            @method('PUT')
            
            <div class="form-section-grid">
                <!-- Left Side: Form Fields -->
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> Inclusion Details</h4>
                    
                    <div class="form-group">
                        <label for="name">Inclusion Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="modern-input" placeholder="e.g. Free Wi-Fi" value="{{ old('name', $inclusion->name) }}" required>
                        @error('name')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="icon">Icon Class (FontAwesome) <span class="text-danger">*</span></label>
                        <input type="text" name="icon" id="icon" class="modern-input" placeholder="e.g. fa-solid fa-wifi" value="{{ old('icon', $inclusion->icon) }}" required>
                        @error('icon')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;">
                            <i class="fa-solid fa-circle-info"></i> Use FontAwesome class names. Examples: <code>fa-solid fa-wifi</code>, <code>fa-solid fa-mug-hot</code>, <code>fa-solid fa-utensils</code>, <code>fa-solid fa-plane-arrival</code>.
                        </p>
                    </div>
                </div>

                <!-- Right Side: Preview -->
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; border-left: 1px solid #F3F4F6; padding: 20px;">
                    <h4 class="form-section-title" style="align-self: flex-start; margin-bottom: 20px;"><i class="fa-solid fa-eye"></i> Icon Preview</h4>
                    <div id="icon-preview-box" style="display: flex; justify-content: center; align-items: center; width: 120px; height: 120px; background: #FFF8F5; border: 2px dashed rgba(241, 93, 48, 0.2); border-radius: 20px; color: #f15d30; font-size: 3.5rem; transition: all 0.3s ease;">
                        <i class="{{ $inclusion->icon }}" id="icon-preview-el"></i>
                    </div>
                    <p style="margin-top: 15px; font-weight: 600; color: var(--text-secondary);" id="icon-preview-name">{{ $inclusion->icon }}</p>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ url('/admin/additional-inclusions') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Update Inclusion
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const iconInput = $('#icon');
        const previewEl = $('#icon-preview-el');
        const previewName = $('#icon-preview-name');
        
        function updatePreview() {
            const iconVal = iconInput.val().trim();
            if (iconVal) {
                previewEl.attr('class', iconVal);
                previewName.text(iconVal);
            } else {
                previewEl.attr('class', 'fa-solid fa-circle-question');
                previewName.text('Preview');
            }
        }
        
        iconInput.on('input', updatePreview);
        
        // Run on load to set original icon
        updatePreview();
    });
</script>
@endsection
