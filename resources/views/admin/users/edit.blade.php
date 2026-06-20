@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }
        .role-item {
            background: #f8fafc;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .role-item label {
            margin: 0;
            font-size: 0.95rem;
            color: #334155;
            text-transform: capitalize;
        }
        /* Toggle Switch */
        .switch {
          position: relative;
          display: inline-block;
          width: 40px;
          height: 24px;
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
        }
        input:checked + .slider {
          background-color: #043237;
        }
        input:checked + .slider:before {
          -webkit-transform: translateX(16px);
          -ms-transform: translateX(16px);
          transform: translateX(16px);
        }
        .slider.round {
          border-radius: 24px;
        }
        .slider.round:before {
          border-radius: 50%;
        }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-pen"></i> Edit User: {{ $user->name }}</h3>
            <a href="{{ route('users.index') }}" class="btn-add-new">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Users
            </a>
        </div>
    </div>
    <div class="page-panel-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="validate-form">
            @csrf
            @method('PUT')
            
            <div class="form-input-grid">
                <div class="form-group">
                    <label>Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="modern-input" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="modern-input" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <div class="form-input-grid">
                <div class="form-group">
                    <label>Password (Leave blank to keep current)</label>
                    <input type="password" name="password" class="modern-input" placeholder="e.g. Secret123" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$" title="Password must be at least 8 characters long and contain both letters and numbers">
                    <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> Minimum 8 characters, containing both letters and numbers.</p>
                    @error('password')
                        <span class="text-danger" style="font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="modern-input" placeholder="Confirm Password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$">
                </div>
            </div>
            
            <div class="form-group" style="margin-top: 32px;">
                <label>Assign Roles <span class="text-danger">*</span></label>
                <div class="roles-grid">
                    @foreach($roles as $role)
                        <div class="role-item">
                            <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                            <label class="switch">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ in_array($role->name, $userRoles) ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F3F4F6; margin: 32px 0;">
            
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('users.index') }}" class="modern-btn" style="background: #E5E7EB; color: var(--text-primary);">
                    Cancel
                </a>
                <button type="submit" class="modern-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
