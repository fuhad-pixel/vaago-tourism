@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/blogs.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-blog"></i> Blog Posts</h3>
            <a href="{{ url('/admin/blogs/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Blog
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="blogs-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Title</th>
                        <th>Images</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td>#{{ $blog->id }}</td>
                            <td style="font-weight: 700;">{{ $blog->title }}</td>
                            <td>
                                <div class="table-thumbnail-container">
                                    @forelse($blog->images as $img)
                                        <img src="{{ asset($img->image_path) }}" class="table-thumbnail" alt="Blog Image">
                                    @empty
                                        <span class="table-no-image">No images</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>{{ $blog->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/blogs/' . $blog->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/blogs/' . $blog->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this blog post?" style="display:inline;">
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
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No blogs found. Click "Add New Blog" to create one.
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
        $('#blogs-table').DataTable({
            "order": [[0, "desc"]],
            "columnDefs": [
                { "orderable": false, "targets": [2, 4] }
            ],
            "language": {
                "searchPlaceholder": "Search blogs...",
                "search": ""
            }
        });
    });
</script>
@endsection
