@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-user-shield"></i> Roles Management</h3>
            <a href="{{ route('roles.create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Role
            </a>
        </div>
    </div>
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="roles-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>#{{ $role->id }}</td>
                            <td style="font-weight: 700;">{{ $role->name }}</td>
                            <td>
                                @foreach($role->permissions as $permission)
                                    <span class="badge" style="background: #e2e8f0; color: #475569; margin-bottom: 4px; display: inline-block;">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if($role->name !== 'Administrator')
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this role?');">
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
                            <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-user-shield" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No roles found. Click "Add New Role" to create one.
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
        if ($('#roles-table tbody tr.empty-row').length === 0) {
            $('#roles-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [2, 3] }
                ],
                "language": {
                    "searchPlaceholder": "Search roles...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
