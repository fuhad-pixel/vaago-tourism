@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        /* Custom Toggle Switch Styling */
        .switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 22px;
            margin-bottom: 0;
            vertical-align: middle;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 22px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #10b981;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-route"></i> Tours</h3>
            <a href="{{ url('/admin/tours/create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Tour
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="tours-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Destination</th>
                        <th>Price</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tours as $tour)
                        <tr>
                            <td style="font-weight: 700; color: #0369A1;">{{ $tour->tour_code }}</td>
                            <td style="font-weight: 700;">{{ $tour->name }}</td>
                            <td>
                                <span class="badge" style="background: #E0F2FE; color: #0369A1; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">
                                    {{ $tour->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $tour->destinations->pluck('name')->implode(', ') ?: 'N/A' }}</td>
                            <td>
                                @if($tour->discount_price)
                                    <span style="text-decoration: line-through; color: #9CA3AF; font-size: 0.85rem;">${{ number_format($tour->original_price, 2) }}</span>
                                    <span style="color: #10B981; font-weight: 700;">${{ number_format($tour->discount_price, 2) }}</span>
                                @else
                                    <span style="font-weight: 700;">${{ number_format($tour->original_price, 2) }}</span>
                                @endif
                                <div style="font-size: 0.75rem; color: #6B7280; text-transform: uppercase;">{{ str_replace('_', ' ', $tour->price_type) }}</div>
                            </td>
                            <td>
                                <div class="table-actions" style="justify-content: center; align-items: center; gap: 12px;">
                                    <label class="switch" title="Toggle Status">
                                        <input type="checkbox" class="status-toggle" data-id="{{ $tour->id }}" {{ $tour->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <a href="{{ route('tours.seo.edit', $tour->id) }}" class="btn-table-action" style="color: #6366F1;" title="SEO Settings">
                                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                                    </a>
                                    <a href="{{ url('/admin/tours/' . $tour->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/tours/' . $tour->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this tour?" style="display:inline;">
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
                                No tours found. Click "Add New Tour" to create one.
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
        if ($('#tours-table tbody tr.empty-row').length === 0) {
            $('#tours-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ],
                "language": {
                    "searchPlaceholder": "Search tours...",
                    "search": ""
                }
            });
        }

        $(document).on('change', '.status-toggle', function() {
            let tourId = $(this).data('id');
            let isChecked = $(this).is(':checked') ? 1 : 0;
            let self = $(this);
            
            $.ajax({
                url: `/admin/tours/${tourId}/toggle-status`,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (!response.success) {
                        self.prop('checked', !isChecked);
                        alert(response.message || 'Failed to update status.');
                    }
                },
                error: function() {
                    self.prop('checked', !isChecked);
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    });
</script>
@endsection
