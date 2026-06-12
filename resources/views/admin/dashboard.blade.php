@extends('admin.layouts.app')

@section('content')

<!-- Hero Analytics Section -->
<div class="hero-analytics">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>Welcome back, Travel Admin</h1>
            <p>Here is what's happening with your travel business today.</p>
        </div>
        <div class="hero-stats-glass">
            <div class="hero-stat">
                <h5>Today's Revenue</h5>
                <h2>$12,450</h2>
            </div>
            <div class="hero-stat">
                <h5>Active Travelers</h5>
                <h2>842</h2>
            </div>
            <div class="hero-stat">
                <h5>Upcoming Tours</h5>
                <h2>36</h2>
            </div>
            <div class="hero-stat">
                <h5>New Bookings</h5>
                <h2>124</h2>
            </div>
        </div>
    </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
    <!-- KPI 1 -->
    <div class="kpi-card kpi-orange">
        <div class="kpi-header">
            <span class="kpi-title">Total Bookings</span>
            <div class="kpi-icon"><i class="fa-solid fa-plane-departure"></i></div>
        </div>
        <div class="kpi-body">
            <h3>24,856</h3>
            <div class="kpi-trend trend-up">
                <i class="fa-solid fa-arrow-trend-up"></i> +18.5%
            </div>
        </div>
        <div id="spark1" class="kpi-chart-mini"></div>
    </div>
    
    <!-- KPI 2 -->
    <div class="kpi-card kpi-teal">
        <div class="kpi-header">
            <span class="kpi-title">Active Tours</span>
            <div class="kpi-icon"><i class="fa-solid fa-earth-americas"></i></div>
        </div>
        <div class="kpi-body">
            <h3>186</h3>
            <div class="kpi-trend trend-up">
                <i class="fa-solid fa-arrow-trend-up"></i> +12%
            </div>
        </div>
        <div id="spark2" class="kpi-chart-mini"></div>
    </div>
    
    <!-- KPI 3 -->
    <div class="kpi-card kpi-blue">
        <div class="kpi-header">
            <span class="kpi-title">Hotel Partners</span>
            <div class="kpi-icon"><i class="fa-solid fa-hotel"></i></div>
        </div>
        <div class="kpi-body">
            <h3>542</h3>
            <div class="kpi-trend trend-up">
                <i class="fa-solid fa-arrow-trend-up"></i> +7%
            </div>
        </div>
        <div id="spark3" class="kpi-chart-mini"></div>
    </div>
    
    <!-- KPI 4 -->
    <div class="kpi-card kpi-purple">
        <div class="kpi-header">
            <span class="kpi-title">Revenue</span>
            <div class="kpi-icon"><i class="fa-solid fa-wallet"></i></div>
        </div>
        <div class="kpi-body">
            <h3>$2.8M</h3>
            <div class="kpi-trend trend-up">
                <i class="fa-solid fa-arrow-trend-up"></i> +24%
            </div>
        </div>
        <div id="spark4" class="kpi-chart-mini"></div>
    </div>
</div>

<!-- Analytics Section -->
<div class="analytics-grid">
    <div class="glass-panel">
        <div class="panel-header">
            <span class="panel-title">Revenue Analytics</span>
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
    <!-- Dest 1 -->
    <div class="dest-card">
        <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?q=80&w=1000&auto=format&fit=crop" alt="Maldives">
        <div class="dest-glass-badge"><i class="fa-solid fa-star"></i> 4.9</div>
        <div class="dest-overlay">
            <h4>Maldives</h4>
            <div class="dest-stats">
                <span>1.2k Bookings</span>
                <span>$850k</span>
            </div>
        </div>
    </div>
    
    <!-- Dest 2 -->
    <div class="dest-card">
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1000&auto=format&fit=crop" alt="Bali">
        <div class="dest-glass-badge"><i class="fa-solid fa-star"></i> 4.8</div>
        <div class="dest-overlay">
            <h4>Bali</h4>
            <div class="dest-stats">
                <span>980 Bookings</span>
                <span>$420k</span>
            </div>
        </div>
    </div>
    
    <!-- Dest 3 -->
    <div class="dest-card">
        <img src="https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?q=80&w=1000&auto=format&fit=crop" alt="Switzerland">
        <div class="dest-glass-badge"><i class="fa-solid fa-star"></i> 5.0</div>
        <div class="dest-overlay">
            <h4>Switzerland</h4>
            <div class="dest-stats">
                <span>850 Bookings</span>
                <span>$1.1M</span>
            </div>
        </div>
    </div>
    
    <!-- Dest 4 -->
    <div class="dest-card">
        <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1000&auto=format&fit=crop" alt="Dubai">
        <div class="dest-glass-badge"><i class="fa-solid fa-star"></i> 4.7</div>
        <div class="dest-overlay">
            <h4>Dubai</h4>
            <div class="dest-stats">
                <span>1.5k Bookings</span>
                <span>$2.2M</span>
            </div>
        </div>
    </div>
    
    <!-- Dest 5 -->
    <div class="dest-card">
        <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?q=80&w=1000&auto=format&fit=crop" alt="Paris">
        <div class="dest-glass-badge"><i class="fa-solid fa-star"></i> 4.8</div>
        <div class="dest-overlay">
            <h4>Paris</h4>
            <div class="dest-stats">
                <span>2.1k Bookings</span>
                <span>$1.8M</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings Table -->
<div class="glass-panel" style="padding: 0; overflow: hidden;">
    <div class="panel-header" style="padding: 24px 24px 0;">
        <span class="panel-title">Recent Bookings</span>
    </div>
    <div style="padding: 24px; overflow-x: auto;">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Traveler</th>
                    <th>Package</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="traveler-info">
                            <div class="traveler-avatar">JD</div>
                            <span style="font-weight: 700;">John Doe</span>
                        </div>
                    </td>
                    <td>Luxury Resort Package</td>
                    <td>Maldives</td>
                    <td>Oct 12, 2026</td>
                    <td style="font-weight: 700; color: var(--text-primary);">$4,500</td>
                    <td><span class="status-pill status-confirmed">Confirmed</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="traveler-info">
                            <div class="traveler-avatar">AS</div>
                            <span style="font-weight: 700;">Alice Smith</span>
                        </div>
                    </td>
                    <td>Alpine Ski Adventure</td>
                    <td>Switzerland</td>
                    <td>Oct 14, 2026</td>
                    <td style="font-weight: 700; color: var(--text-primary);">$6,200</td>
                    <td><span class="status-pill status-pending">Pending</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="traveler-info">
                            <div class="traveler-avatar">MR</div>
                            <span style="font-weight: 700;">Michael Roe</span>
                        </div>
                    </td>
                    <td>Desert Safari Elite</td>
                    <td>Dubai</td>
                    <td>Oct 15, 2026</td>
                    <td style="font-weight: 700; color: var(--text-primary);">$1,850</td>
                    <td><span class="status-pill status-confirmed">Confirmed</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="traveler-info">
                            <div class="traveler-avatar">ED</div>
                            <span style="font-weight: 700;">Emily Davis</span>
                        </div>
                    </td>
                    <td>Romantic Paris Escape</td>
                    <td>Paris</td>
                    <td>Oct 18, 2026</td>
                    <td style="font-weight: 700; color: var(--text-primary);">$3,400</td>
                    <td><span class="status-pill status-cancelled">Cancelled</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
