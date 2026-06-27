@extends('layouts.app')

@section('content')
      <style>
        /* Premium Breadcrumb override to prevent overlapping with transparent sticky headers */
        .vs-breadcrumb {
          padding: 240px 0 160px !important;
        }
        @media (max-width: 991px) {
          .vs-breadcrumb {
            padding: 180px 0 250px !important;
          }
        }
        @media (max-width: 767px) {
          .vs-breadcrumb {
            padding: 140px 0 220px !important;
          }
        }

        /* Custom Premium Filter Bar */
        .premium-filter-container {
          margin-top: -80px;
          position: relative;
          z-index: 100;
        }
        
        .premium-filter-card {
          background: #ffffff;
          border-radius: 24px;
          padding: 32px;
          box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08), 0 5px 15px rgba(15, 23, 42, 0.04);
          border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .premium-filter-grid {
          display: grid;
          grid-template-columns: 1.3fr 1fr 1fr auto;
          gap: 20px;
          align-items: flex-end;
        }

        @media (max-width: 1200px) {
          .premium-filter-grid {
            grid-template-columns: 1fr 1fr;
          }
          .filter-btn-item {
            grid-column: span 2;
          }
        }

        @media (max-width: 768px) {
          .premium-filter-grid {
            grid-template-columns: 1fr;
          }
          .filter-btn-item {
            grid-column: span 1;
          }
          .premium-filter-card {
            padding: 24px;
          }
        }

        @media (max-width: 991px) {
          .premium-filter-container {
            margin-top: -60px !important;
          }
          .premium-filter-card {
            margin-top: 0px !important;
          }
        }

        .filter-group {
          display: flex;
          flex-direction: column;
          gap: 8px;
        }

        .filter-lbl {
          font-size: 12px;
          font-weight: 700;
          color: #475569;
          text-transform: uppercase;
          letter-spacing: 0.8px;
          display: flex;
          align-items: center;
          gap: 8px;
          margin-bottom: 0;
        }

        .filter-lbl i {
          color: #f15d30;
          font-size: 14px;
        }

        .filter-ctrl {
          width: 100%;
          height: 52px;
          background-color: #f8fafc;
          border: 1px solid #e2e8f0;
          border-radius: 12px;
          padding: 0 16px;
          font-size: 14px;
          font-weight: 600;
          color: #1e293b;
          outline: none;
          transition: all 0.3s ease;
          appearance: none;
          -webkit-appearance: none;
        }

        .filter-ctrl:focus {
          border-color: #f15d30;
          background-color: #ffffff;
          box-shadow: 0 0 0 4px rgba(241, 93, 48, 0.1);
        }

        .select-ctrl-wrapper {
          position: relative;
          width: 100%;
        }

        .select-ctrl-wrapper select {
          padding-right: 40px;
          background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
          background-repeat: no-repeat;
          background-position: right 16px center;
          background-size: 14px;
          cursor: pointer;
        }

        .premium-search-btn {
          height: 52px;
          padding: 0 35px;
          background: linear-gradient(135deg, #f15d30 0%, #d94014 100%);
          color: #ffffff;
          border: none;
          border-radius: 12px;
          font-size: 15px;
          font-weight: 700;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 10px;
          cursor: pointer;
          transition: all 0.3s ease;
          box-shadow: 0 4px 14px rgba(241, 93, 48, 0.3);
          min-width: 140px;
          width: 100%;
        }

        .premium-search-btn:hover {
          transform: translateY(-2px);
          box-shadow: 0 6px 20px rgba(241, 93, 48, 0.4);
          background: linear-gradient(135deg, #ff7145 0%, #f15d30 100%);
        }

        .premium-search-btn:active {
          transform: translateY(0);
        }

        /* Premium Tour Card Styles */
        .premium-card {
          background: #ffffff;
          border-radius: 24px;
          border: 1px solid #f1f5f9;
          overflow: hidden;
          height: 100%;
          display: flex;
          flex-direction: column;
          box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.02), 0 2px 4px -1px rgba(15, 23, 42, 0.01);
          transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
          position: relative;
        }

        .premium-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 10px 10px -5px rgba(15, 23, 42, 0.04);
          border-color: #e2e8f0;
        }

        .premium-card-img-wrapper {
          position: relative;
          overflow: hidden;
          aspect-ratio: 16 / 10.5;
        }

        .premium-card-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .premium-card:hover .premium-card-img {
          transform: scale(1.06);
        }

        .premium-card-img-wrapper::after {
          content: '';
          position: absolute;
          inset: 0;
          background: linear-gradient(to top, rgba(15, 23, 42, 0.6) 0%, rgba(15, 23, 42, 0.1) 40%, transparent 100%);
          pointer-events: none;
        }

        .premium-card-dest-badge {
          position: absolute;
          bottom: 16px;
          left: 16px;
          background: rgba(15, 23, 42, 0.65);
          backdrop-filter: blur(8px);
          -webkit-backdrop-filter: blur(8px);
          color: #ffffff;
          font-size: 12px;
          font-weight: 700;
          padding: 6px 14px;
          border-radius: 9999px;
          display: flex;
          align-items: center;
          gap: 6px;
          z-index: 5;
          border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .premium-card-dest-badge i {
          color: #f15d30;
        }

        .premium-card-discount-badge {
          position: absolute;
          top: 16px;
          right: 16px;
          background: #ef4444;
          color: #ffffff;
          font-size: 11px;
          font-weight: 800;
          padding: 6px 14px;
          border-radius: 9999px;
          box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3);
          z-index: 5;
          text-transform: uppercase;
          letter-spacing: 0.5px;
        }

        .premium-card-body {
          padding: 24px;
          display: flex;
          flex-direction: column;
          flex-grow: 1;
        }

        .premium-card-cat {
          font-size: 11px;
          font-weight: 800;
          color: #f15d30;
          text-transform: uppercase;
          letter-spacing: 1px;
          margin-bottom: 8px;
        }

        .premium-card-title {
          font-family: var(--body-font), sans-serif !important;
          font-size: 18px !important;
          font-weight: 600 !important;
          letter-spacing: -0.2px !important;
          color: #0f172a;
          line-height: 1.4;
          margin-bottom: 16px;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
          min-height: 50px;
        }

        .premium-card-title a {
          font-family: var(--body-font), sans-serif !important;
          font-weight: 600 !important;
          color: inherit;
          text-decoration: none;
          transition: color 0.3s ease;
        }

        .premium-card-title a:hover {
          color: #f15d30;
        }

        .premium-card-meta {
          display: flex;
          align-items: center;
          gap: 20px;
          margin-bottom: 20px;
          padding-bottom: 16px;
          border-bottom: 1px solid #f1f5f9;
        }

        .premium-meta-item {
          display: flex;
          align-items: center;
          gap: 8px;
          color: #64748b;
          font-size: 13px;
          font-weight: 600;
        }

        .premium-meta-item i {
          color: #94a3b8;
          font-size: 14px;
        }

        .premium-card-footer {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-top: auto;
        }

        .premium-card-price-lbl {
          font-size: 11px;
          font-weight: 700;
          color: #94a3b8;
          text-transform: uppercase;
          letter-spacing: 0.5px;
          display: block;
          margin-bottom: 2px;
        }

        .premium-card-price-del {
          font-size: 13px;
          color: #94a3b8;
          text-decoration: line-through;
          margin-right: 6px;
        }

        .premium-card-price-amount {
          font-size: 20px;
          font-weight: 800;
          color: #f15d30;
        }

        .premium-card-btn {
          width: 44px;
          height: 44px;
          border-radius: 50%;
          background: #f8fafc;
          border: 1px solid #e2e8f0;
          color: #0f172a;
          display: flex;
          align-items: center;
          justify-content: center;
          transition: all 0.3s ease;
          text-decoration: none;
        }

        .premium-card:hover .premium-card-btn {
          background: #f15d30;
          border-color: #f15d30;
          color: #ffffff;
          box-shadow: 0 4px 10px rgba(241, 93, 48, 0.25);
        }

        .premium-card-btn i {
          font-size: 14px;
          transition: transform 0.3s ease;
        }

        .premium-card-btn:hover i {
          transform: translateX(2px);
        }
      </style>

      <!--================= Breadcrumb Area start =================-->
      <section
        class="vs-breadcrumb"
        data-bg-src="{{ isset($hero_setting) && $hero_setting->image_path ? asset($hero_setting->image_path) : asset('assets/img/bg/tours-breadcrumb-bg.png') }}"
        style="background-image: url('{{ isset($hero_setting) && $hero_setting->image_path ? asset($hero_setting->image_path) : asset('assets/img/bg/tours-breadcrumb-bg.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;"
      >
        <!-- Overlay for better text readability -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.45); z-index: 1;"></div>

        <img
          src="{{ asset('assets/img/icons/cloud.png') }}"
          alt="vs-breadcrumb-icon"
          class="vs-breadcrumb-icon-1 animate-parachute"
          style="z-index: 2;"
        />
        <img
          src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
          alt="vs-breadcrumb-icon"
          class="vs-breadcrumb-icon-2 animate-parachute"
          style="z-index: 2;"
        />
        <div class="container" style="position: relative; z-index: 2;">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">{{ isset($hero_setting) && $hero_setting->title ? $hero_setting->title : 'Explore Popular Trips' }}</h1>
                @if(isset($hero_setting) && $hero_setting->description)
                  <p class="breadcrumb-text" style="color: rgba(255, 255, 255, 0.9); font-size: 16px; margin-top: 10px; max-width: 600px; margin-left: auto; margin-right: auto; font-weight: 500;">
                    {{ $hero_setting->description }}
                  </p>
                @endif
              </div>
              <div class="breadcrumb-menu">
                <ul class="custom-ul">
                  <li>
                    <a href="{{ url('/') }}">Home</a>
                  </li>
                  <li>Tours</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Premium Search Section =================-->
      <section class="premium-filter-container bg-theme-07">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="premium-filter-card">
                <form action="{{ url('tours') }}" method="GET">
                  <div class="premium-filter-grid">
                    <!-- Text Keyword Search -->
                    <div class="filter-group">
                      <label for="search-input" class="filter-lbl">
                        <i class="fa-solid fa-magnifying-glass"></i> Search Tour
                      </label>
                      <input 
                        type="text" 
                        id="search-input" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="e.g. Backwater, Hill..." 
                        class="filter-ctrl"
                      />
                    </div>
                    
                    <!-- Destination Field -->
                    <div class="filter-group">
                      <label for="premium-destination-select" class="filter-lbl">
                        <i class="fa-sharp fa-light fa-location-dot"></i> Destinations
                      </label>
                      <div class="select-ctrl-wrapper">
                        <select id="premium-destination-select" name="destination_id" class="filter-ctrl">
                          <option value="">Select Destination</option>
                          @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>{{ $dest->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <!-- Category Field -->
                    <div class="filter-group">
                      <label for="premium-category-dropdown" class="filter-lbl">
                        <i class="fa-regular fa-grid-2"></i> Category
                      </label>
                      <div class="select-ctrl-wrapper">
                        <select id="premium-category-dropdown" name="category_id" class="filter-ctrl">
                          <option value="">Select Category</option>
                          @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <!-- Price Field -->
                    {{-- <div class="filter-group">
                      <label for="premium-price-dropdown" class="filter-lbl">
                        <i class="fa-regular fa-dollar-sign"></i> Price Limit
                      </label>
                      <div class="select-ctrl-wrapper">
                        <select id="premium-price-dropdown" name="price" class="filter-ctrl">
                          <option value="">No Limit</option>
                          <option value="500" {{ request('price') == '500' ? 'selected' : '' }}>Up to $500</option>
                          <option value="1000" {{ request('price') == '1000' ? 'selected' : '' }}>Up to $1,000</option>
                          <option value="2000" {{ request('price') == '2000' ? 'selected' : '' }}>Up to $2,000</option>
                          <option value="5000" {{ request('price') == '5000' ? 'selected' : '' }}>Up to $5,000</option>
                          <option value="10000" {{ request('price') == '10000' ? 'selected' : '' }}>Up to $10,000</option>
                        </select>
                      </div>
                    </div> --}}

                    <!-- Submit Button -->
                    <div class="filter-btn-item">
                      <button type="submit" class="premium-search-btn">
                        <span>Search</span>
                        <i class="fa-solid fa-arrow-right"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!--================= Tour Package Area start =================-->
      <section class="space-bottom bg-theme-07 pt-5">
        <div class="container">
          <div class="row g-4">
            @if($tours->count() > 0)
              @foreach($tours as $tour)
                <div class="col-md-6 col-xl-4">
                  <div class="premium-card">
                    <!-- Image Area -->
                    <div class="premium-card-img-wrapper">
                      <a href="{{ url('tour/' . $tour->slug) }}">
                        <img
                          src="{{ $tour->images->count() > 0 ? asset($tour->images->first()->image_path) : asset('assets/img/tour-packages/tour-package-3-1.png') }}"
                          alt="{{ $tour->name }}"
                          class="premium-card-img"
                        />
                      </a>
                      {{-- @if($tour->discount_price)
                        @php
                          $discountPercent = round((($tour->original_price - $tour->discount_price) / $tour->original_price) * 100);
                        @endphp
                        <span class="premium-card-discount-badge">{{ $discountPercent }}% OFF</span>
                      @endif --}}

                      <div class="premium-card-dest-badge">
                        <i class="fa-sharp fa-solid fa-location-dot"></i>
                        <span>{{ $tour->destinations->pluck('name')->implode(', ') }}</span>
                      </div>
                    </div>

                    <!-- Card Body -->
                    <div class="premium-card-body">
                      <!-- Category -->
                      <span class="premium-card-cat">{{ $tour->category->name ?? 'Special Tour' }}</span>

                      <!-- Tour Title -->
                      <h4 class="premium-card-title">
                        <a href="{{ url('tour/' . $tour->slug) }}">{{ $tour->name }}</a>
                      </h4>

                      <!-- Meta Details Row 1 -->
                      <div class="premium-card-meta">
                        <div class="premium-meta-item">
                          <i class="fa-regular fa-clock"></i>
                          <span>
                            @if($tour->duration_days > 0)
                              {{ $tour->duration_days }} {{ \Illuminate\Support\Str::plural('Day', $tour->duration_days) }}
                            @endif
                            @if($tour->duration_nights > 0)
                              {{ $tour->duration_days > 0 ? '/' : '' }} {{ $tour->duration_nights }} {{ \Illuminate\Support\Str::plural('Night', $tour->duration_nights) }}
                            @endif
                          </span>
                        </div>
                        {{-- <div class="ms-auto text-end">
                          <span class="premium-card-price-lbl">From</span>
                          <div class="d-flex align-items-center justify-content-end">
                            @if($tour->discount_price)
                              <span class="premium-card-price-del">${{ number_format($tour->original_price, 0) }}</span>
                              <span class="premium-card-price-amount">${{ number_format($tour->discount_price, 0) }}</span>
                            @else
                              <span class="premium-card-price-amount">${{ number_format($tour->original_price, 0) }}</span>
                            @endif
                          </div>
                        </div> --}}
                      </div>

                      <!-- Meta Details Row 2 -->
                      <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 13px; font-weight: 600;">
                        <span class="guests"><i class="fa-solid fa-users text-theme-color me-2"></i>
                          @if($tour->min_guests && $tour->max_guests)
                            {{ $tour->min_guests }}-{{ $tour->max_guests }} Guests
                          @elseif($tour->min_guests)
                            Min {{ $tour->min_guests }}
                          @elseif($tour->max_guests)
                            Max {{ $tour->max_guests }}
                          @else
                            No Limit
                          @endif
                        </span>
                        <span class="code"><i class="fa-solid fa-barcode text-theme-color me-2"></i>{{ $tour->tour_code }}</span>
                      </div>

                      <!-- Tour Footer CTA -->
                      <div class="mt-4 pt-3 border-top d-flex align-items-center justify-content-between">
                        <span class="text-muted small fw-semibold">Best Price Guaranteed</span>
                        <a href="{{ url('tour/' . $tour->slug) }}" class="premium-card-btn">
                          <i class="fa-solid fa-arrow-right"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="col-12 text-center py-5 px-3 bg-white border rounded-4 shadow-sm" style="margin-top: 30px; border-radius: 20px;">
                <div class="py-4">
                  <span class="fa-solid fa-magnifying-glass text-muted mb-3" style="font-size: 48px; color: #f15d30 !important;"></span>
                  <h3 class="mb-2" style="font-weight: 700; color: #111827;">No Tours Found</h3>
                  <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto; font-size: 16px;">We couldn't find any tours matching your filter criteria. Try adjusting your search query, destination, category, or price limit.</p>
                  <a href="{{ url('tours') }}" class="vs-btn style4" style="display: inline-block; width: auto; padding: 12px 30px; border-radius: 10px;">Clear Filters</a>
                </div>
              </div>
            @endif
          </div>

          <!-- Laravel Custom Pagination -->
          @if ($tours->hasPages())
            <div class="row mt-5">
              <div class="col-12 d-flex justify-content-center">
                <div class="vs-pagination">
                  <ul>
                    @if ($tours->onFirstPage())
                      <li class="disabled"><span><i class="fa-solid fa-angles-left"></i></span></li>
                    @else
                      <li><a href="{{ $tours->previousPageUrl() }}"><i class="fa-solid fa-angles-left"></i></a></li>
                    @endif

                    @for ($i = 1; $i <= $tours->lastPage(); $i++)
                      @if ($i == $tours->currentPage())
                        <li><span class="active">{{ $i }}</span></li>
                      @else
                        <li><a href="{{ $tours->url($i) }}">{{ $i }}</a></li>
                      @endif
                    @endfor

                    @if ($tours->hasMorePages())
                      <li><a href="{{ $tours->nextPageUrl() }}"><i class="fa-solid fa-angles-right"></i></a></li>
                    @else
                      <li class="disabled"><span><i class="fa-solid fa-angles-right"></i></span></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          @endif

        </div>
      </section>
      <!--================= Tour Package Area end =================-->
@endsection
