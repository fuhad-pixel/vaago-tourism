@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-folder-plus"></i> Additional Inclusions</h3>
            <a href="{{ url('/admin/additional-inclusions/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Inclusion
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="inclusions-table">
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
                    @forelse($inclusions as $inclusion)
                        <tr>
                            <td>#{{ $inclusion->id }}</td>
                            <td style="font-weight: 700;">{{ $inclusion->name }}</td>
                            <td><code>{{ $inclusion->icon }}</code></td>
                            <td>
                                <span style="font-size: 1.2rem; color: #f15d30;"><i class="{{ $inclusion->icon }}"></i></span>
                            </td>
                            <td>{{ $inclusion->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/additional-inclusions/' . $inclusion->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/additional-inclusions/' . $inclusion->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this inclusion?" style="display:inline;">
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
                                No inclusions found. Click "Add New Inclusion" to create one.
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
        if ($('#inclusions-table tbody tr.empty-row').length === 0) {
            $('#inclusions-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3, 5] }
                ],
                "language": {
                    "searchPlaceholder": "Search inclusions...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
