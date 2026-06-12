@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-circle-question"></i> Global FAQs</h3>
            <a href="{{ url('/admin/faqs/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New FAQ
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="faqs-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Question</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                        <tr>
                            <td>#{{ $faq->id }}</td>
                            <td style="font-weight: 700;">{{ $faq->question }}</td>
                            <td>{{ $faq->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/faqs/' . $faq->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/faqs/' . $faq->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this FAQ?" style="display:inline;">
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
                            <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                <i class="fa-solid fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No FAQs found. Click "Add New FAQ" to create one.
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
        if ($('#faqs-table tbody tr.empty-row').length === 0) {
            $('#faqs-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3] }
                ],
                "language": {
                    "searchPlaceholder": "Search FAQs...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
