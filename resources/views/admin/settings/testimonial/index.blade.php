@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/blogs.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-comments"></i> Testimonials</h3>
            <a href="{{ url('/admin/settings/testimonial/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add Testimonial
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="testimonials-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>DP</th>
                        <th>Client Name</th>
                        <th>Designation</th>
                        <th>Rating</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            <td>#{{ $testimonial->id }}</td>
                            <td>
                                <div class="table-thumbnail-container">
                                    @if($testimonial->client_dp)
                                        <img src="{{ asset($testimonial->client_dp) }}" class="table-thumbnail" alt="Client DP" style="max-height: 50px; border-radius: 50%; width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <span class="table-no-image">No image</span>
                                    @endif
                                </div>
                            </td>
                            <td style="font-weight: 700;">{{ $testimonial->client_name }}</td>
                            <td>{{ $testimonial->designation }}</td>
                            <td>
                                <div style="color: #FBBF24;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $testimonial->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>{{ $testimonial->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/settings/testimonial/' . $testimonial->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/settings/testimonial/' . $testimonial->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this testimonial?" style="display:inline;">
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
                                No testimonials found. Click "Add Testimonial" to create one.
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
        if ($('#testimonials-table tbody tr.empty-row').length === 0) {
            $('#testimonials-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [1, 4, 6] }
                ],
                "language": {
                    "searchPlaceholder": "Search testimonials...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
