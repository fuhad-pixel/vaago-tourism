@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-person-snowboarding"></i> Activities Master</h3>
            <a href="{{ route('activities.create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Activity
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="activities-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Activity Name</th>
                        <th>Destination</th>
                        <th>Adult Cost</th>
                        <th>Child Cost</th>
                        <th>Infant Cost</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>#{{ $activity->id }}</td>
                            <td>
                                <strong style="display: block; color: var(--primary); font-size: 1.05rem;">{{ $activity->name }}</strong>
                            </td>
                            <td>
                                @if($activity->destination)
                                    <span style="font-weight: 600;"><i class="fa-solid fa-location-dot"></i> {{ $activity->destination->name }}</span>
                                @else
                                    <span style="color: var(--text-secondary); font-style: italic;">N/A</span>
                                @endif
                            </td>
                            <td><span style="color: #059669; font-weight: 600;">${{ number_format($activity->cost_adult, 2) }}</span></td>
                            <td>
                                @if($activity->cost_child > 0)
                                    <span style="color: #059669;">${{ number_format($activity->cost_child, 2) }}</span>
                                @else
                                    <span style="color: #9CA3AF;">$0.00</span>
                                @endif
                            </td>
                            <td>
                                @if($activity->cost_infant > 0)
                                    <span style="color: #059669;">${{ number_format($activity->cost_infant, 2) }}</span>
                                @else
                                    <span style="color: #9CA3AF;">$0.00</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ route('activities.edit', $activity->id) }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this activity?" style="display:inline;">
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
                            <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No Activities found. Click "Add New Activity" to create one.
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
        if ($('#activities-table tbody tr.empty-row').length === 0) {
            $('#activities-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [6] }
                ],
                "language": {
                    "searchPlaceholder": "Search Activities...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
