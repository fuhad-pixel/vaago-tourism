@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-utensils"></i> Meals</h3>
            <a href="{{ url('/admin/meals/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Meal
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="meals-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Meal Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($meals as $meal)
                        <tr>
                            <td>#{{ $meal->id }}</td>
                            <td style="font-weight: 700;">{{ $meal->meal }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($meal->description, 50) }}</td>
                            <td>{{ $meal->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/meals/' . $meal->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/meals/' . $meal->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this meal?" style="display:inline;">
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
                                <i class="fa-solid fa-utensils" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No meals found. Click "Add New Meal" to create one.
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
        if ($('#meals-table tbody tr.empty-row').length === 0) {
            $('#meals-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [4] }
                ],
                "language": {
                    "searchPlaceholder": "Search meals...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
