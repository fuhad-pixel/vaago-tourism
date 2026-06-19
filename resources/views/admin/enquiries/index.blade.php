@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-envelope-open-text"></i> Enquiries</h3>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="enquiries-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Submitted On</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $enquiry)
                        <tr>
                            <td style="font-weight: 700; color: #0369A1;">#{{ $enquiry->id }}</td>
                            <td style="font-weight: 700;">{{ $enquiry->first_name }} {{ $enquiry->last_name }}</td>
                            <td><a href="mailto:{{ $enquiry->email }}" style="color: #4B5563; text-decoration: none;"><i class="fa-regular fa-envelope me-1"></i> {{ $enquiry->email }}</a></td>
                            <td><a href="tel:{{ $enquiry->phone }}" style="color: #4B5563; text-decoration: none;"><i class="fa-solid fa-phone me-1"></i> {{ $enquiry->phone }}</a></td>
                            <td>{{ $enquiry->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/enquiries/' . $enquiry->id) }}" class="btn-table-action" title="View Details" style="background-color: #E0F2FE; color: #0284C7;">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ url('/admin/enquiries/' . $enquiry->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this enquiry?" style="display:inline;">
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
                                <i class="fa-solid fa-envelope-open-text" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No enquiries found.
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
        if ($('#enquiries-table tbody tr.empty-row').length === 0) {
            $('#enquiries-table').DataTable({
                "order": [[4, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ],
                "language": {
                    "searchPlaceholder": "Search enquiries...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
