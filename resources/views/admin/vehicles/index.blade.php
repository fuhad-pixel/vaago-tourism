@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-car"></i> Vehicles</h3>
            <a href="{{ url('/admin/vehicles/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Vehicle
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="vehicles-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Seating</th>
                        <th>Cost Type</th>
                        <th>Cost</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                        <tr>
                            <td>#{{ $vehicle->id }}</td>
                            <td style="font-weight: 700;">{{ $vehicle->vehicle_name }}</td>
                            <td>{{ $vehicle->type }}</td>
                            <td>{{ $vehicle->seating }}</td>
                            <td>{{ $vehicle->cost_type == 'per_day' ? 'Per Day' : 'Per KM' }}</td>
                            <td>{{ number_format($vehicle->cost, 2) }}</td>
                            <td>
                                <div class="table-thumbnail-container">
                                    @if($vehicle->image)
                                        <img src="{{ asset($vehicle->image) }}" class="table-thumbnail" alt="{{ $vehicle->vehicle_name }}" style="max-height: 40px; border-radius: 4px;">
                                    @else
                                        <span class="table-no-image">No image</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $vehicle->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/vehicles/' . $vehicle->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/vehicles/' . $vehicle->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this vehicle?" style="display:inline;">
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
                            <td colspan="9" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-car" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No vehicles found. Click "Add New Vehicle" to create one.
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
        if ($('#vehicles-table tbody tr.empty-row').length === 0) {
            $('#vehicles-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [6, 8] }
                ],
                "language": {
                    "searchPlaceholder": "Search vehicles...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
