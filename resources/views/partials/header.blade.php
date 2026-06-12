<style>
    .ftco-navbar-light {
        z-index: 1000 !important;
    }
    @media (max-width: 991.98px) {
        .ftco-navbar-light {
            background: rgba(255, 255, 255, 0.75) !important;
            backdrop-filter: blur(15px) !important;
            -webkit-backdrop-filter: blur(15px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        }
        .ftco-navbar-light.scrolled {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(15px) !important;
            -webkit-backdrop-filter: blur(15px) !important;
        }
        .ftco-navbar-light .navbar-brand {
            color: #111827 !important;
        }
        .ftco-navbar-light .navbar-brand span {
            color: #f15d30 !important;
        }
        .ftco-navbar-light .navbar-toggler {
            color: #111827 !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            padding: 8px !important;
        }
        .ftco-navbar-light .navbar-nav > .nav-item > .nav-link {
            color: #1e293b !important;
            font-weight: 600 !important;
            padding: 12px 16px !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        }
        .ftco-navbar-light .navbar-nav > .nav-item:last-child > .nav-link {
            border-bottom: none !important;
        }
        .ftco-navbar-light .navbar-nav > .nav-item.active > .nav-link {
            color: #f15d30 !important;
        }
        .ftco-navbar-light .navbar-collapse {
            background: rgba(255, 255, 255, 0.85) !important;
            margin-top: 10px;
            border-radius: 12px;
            padding: 10px 15px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
        }
    }
</style>

	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
				@if(isset($company_setting) && $company_setting->logo_path)
					<img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'Pacific' }}" style="height: 50px; max-height: 50px; width: auto; object-fit: contain;">
				@else
					{{ $company_setting->company_name ?? 'Pacific' }}<span>Travel Agency</span>
				@endif
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="fa fa-bars" style="font-size: 22px;"></span>
			</button>

			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item {{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
					<li class="nav-item {{ Request::is('about') ? 'active' : '' }}"><a href="{{ url('about') }}" class="nav-link">About</a></li>
					<li class="nav-item {{ Request::is('destination') ? 'active' : '' }}"><a href="{{ url('destination') }}" class="nav-link">Destination</a></li>
					<li class="nav-item {{ Request::is('blog') || Request::is('blog-single') ? 'active' : '' }}"><a href="{{ url('blog') }}" class="nav-link">Blog</a></li>
					<li class="nav-item {{ Request::is('contact') ? 'active' : '' }}"><a href="{{ url('contact') }}" class="nav-link">Contact</a></li>
				</ul>
			</div>
		</div>
	</nav>
