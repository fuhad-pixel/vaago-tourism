@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-list-check"></i> Categories</h3>
            <a href="{{ url('/admin/categories/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Category
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="categories-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Parent Category</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>#{{ $category->id }}</td>
                            <td style="font-weight: 700;">{{ $category->name }}</td>
                            <td>
                                @if($category->parent)
                                    <span class="badge" style="background: #E0F2FE; color: #0369A1; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">
                                        {{ $category->parent->name }}
                                    </span>
                                @else
                                    <span style="color: var(--text-secondary); font-style: italic;">None (Root)</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-thumbnail-container">
                                    @if($category->image)
                                        <img src="{{ asset($category->image) }}" class="table-thumbnail" alt="{{ $category->name }}" style="max-height: 40px; border-radius: 4px;">
                                    @else
                                        <span class="table-no-image">No image</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $category->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/categories/' . $category->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/categories/' . $category->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this category?" style="display:inline;">
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
                                No categories found. Click "Add New Category" to create one.
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
        if ($('#categories-table tbody tr.empty-row').length === 0) {
            $('#categories-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3, 5] }
                ],
                "language": {
                    "searchPlaceholder": "Search categories...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
