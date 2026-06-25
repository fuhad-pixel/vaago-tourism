@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        .status-pill-lead {
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .status-New { background: #DBEAFE; color: #1E40AF; }
        .status-Contacted { background: #FEF3C7; color: #92400E; }
        .status-Proposal { background: #E0E7FF; color: #3730A3; }
        .status-Negotiating { background: #FFEDD5; color: #9A3412; }
        .status-Confirmed { background: #D1FAE5; color: #065F46; }
        .status-Cancelled { background: #FEE2E2; color: #991B1B; }
        .status-Lost { background: #F3F4F6; color: #374151; }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-users"></i> Leads / CRM</h3>
            <a href="{{ route('leads.create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Lead
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="leads-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Lead Info</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td>#{{ $lead->id }}</td>
                            <td>
                                <strong style="display: block; color: var(--primary);">{{ $lead->name }}</strong>
                                <span style="font-size: 0.85rem; color: var(--text-secondary);">
                                    <i class="fa-regular fa-envelope"></i> {{ $lead->email }}
                                    @if($lead->phone)<br><i class="fa-solid fa-phone"></i> {{ $lead->phone }}@endif
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = str_replace(' ', '', $lead->status);
                                @endphp
                                <span class="status-pill-lead status-{{ $statusClass }}">{{ $lead->status }}</span>
                            </td>
                            <td>
                                @if($lead->assignedTo)
                                    <span style="font-weight: 600;"><i class="fa-solid fa-user"></i> {{ $lead->assignedTo->name }}</span>
                                @else
                                    <span style="color: var(--text-secondary); font-style: italic;">Unassigned</span>
                                @endif
                            </td>
                            <td>{{ $lead->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this lead?" style="display:inline;">
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
                                No Leads found. Click "Add New Lead" to create one.
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
        if ($('#leads-table tbody tr.empty-row').length === 0) {
            $('#leads-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ],
                "language": {
                    "searchPlaceholder": "Search Leads...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
