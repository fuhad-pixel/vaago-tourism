@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-folder-minus"></i> Additional Exclusions</h3>
            <a href="{{ url('/admin/additional-exclusions/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Exclusion
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="exclusions-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Icon Class</th>
                        <th>Preview</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exclusions as $exclusion)
                        <tr>
                            <td>#{{ $exclusion->id }}</td>
                            <td style="font-weight: 700;">{{ $exclusion->name }}</td>
                            <td><code>{{ $exclusion->icon }}</code></td>
                            <td>
                                <span style="font-size: 1.2rem; color: #f15d30;"><i class="{{ $exclusion->icon }}"></i></span>
                            </td>
                            <td>{{ $exclusion->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/additional-exclusions/' . $exclusion->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/additional-exclusions/' . $exclusion->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this exclusion?" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-table-action btn-delete" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No exclusions found. Click "Add New Exclusion" to create one.
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
        if ($('#exclusions-table tbody tr.empty-row').length === 0) {
            $('#exclusions-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3, 5] }
                ],
                "language": {
                    "searchPlaceholder": "Search exclusions...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
