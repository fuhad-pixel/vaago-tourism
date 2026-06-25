<div class="admin-sidebar" id="sidebar">
    <div class="sidebar-brand d-flex align-items-center justify-content-center" style="padding: 20px 24px; text-align: center;">
        @if(isset($company_setting) && $company_setting->logo_path)
            <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'TravelLux' }}" style="max-height: 50px; max-width: 100%; object-fit: contain;">
        @else
            {{ $company_setting->company_name ?? 'Travel' }}<span>Lux</span>
        @endif
    </div>
    <ul class="sidebar-nav">
        @can('manage_dashboard')
        <li>
            <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> <span class="menu-text">Dashboard</span>
            </a>
        </li>
        @endcan

        @can('manage_tours')
        <li>
            <a href="{{ url('/admin/tours') }}" class="{{ request()->is('admin/tours*') ? 'active' : '' }}">
                <i class="fa-solid fa-route"></i> <span class="menu-text">Tours</span>
            </a>
        </li>
        @endcan

        <li>
            <a href="{{ url('/admin/quotations') }}" class="{{ request()->is('admin/quotations*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> <span class="menu-text">Quotations</span>
            </a>
        </li>

        @can('manage_inclusions')
        <li>
            <a href="{{ url('/admin/additional-inclusions') }}" class="{{ request()->is('admin/additional-inclusions*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-plus"></i> <span class="menu-text">Inclusions</span>
            </a>
        </li>
        @endcan
        @can('manage_exclusions')
        <li>
            <a href="{{ url('/admin/additional-exclusions') }}" class="{{ request()->is('admin/additional-exclusions*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-minus"></i> <span class="menu-text">Exclusions</span>
            </a>
        </li>
        @endcan

        @can('manage_faqs')
        <li>
            <a href="{{ url('/admin/faqs') }}" class="{{ request()->is('admin/faqs*') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-question"></i> <span class="menu-text">FAQs</span>
            </a>
        </li>
        @endcan

        @can('manage_destinations')
        <li>
            <a href="{{ url('/admin/destinations') }}" class="{{ request()->is('admin/destinations*') ? 'active' : '' }}">
                <i class="fa-solid fa-earth-americas"></i> <span class="menu-text">Destinations</span>
            </a>
        </li>
        @endcan

        @can('manage_vehicles')
        <li>
            <a href="{{ url('/admin/vehicles') }}" class="{{ request()->is('admin/vehicles*') ? 'active' : '' }}">
                <i class="fa-solid fa-car"></i> <span class="menu-text">Vehicles</span>
            </a>
        </li>
        @endcan

        @can('manage_drivers')
        <li>
            <a href="{{ url('/admin/drivers') }}" class="{{ request()->is('admin/drivers*') ? 'active' : '' }}">
                <i class="fa-solid fa-id-card"></i> <span class="menu-text">Drivers</span>
            </a>
        </li>
        @endcan

        @can('manage_hotels')
        <li>
            <a href="{{ url('/admin/hotels') }}" class="{{ request()->is('admin/hotels*') ? 'active' : '' }}">
                <i class="fa-solid fa-hotel"></i> <span class="menu-text">Hotels</span>
            </a>
        </li>
        @endcan

        @can('manage_activities')
        <li>
            <a href="{{ url('/admin/activities') }}" class="{{ request()->is('admin/activities*') ? 'active' : '' }}">
                <i class="fa-solid fa-person-snowboarding"></i> <span class="menu-text">Activities</span>
            </a>
        </li>
        @endcan

        @can('manage_travel_guides')
        <li>
            <a href="{{ url('/admin/travel-guides') }}" class="{{ request()->is('admin/travel-guides*') ? 'active' : '' }}">
                <i class="fa-solid fa-id-card"></i> <span class="menu-text">Travel Guides</span>
            </a>
        </li>
        @endcan

        @can('manage_blogs')
        <li>
            <a href="{{ url('/admin/blogs') }}" class="{{ request()->is('admin/blogs*') ? 'active' : '' }}">
                <i class="fa-solid fa-blog"></i> <span class="menu-text">Blogs</span>
            </a>
        </li>
        @endcan

        @can('manage_categories')
        <li>
            <a href="{{ url('/admin/categories') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> <span class="menu-text">Categories</span>
            </a>
        </li>
        @endcan

        @can('manage_leads')
        <li>
            <a href="{{ url('/admin/leads') }}" class="{{ request()->is('admin/leads*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> <span class="menu-text">Leads / CRM</span>
            </a>
        </li>
        @endcan

        @can('manage_enquiries')
        <li>
            <a href="{{ url('/admin/enquiries') }}" class="{{ request()->is('admin/enquiries*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope-open-text"></i> <span class="menu-text">Enquiries</span>
            </a>
        </li>
        @endcan

        @can('manage_settings')
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
                    <a href="{{ url('/admin/settings/hero') }}" class="submenu-link {{ request()->is('admin/settings/hero*') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">Hero Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/settings/pages/home') }}" class="submenu-link {{ request()->is('admin/settings/pages/home*') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">Page Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/settings/smtp') }}" class="submenu-link {{ request()->is('admin/settings/smtp') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">SMTP Settings</span>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        @if(auth()->user()->can('manage_users') || auth()->user()->can('manage_roles'))
        <li class="has-submenu {{ request()->is('admin/roles*') || request()->is('admin/users*') ? 'open' : '' }}">
            <a href="javascript:void(0)" class="submenu-toggle {{ request()->is('admin/roles*') || request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> <span class="menu-text">User Management</span>
                <i class="fa-solid fa-chevron-down submenu-icon" style="margin-left: auto; transition: transform 0.3s; {{ request()->is('admin/roles*') || request()->is('admin/users*') ? 'transform: rotate(180deg);' : '' }}"></i>
            </a>
            <ul class="submenu" style="{{ request()->is('admin/roles*') || request()->is('admin/users*') ? 'display: block;' : 'display: none;' }} list-style: none; padding: 0; margin: 0;">
                @can('manage_users')
                <li>
                    <a href="{{ url('/admin/users') }}" class="submenu-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">Users</span>
                    </a>
                </li>
                @endcan
                @can('manage_roles')
                <li>
                    <a href="{{ url('/admin/roles') }}" class="submenu-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle submenu-dot"></i> <span class="menu-text">Roles</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
    </ul>

    <div class="sidebar-illustration" style="margin-top: auto; position: relative; pointer-events: none;">
        <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" class="sidebar-svg">
          <circle cx="140" cy="75" r="14" fill="#FF8E53" opacity="0.75" />
          <polygon points="40,120 100,50 160,120" fill="#043237" />
          <polygon points="120,120 190,60 260,120" fill="#074449" />
          <polygon points="80,120 145,40 210,120" fill="#053b40" />
          <rect x="0" y="112" width="280" height="8" fill="#032124" />
          <line x1="20" y1="114" x2="260" y2="114" stroke="#08565d" stroke-width="1" />
          <line x1="50" y1="117" x2="230" y2="117" stroke="#0a676f" stroke-width="1" />
          <g transform="translate(100, 103)">
            <path d="M 0 0 L 16 0 L 12 4 L 4 4 Z" fill="#00B8A9" />
            <line x1="8" y1="0" x2="8" y2="-10" stroke="#00B8A9" stroke-width="1.2" />
            <polygon points="8,-10 8,-2 13,-2" fill="#00E5FF" opacity="0.8" />
            <polygon points="7,-10 7,-3 3,-3" fill="#00E5FF" opacity="0.8" />
          </g>
          <g transform="translate(15, 120)">
            <path d="M 15 0 Q 18 -25 25 -45 Q 26 -45 23 -45 Q 16 -25 13 0 Z" fill="#032124" />
            <path d="M 25 -45 Q 10 -40 2 -32 Q 10 -35 25 -45" fill="#032124" />
            <path d="M 25 -45 Q 15 -55 8 -53 Q 18 -48 25 -45" fill="#032124" />
            <path d="M 25 -45 Q 28 -60 38 -55 Q 32 -48 25 -45" fill="#032124" />
            <path d="M 25 -45 Q 40 -45 42 -35 Q 35 -40 25 -45" fill="#032124" />
            <path d="M 25 -45 Q 35 -30 38 -20 Q 30 -30 25 -45" fill="#032124" />
          </g>
          <g transform="translate(240, 120)">
            <path d="M 10 0 Q 8 -15 3 -28 Q 2 -28 4 -28 Q 9 -15 11 0 Z" fill="#032124" opacity="0.8" />
            <path d="M 3 -28 Q -5 -25 -10 -20 Q -5 -22 3 -28" fill="#032124" opacity="0.8" />
            <path d="M 3 -28 Q 0 -35 -5 -33 Q 0 -30 3 -28" fill="#032124" opacity="0.8" />
            <path d="M 3 -28 Q 5 -38 12 -35 Q 8 -30 3 -28" fill="#032124" opacity="0.8" />
          </g>
        </svg>
    </div>
</div>