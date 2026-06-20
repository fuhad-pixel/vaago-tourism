@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        :root {
            --theme-color: #043237;
        }
        
        .role-create-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .role-header-banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 40px;
            background: linear-gradient(to right, #ffffff, rgba(4, 50, 55, 0.03));
            border-bottom: 1px solid #f1f5f9;
            position: relative;
            overflow: hidden;
        }

        .role-header-left {
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 2;
        }

        .role-header-icon {
            width: 60px;
            height: 60px;
            background: rgba(4, 50, 55, 0.08);
            border-radius: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.8rem;
            color: var(--theme-color);
        }

        .role-header-text h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .role-header-text p {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
        }

        .role-header-graphic {
            position: absolute;
            right: 0;
            bottom: 0;
            height: 100%;
            z-index: 1;
            opacity: 0.8;
            pointer-events: none;
        }

        .role-form-body {
            padding: 40px;
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title-left h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .section-title-left p {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
        }

        .btn-select-all {
            background: rgba(4, 50, 55, 0.05);
            color: var(--theme-color);
            border: 1px solid rgba(4, 50, 55, 0.1);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-select-all:hover {
            background: rgba(4, 50, 55, 0.1);
        }

        .input-icon-wrapper {
            position: relative;
            margin-bottom: 40px;
        }

        .input-icon-wrapper i {
            position: absolute;
            left: 16px;
            top: 23px;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
        }

        .input-icon-wrapper input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            color: #1e293b;
            transition: all 0.2s;
            box-sizing: border-box;
            display: block;
        }

        .input-icon-wrapper input:focus {
            outline: none;
            border-color: #043237;
            box-shadow: 0 0 0 3px rgba(4, 50, 55, 0.1);
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .permission-card {
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            transition: all 0.2s;
        }

        .permission-card:hover {
            border-color: #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .perm-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .perm-icon {
            width: 44px;
            height: 44px;
            background: rgba(4, 50, 55, 0.06);
            color: var(--theme-color);
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .perm-text h5 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
            margin-top: 0;
        }

        .perm-text p {
            font-size: 0.8rem;
            color: #64748b;
            margin: 0;
            line-height: 1.4;
        }

        /* Toggle Switch */
        .switch {
          position: relative;
          display: inline-block;
          width: 44px;
          height: 24px;
          flex-shrink: 0;
        }
        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #cbd5e1;
          -webkit-transition: .4s;
          transition: .4s;
          border-radius: 24px;
        }
        .slider:before {
          position: absolute;
          content: "";
          height: 18px;
          width: 18px;
          left: 3px;
          bottom: 3px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
          border-radius: 50%;
        }
        input:checked + .slider {
          background-color: var(--theme-color);
        }
        input:checked + .slider:before {
          -webkit-transform: translateX(20px);
          -ms-transform: translateX(20px);
          transform: translateX(20px);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #f1f5f9;
        }

        .btn-cancel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: #f8fafc;
            color: #1e293b;
        }

        .btn-save {
            background: var(--theme-color);
            border: 1px solid var(--theme-color);
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-save:hover {
            opacity: 0.9;
        }
        
        .role-label {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
        }
    </style>
@endsection

@php
$permissionDetails = [
    'dashboard' => ['icon' => 'fa-gauge', 'title' => 'Manage Dashboard', 'desc' => 'View and manage dashboard data'],
    'tours' => ['icon' => 'fa-suitcase-rolling', 'title' => 'Manage Tours', 'desc' => 'Create, update and manage tours'],
    'destinations' => ['icon' => 'fa-location-dot', 'title' => 'Manage Destinations', 'desc' => 'Manage destinations and locations'],
    'blogs' => ['icon' => 'fa-file-lines', 'title' => 'Manage Blogs', 'desc' => 'Create and manage blog posts'],
    'category' => ['icon' => 'fa-folder', 'title' => 'Manage Categories', 'desc' => 'Organize blog categories'],
    'categories' => ['icon' => 'fa-folder', 'title' => 'Manage Categories', 'desc' => 'Organize blog categories'],
    'enquiry' => ['icon' => 'fa-comment-dots', 'title' => 'Manage Enquiries', 'desc' => 'View and respond to enquiries'],
    'enquiries' => ['icon' => 'fa-comment-dots', 'title' => 'Manage Enquiries', 'desc' => 'View and respond to enquiries'],
    'travel-guide' => ['icon' => 'fa-map', 'title' => 'Manage Travel Guides', 'desc' => 'Manage travel guides and tips'],
    'inclusion' => ['icon' => 'fa-clipboard-list', 'title' => 'Manage Inclusions', 'desc' => 'Manage tour inclusions'],
    'faq' => ['icon' => 'fa-circle-question', 'title' => 'Manage FAQs', 'desc' => 'Manage frequently asked questions'],
    'setting' => ['icon' => 'fa-gear', 'title' => 'Manage Settings', 'desc' => 'Configure system settings'],
    'role' => ['icon' => 'fa-shield-halved', 'title' => 'Manage Roles', 'desc' => 'Create and manage user roles'],
    'user' => ['icon' => 'fa-users', 'title' => 'Manage Users', 'desc' => 'Manage system users'],
];

function getPermDetails($name, $details) {
    foreach ($details as $key => $data) {
        if (str_contains(strtolower($name), $key)) {
            return $data;
        }
    }
    return [
        'icon' => 'fa-cube',
        'title' => ucwords(str_replace(['_', '-'], ' ', $name)),
        'desc' => 'Manage ' . str_replace(['_', '-'], ' ', $name) . ' permissions'
    ];
}
@endphp

@section('content')
<div class="admin-page-panel">
    
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-plus"></i> Add New Role</h3>
            <a href="{{ route('roles.index') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Roles
            </a>
        </div>
    </div>

    <div class="page-panel-body" style="padding: 0;">
        <div class="role-create-container" style="box-shadow: none; border-radius: 0; margin-bottom: 0;">
        <!-- Header Banner -->
        <div class="role-header-banner">
            <div class="role-header-left">
                <div class="role-header-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="role-header-text">
                    <h2>Create New Role</h2>
                    <p>Define role name and assign permissions to control access</p>
                </div>
            </div>
            <!-- Mountain SVG background graphic -->
            <svg class="role-header-graphic" viewBox="0 0 500 150" preserveAspectRatio="none">
                <path d="M0,150 L100,50 L150,100 L250,20 L300,70 L400,10 L500,80 L500,150 Z" fill="var(--theme-color)" opacity="0.05"></path>
                <path d="M50,150 L150,70 L200,120 L300,40 L350,90 L450,30 L500,100 L500,150 Z" fill="var(--theme-color)" opacity="0.1"></path>
                <path d="M420,150 L420,110 L425,110 L425,150 Z M435,150 L435,120 L440,120 L440,150 Z M460,150 L460,90 L465,90 L465,150 Z M480,150 L480,130 L485,130 L485,150 Z" fill="var(--theme-color)" opacity="0.2"></path>
                <path d="M410,110 L422,80 L435,110 Z M425,120 L437,90 L450,120 Z M450,90 L462,50 L475,90 Z M470,130 L482,100 L495,130 Z" fill="var(--theme-color)" opacity="0.2"></path>
            </svg>
        </div>

        <div class="role-form-body">
            <form action="{{ route('roles.store') }}" method="POST" class="validate-form">
                @csrf
                
                <label class="role-label">Role Name <span class="text-danger">*</span></label>
                <div class="input-icon-wrapper">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Editor" required>
                    @error('name')
                        <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="section-title">
                    <div class="section-title-left">
                        <h4>Assign Permissions <span class="text-danger">*</span></h4>
                        <p>Enable the permissions you want to assign to this role.</p>
                    </div>
                    <button type="button" class="btn-select-all" id="selectAllBtn">
                        <i class="fa-regular fa-circle-check"></i> Select All
                    </button>
                </div>
                
                <div class="permissions-grid">
                    @foreach($permissions as $permission)
                        @php $details = getPermDetails($permission->name, $permissionDetails); @endphp
                        <div class="permission-card">
                            <div class="perm-info">
                                <div class="perm-icon">
                                    <i class="fa-solid {{ $details['icon'] }}"></i>
                                </div>
                                <div class="perm-text">
                                    <h5>{{ $details['title'] }}</h5>
                                    <p>{{ $details['desc'] }}</p>
                                </div>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="perm-checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
                
                @error('permissions')
                    <span class="text-danger" style="font-size: 0.85rem; margin-top: 8px; display: block;">{{ $message }}</span>
                @enderror

                <div class="form-actions">
                    <a href="{{ route('roles.index') }}" class="btn-cancel">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i> Save Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllBtn = document.getElementById('selectAllBtn');
        const checkboxes = document.querySelectorAll('.perm-checkbox');
        
        selectAllBtn.addEventListener('click', function() {
            let allChecked = true;
            checkboxes.forEach(cb => {
                if(!cb.checked) allChecked = false;
            });
            
            checkboxes.forEach(cb => {
                cb.checked = !allChecked;
            });
            
            if(allChecked) {
                selectAllBtn.innerHTML = '<i class="fa-regular fa-circle-check"></i> Select All';
            } else {
                selectAllBtn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Deselect All';
            }
        });
    });
</script>
@endsection
