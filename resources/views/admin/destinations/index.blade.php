@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        .custom-tabs {
            display: flex;
            border-bottom: 2px solid #E2E8F0;
            margin-bottom: 20px;
            gap: 10px;
        }
        .custom-tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-secondary);
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s ease;
        }
        .custom-tab:hover {
            color: var(--text-primary);
        }
        .custom-tab.active {
            color: var(--primary, #296c72);
            border-bottom: 2px solid var(--primary, #296c72);
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-earth-americas"></i> Configurations</h3>
            <a href="{{ url('/admin/destinations/create?type=parent') }}" id="btn-add-new-dynamic" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Parent Destination
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        
        <div class="custom-tabs">
            <div class="custom-tab active" data-target="#tab-parent">Parent Destinations</div>
            <div class="custom-tab" data-target="#tab-child">Destinations</div>
        </div>

        <!-- PARENT DESTINATIONS TAB -->
        <div id="tab-parent" class="tab-content active">
            <div class="modern-datatable-wrapper">
                <table class="modern-datatable" id="parent-destinations-table">
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
                        @forelse($parentDestinations as $pDest)
                            <tr>
                                <td>#{{ $pDest->id }}</td>
                                <td style="font-weight: 700;">{{ $pDest->name }}</td>
                                <td>
                                    <div class="table-thumbnail-container">
                                        @if($pDest->image)
                                            <img src="{{ asset($pDest->image) }}" class="table-thumbnail" alt="{{ $pDest->name }}" style="max-height: 40px; border-radius: 4px;">
                                        @else
                                            <span class="table-no-image">No image</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $pDest->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <div class="table-actions" style="justify-content: center;">
                                        <a href="{{ url('/admin/parent-destinations/' . $pDest->id . '/edit') }}" class="btn-table-action" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ url('/admin/parent-destinations/' . $pDest->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this parent destination?" style="display:inline;">
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
                                    No parent destinations found. Click "Add New Parent Destination" to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- DESTINATIONS TAB -->
        <div id="tab-child" class="tab-content">
            <div class="modern-datatable-wrapper">
                <table class="modern-datatable" id="destinations-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Name</th>
                            <th>Parent</th>
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
                                <td>{{ $destination->parentDestination ? $destination->parentDestination->name : '-' }}</td>
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
                                <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 30px;">
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
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Init DataTables
        if ($('#parent-destinations-table tbody tr.empty-row').length === 0) {
            $('#parent-destinations-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [2, 4] }
                ],
                "language": {
                    "searchPlaceholder": "Search parent destinations...",
                    "search": ""
                }
            });
        }
        
        if ($('#destinations-table tbody tr.empty-row').length === 0) {
            $('#destinations-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3, 5] }
                ],
                "language": {
                    "searchPlaceholder": "Search destinations...",
                    "search": ""
                }
            });
        }

        // Tab Switching Logic
        $('.custom-tab').on('click', function() {
            $('.custom-tab').removeClass('active');
            $('.tab-content').removeClass('active');
            
            $(this).addClass('active');
            $($(this).data('target')).addClass('active');

            // Update Add New button
            if ($(this).data('target') === '#tab-parent') {
                $('#btn-add-new-dynamic').attr('href', '{{ url("/admin/destinations/create?type=parent") }}');
                $('#btn-add-new-dynamic').html('<i class="fa-solid fa-plus"></i> Add New Parent Destination');
            } else {
                $('#btn-add-new-dynamic').attr('href', '{{ url("/admin/destinations/create") }}');
                $('#btn-add-new-dynamic').html('<i class="fa-solid fa-plus"></i> Add New Destination');
            }
        });
    });
</script>
@endsection
