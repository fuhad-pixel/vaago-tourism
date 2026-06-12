@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-earth-americas"></i> Destinations</h3>
            <a href="{{ url('/admin/destinations/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Destination
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="destinations-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($destinations as $destination)
                        <tr>
                            <td>#{{ $destination->id }}</td>
                            <td style="font-weight: 700;">{{ $destination->name }}</td>
                            <td>
                                <div class="table-thumbnail-container">
                                    @if($destination->image)
                                        <img src="{{ asset($destination->image) }}" class="table-thumbnail" alt="{{ $destination->name }}" style="max-height: 40px; border-radius: 4px;">
                                    @else
                                        <span class="table-no-image">No image</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $destination->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/destinations/' . $destination->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/destinations/' . $destination->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this destination?" style="display:inline;">
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
                            <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No destinations found. Click "Add New Destination" to create one.
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
        if ($('#destinations-table tbody tr.empty-row').length === 0) {
            $('#destinations-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [2, 4] }
                ],
                "language": {
                    "searchPlaceholder": "Search destinations...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
