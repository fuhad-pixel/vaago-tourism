@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/blogs.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-images"></i> Slider Settings</h3>
            <a href="{{ url('/admin/settings/slider/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Slide
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="sliders-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Video URL</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $slider)
                        <tr>
                            <td>#{{ $slider->id }}</td>
                            <td>
                                <div class="table-thumbnail-container">
                                    @if($slider->image_path)
                                        <img src="{{ asset($slider->image_path) }}" class="table-thumbnail" alt="Slider Image" style="max-height: 50px; border-radius: 4px;">
                                    @else
                                        <span class="table-no-image">No image</span>
                                    @endif
                                </div>
                            </td>
                            <td style="font-weight: 700;">{{ $slider->title }}</td>
                            <td>{{ $slider->subtitle ?? '-' }}</td>
                            <td>
                                @if($slider->video_url)
                                    <a href="{{ $slider->video_url }}" target="_blank" style="color: var(--accent-color);"><i class="fa-solid fa-circle-play"></i> Watch</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $slider->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/settings/slider/' . $slider->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/settings/slider/' . $slider->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this slide?" style="display:inline;">
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
                                No slides found. Click "Add New Slide" to create one.
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
        if ($('#sliders-table tbody tr.empty-row').length === 0) {
            $('#sliders-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [1, 4, 6] }
                ],
                "language": {
                    "searchPlaceholder": "Search slides...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
