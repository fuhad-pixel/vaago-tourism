<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>{{ $company_setting->company_name ?? 'Pacific' }} - Travel Agency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    @if(isset($company_setting) && $company_setting->favicon_path)
        <link rel="icon" href="{{ asset($company_setting->favicon_path) }}" type="image/x-icon">
    @endif
    @include('partials.styles')
    <!-- Custom Toast CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/toast.css') }}?v={{ time() }}">
    <style>
        /* Global Search Typeahead Styles */
        .search-suggestions {
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            background: #1e1e1e; /* Dark background matching the theme overlay */
            border: 2px solid #00656c; /* Theme teal border matching the 2px input border */
            border-top: none;
            border-radius: 0 0 35px 35px; /* Rounded bottom to match the input curvature */
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            text-align: left;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            margin-top: -2px; /* Overlap 2px border for perfect cohesion */
        }
        .popup-search-box form input {
            transition: border-radius 0.25s ease !important;
        }
        .popup-search-box form input.has-suggestions {
            border-radius: 35px 35px 0 0 !important;
        }
        .search-suggestions::-webkit-scrollbar {
            width: 6px;
        }
        .search-suggestions::-webkit-scrollbar-thumb {
            background-color: #00656c;
            border-radius: 10px;
        }
        .suggestion-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .suggestion-item:last-child {
            border-bottom: none;
        }
        .suggestion-item:hover {
            background: rgba(0, 101, 108, 0.1); /* Subtle teal hover */
            color: #00656c;
        }
        .suggestion-icon {
            margin-right: 15px;
            font-size: 1.2rem;
            color: #00656c;
            width: 25px;
            text-align: center;
        }
        .suggestion-text {
            font-size: 1.1rem;
            font-weight: 500;
            flex-grow: 1;
        }
        .suggestion-type {
            font-size: 0.8rem;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .suggestion-item:hover .suggestion-type {
            color: #00656c;
        }
    </style>
    @if(isset($gtm_head) && !empty(trim($gtm_head)))
        {!! $gtm_head !!}
    @endif
</head>
<body class="vs-body">
    <!-- Toast Container -->
    <div id="toast-container"></div>
    @if(isset($gtm_body) && !empty(trim($gtm_body)))
        {!! $gtm_body !!}
    @endif

    <!-- Preloader -->
    <div class="preloader">
      <button class="vs-btn preloaderCls">Cancel Preloader</button>
      <div class="preloader-inner">
        @if(isset($company_setting) && $company_setting->logo_path)
          <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'logo' }}" style="height: 60px;" />
        @else
          <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" />
        @endif
        <span class="loader"></span>
      </div>
    </div>

    <!-- Mobile Menu Wrapper -->
    <div class="vs-menu-wrapper">
      <div class="vs-menu-area text-center">
        <div class="mobile-logo">
          <a href="{{ url('/') }}">
            @if(isset($company_setting) && $company_setting->logo_path)
              <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'logo' }}" style="height: 50px; max-height: 50px; width: auto; object-fit: contain;" />
            @else
              <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="logo" />
            @endif
          </a>
          <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
        </div>
        <div class="vs-mobile-menu">
          <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/about') }}">About Us</a></li>
            <li><a href="{{ url('/destination') }}">Destinations</a></li>
            <li><a href="{{ url('/tours') }}">Tours</a></li>
            <li><a href="{{ url('/blog') }}">Blog</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Popup Search Box -->
    <div class="popup-search-box">
      <button class="searchClose"><i class="fal fa-times"></i></button>
      <form action="{{ url('tours') }}" method="GET" style="position: relative;">
        <input type="text" name="search" id="global-search-input" autocomplete="off" class="border-theme" placeholder="What are you looking for?" />
        <button type="submit"><i class="fal fa-search"></i></button>
        <div id="search-suggestions-container" class="search-suggestions" style="display: none;"></div>
      </form>
    </div>

    <!-- Sticky Navbar & Header Area -->
    @include('partials.header')

    <!-- Main Section Wrapper -->
    @yield('content')

    <!-- Footer Area -->
    @include('partials.footer')

    <!-- Scroll to Top Button -->
    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

    @include('partials.scripts')
    <!-- Custom Toast JS -->
    <script src="{{ asset('assets/js/admin/toast.js') }}?v={{ time() }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                showToast('success', 'Success', "{{ session('success') }}");
            @endif
            @if(session('error'))
                showToast('error', 'Error', "{{ session('error') }}");
            @endif
            @if($errors->any())
                showToast('error', 'Validation Error', "Please check the form for errors.");
            @endif
        });
    </script>
    @yield('scripts')
</body>
</html>
