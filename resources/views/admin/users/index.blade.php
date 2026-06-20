@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-users"></i> Users Management</h3>
            <a href="{{ route('users.create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New User
            </a>
        </div>
    </div>
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="users-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td style="font-weight: 700;">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge" style="background: #043237; color: #fff; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: 500; display: inline-block; margin-bottom: 4px;">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if(!$user->hasRole('Administrator'))
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-table-action btn-delete" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-users" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No users found. Click "Add New User" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if ($('#users-table tbody tr.empty-row').length === 0) {
            $('#users-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3, 4] }
                ],
                "language": {
                    "searchPlaceholder": "Search users...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
