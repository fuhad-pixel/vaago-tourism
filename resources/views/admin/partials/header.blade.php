<div class="admin-header">
    <div class="header-left-actions" style="display: flex; align-items: center; gap: 16px;">
        <i class="fa-solid fa-bars-staggered sidebar-toggle" id="sidebarToggle" style="font-size: 1.25rem; color: var(--text-secondary); cursor: pointer; transition: color 0.3s;"></i>
        <div class="header-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search destinations, bookings, users...">
        </div>
    </div>
    <div class="header-actions">
        <div class="header-icon">
            <i class="fa-regular fa-bell"></i>
            <span class="badge">4</span>
        </div>
        <div class="profile-card">
            <div class="profile-avatar">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="profile-info">
                <h4>{{ Auth::user()->name ?? 'Admin User' }}</h4>
                <p>System Administrator</p>
            </div>
            <form method="POST" action="{{ url('/admin/logout') }}" style="margin-left: 8px;">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</div>
