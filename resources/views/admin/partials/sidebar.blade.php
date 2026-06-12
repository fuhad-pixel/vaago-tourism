<div class="admin-sidebar" id="sidebar">
    <div class="sidebar-brand d-flex align-items-center justify-content-center" style="padding: 20px 24px; text-align: center;">
        @if(isset($company_setting) && $company_setting->logo_path)
            <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'TravelLux' }}" style="max-height: 50px; max-width: 100%; object-fit: contain;">
        @else
            {{ $company_setting->company_name ?? 'Travel' }}<span>Lux</span>
        @endif
    </div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <!-- <li>
            <a href="#">
                <i class="fa-solid fa-calendar-check"></i> <span class="menu-text">Bookings</span>
            </a>
        </li> -->
        <li>
            <a href="{{ url('/admin/tours') }}" class="{{ request()->is('admin/tours*') ? 'active' : '' }}">
                <i class="fa-solid fa-route"></i> <span class="menu-text">Tours</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/additional-inclusions') }}" class="{{ request()->is('admin/additional-inclusions*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-plus"></i> <span class="menu-text">Inclusions</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/faqs') }}" class="{{ request()->is('admin/faqs*') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-question"></i> <span class="menu-text">FAQs</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/destinations') }}" class="{{ request()->is('admin/destinations*') ? 'active' : '' }}">
                <i class="fa-solid fa-earth-americas"></i> <span class="menu-text">Destinations</span>
            </a>
        </li>
        <!-- <li>
            <a href="#">
                <i class="fa-solid fa-hotel"></i> <span class="menu-text">Hotels</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-users"></i> <span class="menu-text">Customers</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-user-tie"></i> <span class="menu-text">Guides</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-star"></i> <span class="menu-text">Reviews</span>
            </a>
        </li> -->
        <li>
            <a href="{{ url('/admin/blogs') }}" class="{{ request()->is('admin/blogs*') ? 'active' : '' }}">
                <i class="fa-solid fa-blog"></i> <span class="menu-text">Blogs</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/categories') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> <span class="menu-text">Categories</span>
            </a>
        </li>
        <li class="has-submenu {{ request()->is('admin/settings*') ? 'open' : '' }}">
            <a href="javascript:void(0)" class="submenu-toggle {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> <span class="menu-text">Settings</span>
                <i class="fa-solid fa-chevron-down submenu-icon" style="margin-left: auto; transition: transform 0.3s; {{ request()->is('admin/settings*') ? 'transform: rotate(180deg);' : '' }}"></i>
            </a>
            <ul class="submenu" style="{{ request()->is('admin/settings*') ? 'display: block;' : 'display: none;' }} list-style: none; padding: 0; margin: 0;">
                <li>
                    <a href="{{ url('/admin/settings/company') }}" class="submenu-link {{ request()->is('admin/settings/company') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">Company Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/settings/policies') }}" class="submenu-link {{ request()->is('admin/settings/policies') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">Policies Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/settings/slider') }}" class="submenu-link {{ request()->is('admin/settings/slider*') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">Slider Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/settings/testimonial') }}" class="submenu-link {{ request()->is('admin/settings/testimonial*') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">Testimonials</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/settings/smtp') }}" class="submenu-link {{ request()->is('admin/settings/smtp') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">SMTP Settings</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>