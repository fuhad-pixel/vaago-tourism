@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        .status-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f9fafb;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
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
            background-color: #ccc;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #00B8A9;
        }

        input:checked + .slider:before {
            transform: translateX(22px);
        }

        .slider.round {
            border-radius: 24px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3 style="display:flex; align-items:center; gap: 10px;"><i class="fa-solid fa-id-card"></i> Travel Guides</h3>
            
            <div style="display: flex; gap: 16px; align-items: center;">
                <div class="status-toggle">
                    <span style="font-size: 14px; font-weight: 500; color: #4b5563;">Show on Frontend</span>
                    <label class="switch">
                        <input type="checkbox" id="travelGuideStatusToggle" {{ $travel_guide_status == '1' ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <a href="{{ url('/admin/travel-guides/create') }}" class="btn-add-new">
                    <i class="fa-solid fa-plus"></i> Add New Guide
                </a>
            </div>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="guides-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Photo</th>
                        <th>Created At</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guides as $guide)
                        <tr>
                            <td>#{{ $guide->id }}</td>
                            <td style="font-weight: 700;">{{ $guide->name }}</td>
                            <td>{{ $guide->designation ?? '-' }}</td>
                            <td>
                                <div class="table-thumbnail-container">
                                    @if($guide->photo)
                                        <img src="{{ asset($guide->photo) }}" class="table-thumbnail" alt="{{ $guide->name }}" style="max-height: 40px; border-radius: 4px;">
                                    @else
                                        <span class="table-no-image">No photo</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $guide->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ url('/admin/travel-guides/' . $guide->id . '/edit') }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('/admin/travel-guides/' . $guide->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this travel guide?" style="display:inline;">
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
                                <i class="fa-solid fa-id-card" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                No travel guides found. Click "Add New Guide" to create one.
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
        if ($('#guides-table tbody tr.empty-row').length === 0) {
            $('#guides-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [3, 5] }
                ],
                "language": {
                    "searchPlaceholder": "Search guides...",
                    "search": ""
                }
            });
        }

        $('#travelGuideStatusToggle').change(function() {
            var status = $(this).is(':checked') ? 1 : 0;
            
            $.ajax({
                url: "{{ route('travel-guides.toggle-status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status
                },
                success: function(response) {
                    if(response.success) {
                        showToast('success', 'Success', response.message);
                    } else {
                        showToast('error', 'Error', 'Failed to update status.');
                    }
                },
                error: function() {
                    showToast('error', 'Error', 'Something went wrong.');
                }
            });
        });
    });
</script>
@endsection
