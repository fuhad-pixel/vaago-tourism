@extends('admin.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
    <style>
        .hotel-thumbnail {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .placeholder-image {
            width: 80px;
            height: 60px;
            background: #F3F4F6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9CA3AF;
            font-size: 1.5rem;
        }
    </style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-hotel"></i> Hotels Master</h3>
            <a href="{{ route('hotels.create') }}" class="btn-add-new">
                <i class="fa-solid fa-plus"></i> Add New Hotel
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="modern-datatable-wrapper">
            <table class="modern-datatable" id="hotels-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 100px;">Image</th>
                        <th>Hotel Details</th>
                        <th>Destination</th>
                        <th>Contact Info</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hotels as $hotel)
                        <tr>
                            <td>#{{ $hotel->id }}</td>
                            <td>
                                @if($hotel->image)
                                    <img src="{{ asset($hotel->image) }}" alt="{{ $hotel->hotel_name }}" class="hotel-thumbnail">
                                @else
                                    <div class="placeholder-image">
                                        <i class="fa-regular fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong style="display: block; color: var(--primary); font-size: 1.05rem;">{{ $hotel->hotel_name }}</strong>
                                <span style="font-size: 0.85rem; color: var(--text-secondary); display: block; margin-top: 4px;">
                                    <span style="background: #E0E7FF; color: #3730A3; padding: 2px 8px; border-radius: 4px; font-weight: 600;">{{ $hotel->category }}</span>
                                    @if($hotel->star_rating)
                                        <span style="color: #F59E0B; margin-left: 8px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-{{ $i <= $hotel->star_rating ? 'solid' : 'regular' }} fa-star"></i>
                                            @endfor
                                        </span>
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($hotel->destination)
                                    <span style="font-weight: 600;"><i class="fa-solid fa-location-dot"></i> {{ $hotel->destination->name }}</span>
                                @else
                                    <span style="color: var(--text-secondary); font-style: italic;">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span style="font-size: 0.85rem; color: var(--text-secondary);">
                                    @if($hotel->contact_person)<i class="fa-solid fa-user"></i> {{ $hotel->contact_person }}<br>@endif
                                    @if($hotel->phone)<i class="fa-solid fa-phone"></i> {{ $hotel->phone }}@endif
                                </span>
                            </td>
                            <td>
                                <div class="table-actions" style="justify-content: center;">
                                    <a href="{{ route('hotels.edit', $hotel->id) }}" class="btn-table-action" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST" class="delete-confirm-form" data-message="Are you sure you want to delete this hotel?" style="display:inline;">
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
                                No Hotels found. Click "Add New Hotel" to create one.
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
        if ($('#hotels-table tbody tr.empty-row').length === 0) {
            $('#hotels-table').DataTable({
                "order": [[0, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [1, 5] }
                ],
                "language": {
                    "searchPlaceholder": "Search Hotels...",
                    "search": ""
                }
            });
        }
    });
</script>
@endsection
