@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-plus"></i> Add New FAQ</h3>
            <a href="{{ url('/admin/faqs') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to FAQs
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/faqs') }}" method="POST" class="validate-form">
            @csrf
            
            <div class="form-section-grid" style="grid-template-columns: 1fr;">
                <div>
                    <h4 class="form-section-title"><i class="fa-solid fa-circle-info"></i> FAQ Details</h4>
                    
                    <div class="form-group">
                        <label for="question">Question <span class="text-danger">*</span></label>
                        <input type="text" name="question" id="question" class="modern-input" placeholder="Enter question" value="{{ old('question') }}" required>
                        @error('question')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="answer">Answer <span class="text-danger">*</span></label>
                        <textarea name="answer" id="answer" class="modern-input ckeditor-init" rows="5" required>{{ old('answer') }}</textarea>
                        @error('answer')
                            <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ url('/admin/faqs') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save FAQ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
