@extends('admin.layouts.app')

@section('styles')
<style>
    /* Modern Glassmorphic KPI Cards Styling */
    .kpi-grid-glassmorphic {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    @media (max-width: 1200px) {
        .kpi-grid-glassmorphic {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .kpi-grid-glassmorphic {
            grid-template-columns: 1fr;
        }
    }

    .kpi-glass-card {
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 0;
        padding: 20px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.04), inset 0 0 0 1px rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .kpi-glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(31, 38, 135, 0.08);
        background: rgba(255, 255, 255, 0.65);
        border-color: rgba(255, 255, 255, 0.8);
    }

    .kpi-glass-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        border-radius: 4px 0 0 4px;
    }

    .kpi-glass-orange::after {
        background: linear-gradient(to bottom, #FF6B35, #FF8E53);
    }

    .kpi-glass-green::after {
        background: linear-gradient(to bottom, #10B981, #34D399);
    }

    .kpi-glass-red::after {
        background: linear-gradient(to bottom, #EF4444, #F87171);
    }

    .kpi-glass-blue::after {
        background: linear-gradient(to bottom, #3B82F6, #60A5FA);
    }

    .kpi-glass-info {
        display: flex;
        flex-direction: column;
    }

    .kpi-glass-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .kpi-glass-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .kpi-glass-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .kpi-glass-orange .kpi-glass-icon {
        background: rgba(255, 107, 53, 0.1);
        color: #FF6B35;
    }

    .kpi-glass-green .kpi-glass-icon {
        background: rgba(16, 185, 129, 0.1);
        color: #10B981;
    }

    .kpi-glass-red .kpi-glass-icon {
        background: rgba(239, 68, 68, 0.1);
        color: #EF4444;
    }

    .kpi-glass-blue .kpi-glass-icon {
        background: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
    }

    /* SaaS Enquiries Section Header */
    .enquiries-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 24px 16px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        box-sizing: border-box;
    }

    .enquiries-title-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .enquiries-live-badge {
        background: rgba(41, 108, 114, 0.08);
        color: #296c72;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .enquiries-live-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        animation: badgePulse 1.6s infinite ease-in-out;
    }

    @keyframes badgePulse {
        0% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(1.3); opacity: 1; }
        100% { transform: scale(1); opacity: 0.8; }
    }

    .enquiries-view-all-btn {
        color: #296c72;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .enquiries-view-all-btn:hover {
        color: #36848b;
        transform: translateX(2px);
    }

    /* Modern SaaS Table Style */
    .saas-enquiries-table {
        width: 100%;
        border-collapse: collapse;
    }

    .saas-enquiries-table th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 24px;
        color: #64748b;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-align: left;
    }

    .saas-enquiries-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .saas-enquiries-table tr:hover td {
        background: #fdfdfd;
        border-bottom-color: #e2e8f0;
    }

    .saas-enquiries-table tr {
        transition: all 0.2s ease;
    }

    .saas-enquiries-table tr:hover {
        transform: translateX(3px);
    }

    /* Traveler Group styling */
    .traveler-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .saas-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(41, 108, 114, 0.08);
        color: #296c72;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.95rem;
        border: 1px solid rgba(41, 108, 114, 0.15);
    }

    .traveler-meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .traveler-name {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.95rem;
    }

    .traveler-contact {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
    }

    /* Details Styling */
    .details-date {
        font-weight: 700;
        color: #334155;
        font-size: 0.9rem;
    }

    .details-duration {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
        margin-top: 2px;
    }

    /* Message bubble styling */
    .message-preview-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #475569;
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .message-preview-box i {
        color: #296c72;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* Action button styling */
    .crm-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
    }

    .crm-action-btn:hover {
        background: #296c72;
        color: #ffffff;
        border-color: #296c72;
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')

<!-- Dashboard Welcome Header -->
<div class="dashboard-greeting-bar">
    <div class="greeting-left">
        <h2 class="greeting-title">Welcome back, {{ Auth::user()->name ?? 'Admin' }}! <span class="wave-emoji">👋</span></h2>
        <p class="greeting-subtitle">Here is the overview of Vaago Tourism's performance today.</p>
    </div>
    <div class="greeting-right">
        <div class="status-pill-pulse">
            <span class="pulse-dot"></span>
            <span class="status-text">All Systems Operational</span>
        </div>
        <div class="date-badge">
            <i class="fa-regular fa-calendar"></i>
            <span>{{ now()->format('F d, Y') }}</span>
        </div>
        <div class="action-dropdown-btn">
            <i class="fa-solid fa-filter"></i>
            <span>Last 30 Days</span>
            <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem;"></i>
        </div>
    </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid-glassmorphic">
    <!-- Total Tours -->
    <div class="kpi-glass-card kpi-glass-blue">
        <div class="kpi-glass-info">
            <span class="kpi-glass-title">Total Tours</span>
            <span class="kpi-glass-value">{{ $totalTours }}</span>
        </div>
        <div class="kpi-glass-icon"><i class="fa-solid fa-compass"></i></div>
    </div>

    <!-- Active Tours -->
    <div class="kpi-glass-card kpi-glass-green">
        <div class="kpi-glass-info">
            <span class="kpi-glass-title">Active Tours</span>
            <span class="kpi-glass-value">{{ $activeTours }}</span>
        </div>
        <div class="kpi-glass-icon"><i class="fa-solid fa-circle-check"></i></div>
    </div>

    <!-- Total Blogs -->
    <div class="kpi-glass-card kpi-glass-red">
        <div class="kpi-glass-info">
            <span class="kpi-glass-title">Total Blogs</span>
            <span class="kpi-glass-value">{{ $totalBlogs }}</span>
        </div>
        <div class="kpi-glass-icon"><i class="fa-solid fa-newspaper"></i></div>
    </div>

    <!-- Total Enquiries -->
    <div class="kpi-glass-card kpi-glass-orange">
        <div class="kpi-glass-info">
            <span class="kpi-glass-title">Total Enquiries</span>
            <span class="kpi-glass-value">{{ $totalEnquiries }}</span>
        </div>
        <div class="kpi-glass-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
    </div>
</div>

<!-- Analytics Section -->
<div class="analytics-grid">
    <div class="glass-panel">
        <div class="panel-header">
            <span class="panel-title">Monthly Enquiries</span>
        </div>
        <div id="revenueChart" class="chart-container"></div>
    </div>

    <div class="glass-panel">
        <div class="panel-header">
            <span class="panel-title">Travel Categories</span>
        </div>
        <div id="categoryChart" class="chart-container"></div>
    </div>
</div>

<!-- Destination Performance -->
<div class="panel-header" style="margin-top: 16px;">
    <span class="panel-title">Top Destinations</span>
</div>
<div class="destination-grid">
    @forelse($destinations as $destination)
    @php
    $rating = number_format(4.5 + ($destination->id % 5) * 0.1, 1);
    $bookingsCount = ($destination->tours_count * 15) + ($destination->id * 7);
    $revenueAmount = number_format($bookingsCount * 1250);
    @endphp
    <div class="dest-card">
        <img src="{{ $destination->image ? asset($destination->image) : 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?q=80&w=1000&auto=format&fit=crop' }}" alt="{{ $destination->name }}">
        <div class="dest-glass-badge"><i class="fa-solid fa-star"></i> {{ $rating }}</div>
        <div class="dest-overlay">
            <h4>{{ $destination->name }}</h4>
            <div class="dest-stats">
                <span>{{ $bookingsCount }} {{ Str::plural('Booking', $bookingsCount) }}</span>
                <span>${{ $revenueAmount }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="glass-panel text-center py-4" style="grid-column: span 5; width: 100%;">
        <span class="text-muted">No destinations found.</span>
    </div>
    @endforelse
</div>

<!-- Recent Enquiries Table -->
<div class="glass-panel" style="padding: 0; overflow: hidden; margin-top: 24px;">
    <div class="enquiries-header-container">
        <div class="enquiries-title-group">
            <span class="panel-title" style="margin-bottom: 0;">Recent Enquiries</span>
            <span class="enquiries-live-badge">Live</span>
        </div>
        <a href="{{ url('/admin/enquiries') }}" class="enquiries-view-all-btn">
            <span>View All CRM</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    <div style="overflow-x: auto;">
        <table class="saas-enquiries-table">
            <thead>
                <tr>
                    <th>Enquirer</th>
                    <th>Travel Details</th>
                    <th>Preferences</th>
                    <th>Message</th>
                    <th>Received</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentEnquiries as $enquiry)
                <tr>
                    <td>
                        <div class="traveler-group">
                            <div class="saas-avatar">
                                {{ strtoupper(substr($enquiry->first_name, 0, 1) . substr($enquiry->last_name, 0, 1)) }}
                            </div>
                            <div class="traveler-meta">
                                <span class="traveler-name">{{ $enquiry->first_name }} {{ $enquiry->last_name }}</span>
                                <span class="traveler-contact">{{ $enquiry->email }} • {{ $enquiry->phone }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="details-date">Arrival: {{ \Carbon\Carbon::parse($enquiry->arrival_date)->format('M d, Y') }}</div>
                        <div class="details-duration">{{ $enquiry->nights }} {{ Str::plural('Night', $enquiry->nights) }}</div>
                    </td>
                    <td>
                        <span class="badge" style="background: #E0F2FE; color: #0369A1; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; text-transform: capitalize; display: inline-block;">
                            {{ str_replace('_', ' ', $enquiry->accommodation_type) }}
                        </span>
                        @if($enquiry->honeymoon)
                        <span class="badge" style="background: #FCE7F3; color: #DB2777; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; margin-left: 6px; display: inline-block;">
                            Honeymoon
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="message-preview-box" title="{{ $enquiry->message }}">
                            <i class="fa-regular fa-comment-dots"></i>
                            <span>{{ $enquiry->message ?: 'No message' }}</span>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 700; color: #475569; font-size: 0.9rem;">{{ $enquiry->created_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <a href="{{ url('/admin/enquiries/' . $enquiry->id) }}" class="crm-action-btn" title="View Enquiry Details">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 40px;">
                        <i class="fa-solid fa-inbox" style="font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: 0.4; color: #296c72;"></i>
                        No recent enquiries found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.dashboardChartData = {
        months: @json($monthlyMonths),
        enquiries: @json($monthlyEnquiries),
        categoryNames: @json($categoryNames),
        categoryCounts: @json($categoryCounts)
    };
</script>
@endsection