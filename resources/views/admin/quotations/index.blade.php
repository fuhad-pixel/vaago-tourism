@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        .badge-status {
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
        }
        .badge-status.draft {
            background: rgba(107, 114, 128, 0.1);
            color: #6B7280;
        }
        .badge-status.sent {
            background: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }
        .badge-status.approved {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }
        .badge-status.saved {
            background: rgba(79, 70, 229, 0.1);
            color: #4F46E5;
        }
        .btn-table-action.btn-send-mail {
            color: #f15d30;
            background: rgba(241, 93, 48, 0.1);
        }
        .btn-table-action.btn-send-mail:hover {
            color: #ffffff;
            background: #f15d30;
        }
        .pax-container {
            display: flex;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .pax-badge {
            background: #F1F5F9;
            color: #475569;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-file-invoice-dollar"></i> Quotations</h3>
            <a href="{{ url('/admin/quotations/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Create Quotation
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="quotations-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Quotation Title</th>
                        <th>Lead</th>
                        <th>Pax Details</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                        <tr>
                            <td>
                                @if($quotation->quotation_code)
                                    <strong style="color: var(--primary); font-size: 0.85rem;">{{ $quotation->quotation_code }}</strong>
                                    <div style="font-size: 0.7rem; color: var(--text-secondary);">ID: #{{ $quotation->id }}</div>
                                @else
                                    #{{ $quotation->id }}
                                @endif
                            </td>
                            <td style="font-weight: 700;">{{ $quotation->title ?? 'Untitled Itinerary' }}</td>
                            <td>
                                @if($quotation->lead)
                                    <div><strong>{{ $quotation->lead->name }}</strong></div>
                                    <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $quotation->lead->email }}</div>
                                @else
                                    <span style="color: var(--text-secondary);">No Lead</span>
                                @endif
                            </td>
                            <td>
                                <div class="pax-container">
                                    <span class="pax-badge" title="Adults">A: {{ $quotation->adults ?? 0 }}</span>
                                    <span class="pax-badge" title="Children">C: {{ $quotation->children ?? 0 }}</span>
                                    <span class="pax-badge" title="Infants">I: {{ $quotation->infants ?? 0 }}</span>
                                </div>
                            </td>
                            <td style="font-weight: 700; color: var(--primary);">
                                @if($quotation->currency == 'USD')
                                    ${{ number_format($quotation->grand_total, 2) }}
                                @else
                                    ₹{{ number_format($quotation->grand_total, 2) }}
                                @endif
                            </td>
                            <td>
                                <span class="badge-status {{ strtolower($quotation->status ?? 'Draft') }}">
                                    {{ $quotation->status ?? 'Draft' }}
                                </span>
                            </td>
                            <td>{{ $quotation->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url(($quotation->lead ? Str::slug($quotation->lead->name) : 'guest') . '/' . ($quotation->quotation_code ?? $quotation->id)) }}" class="btn-table-action" title="View Public" target="_blank">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/admin/quotations/' . $quotation->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if($quotation->lead && $quotation->lead->email)
                                        <form action="{{ route('admin.quotations.send_mail', $quotation->id) }}" method="POST" class="send-mail-confirm-form" data-email="{{ $quotation->lead->email }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-table-action btn-send-mail" title="Send Email to {{ $quotation->lead->email }}">
                                                <i class="fa-solid fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn-table-action" style="opacity: 0.4; cursor: not-allowed;" title="No Lead Email available" disabled>
                                            <i class="fa-solid fa-paper-plane" style="color: #94a3b8;"></i>
                                        </button>
                                    @endif
                                    <form action="{{ url('/admin/quotations/' . $quotation->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this quotation? This will also delete all associated itineraries." style="display:inline;">
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
                            <td colspan="8" style="text-align: center; color: var(--text-secondary); padding: 40px;">
                                <i class="fa-solid fa-file-invoice-dollar" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                                No quotations created yet. Click "Create Quotation" to get started.
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
        if ($('#quotations-table tbody tr.empty-row').length === 0) {
            $('#quotations-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3, 7] }
                ],
                "language": {
                    "searchPlaceholder": "Search quotations...",
                    "search": ""
                }
            });
        }

        // Confirm send email dialog
        $(document).on('submit', '.send-mail-confirm-form', function(e) {
            e.preventDefault();
            const form = this;
            const email = $(this).data('email') || 'the client';
            const message = `Are you sure you want to send this quotation itinerary email to ${email}?`;
            const title = 'Confirm Send Email';
            
            if (typeof showConfirmModal === 'function') {
                showConfirmModal(title, message, function() {
                    $(form).find('button').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');
                    form.submit();
                }, {
                    confirmText: 'Yes, Send Email',
                    confirmClass: 'btn-confirm-primary',
                    iconHtml: '<i class="fa-solid fa-paper-plane" style="color: var(--primary, #3B82F6);"></i>'
                });
            } else {
                if (confirm(message)) {
                    $(form).find('button').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');
                    form.submit();
                }
            }
        });
    });
</script>
@endsection
