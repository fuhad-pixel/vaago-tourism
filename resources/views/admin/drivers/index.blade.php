@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-id-card"></i> Drivers</h3>
            <a href="{{ url('/admin/drivers/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Driver
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="drivers-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>WhatsApp</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drivers as $driver)
                        <tr>
                            <td>#{{ $driver->id }}</td>
                            <td style="font-weight: 700;">{{ $driver->driver_name }}</td>
                            <td>{{ $driver->phone ?? '-' }}</td>
                            <td>{{ $driver->whatsapp_number ?? '-' }}</td>
                            <td>{{ $driver->email ?? '-' }}</td>
                            <td>
                                <div class="table-thumbnail-container">
                                    @if($driver->photo)
                                        <img src="{{ asset($driver->photo) }}" class="table-thumbnail" alt="{{ $driver->driver_name }}" style="max-height: 40px; border-radius: 50%;">
                                    @else
                                        <span class="table-no-image" style="border-radius: 50%;">No photo</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $driver->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/drivers/' . $driver->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/drivers/' . $driver->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this driver?" style="display:inline;">
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
                            <td colspan="8" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-id-card" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No drivers found. Click "Add New Driver" to create one.
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
        if ($('#drivers-table tbody tr.empty-row').length === 0) {
            $('#drivers-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [5, 7] }
                ],
                "language": {
                    "searchPlaceholder": "Search drivers...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
