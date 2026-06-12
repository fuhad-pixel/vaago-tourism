@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        .policy-tabs-container {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid #F3F4F6;
        }
        .policy-tabs-header {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid #F3F4F6;
            margin-bottom: 24px;
        }
        .policy-tab-btn {
            background: transparent;
            border: none;
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
            outline: none !important;
        }
        .policy-tab-btn:hover {
            color: #f15d30;
        }
        .policy-tab-btn.active {
            color: #f15d30;
            border-bottom-color: #f15d30;
        }
        .policy-tab-pane {
            display: none;
        }
        .policy-tab-pane.active {
            display: block;
        }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <h3><i class="fa-solid fa-shield-halved"></i> Policies Settings</h3>
    </div>
    
    <div class="page-panel-body">
        <form action="{{ url('/admin/settings/policies') }}" method="POST" class="validate-form">
            @csrf
            
            <div class="policy-tabs-container">
                <div class="policy-tabs-header">
                    <button type="button" class="policy-tab-btn active" onclick="switchTab(event, 'privacy-tab')">
                        <i class="fa-solid fa-user-shield"></i> Privacy Policy
                    </button>
                    <button type="button" class="policy-tab-btn" onclick="switchTab(event, 'return-tab')">
                        <i class="fa-solid fa-rotate-left"></i> Return Policy
                    </button>
                </div>
                
                <div id="privacy-tab" class="policy-tab-pane active">
                    <div class="form-group">
                        <label for="privacy_policy" style="font-weight: 600; color: #374151; margin-bottom: 8px; display: block;">Privacy Policy Content</label>
                        <textarea name="privacy_policy" id="privacy_policy" class="ckeditor-init">{{ old('privacy_policy', $setting->privacy_policy) }}</textarea>
                    </div>
                </div>
                
                <div id="return-tab" class="policy-tab-pane">
                    <div class="form-group">
                        <label for="return_policy" style="font-weight: 600; color: #374151; margin-bottom: 8px; display: block;">Return Policy Content</label>
                        <textarea name="return_policy" id="return_policy" class="ckeditor-init">{{ old('return_policy', $setting->return_policy) }}</textarea>
                    </div>
                </div>
            </div>
            
            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">
            
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save Policies
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function switchTab(event, tabId) {
            document.querySelectorAll('.policy-tab-pane').forEach(pane => {
                pane.classList.remove('active');
            });
            document.querySelectorAll('.policy-tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
@endsection
