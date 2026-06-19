@extends('layouts.app')

@section('content')
      <!--================= Breadcrumb Area start =================-->
      <section
        class="vs-breadcrumb"
        data-bg-src="{{ isset($hero_setting) && $hero_setting->image_path ? asset($hero_setting->image_path) : asset('assets/img/bg/breadcrumb-bg.png') }}"
        style="background-image: url('{{ isset($hero_setting) && $hero_setting->image_path ? asset($hero_setting->image_path) : asset('assets/img/bg/breadcrumb-bg.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;"
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
                <h1 class="breadcrumb-title">{{ isset($hero_setting) && $hero_setting->title ? $hero_setting->title : 'Explore Destinations' }}</h1>
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
                  <li>Destinations</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Destination Area Start =================-->
      <section class="vs-destination space bg-theme-07">
        <div class="container">
          <div class="row justify-content-center text-center">
            <div class="col-xl-8 col-lg-10 col-md-12 mb-5">
              <div class="section-title">
                <span class="sub-title text-theme-color">Where to go?</span>
                <h2 class="title h2">Popular Destinations</h2>
                <p class="text-muted mt-2">Discover your next adventure in one of our handpicked destination spots.</p>
              </div>
            </div>
          </div>

          <div class="row gx-3 gy-3">
            @if($destinations->count() > 0)
              @foreach($destinations as $index => $destination)
                @php
                  // Alternate sizes dynamically to create the premium template layout: 6, 3, 3, 3, 6, 3...
                  $colClass = 'col-md-6 col-lg-3';
                  if (($index % 6) == 0 || ($index % 6) == 4) {
                      $colClass = 'col-md-6 col-lg-6';
                  }
                @endphp
                <div class="{{ $colClass }}">
                  <div class="destination-box-2 card-hover-effect" style="position: relative; overflow: hidden; border-radius: 20px; height: 350px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); cursor: pointer;" onclick="window.location='{{ url('tours?destination_id=' . encrypt($destination->id)) }}'">
                    <figure class="destination-thumb h-100 w-100 m-0" style="transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);">
                      <img
                        src="{{ $destination->image ? asset($destination->image) : asset('assets/img/destination/destinations-thumb-2-1.png') }}"
                        alt="{{ $destination->name }}"
                        class="w-100 h-100"
                        style="object-fit: cover;"
                      />
                    </figure>
                    <!-- Dark Gradient Overlay -->
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.2) 60%, rgba(0, 0, 0, 0) 100%); z-index: 2; pointer-events: none;"></div>
                    
                    <div class="destination-content" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 25px 30px; z-index: 3;">
                      <h5 class="title mb-1 text-white text-uppercase" style="font-size: 20px; font-weight: 800; letter-spacing: 0.5px;">
                        <a href="{{ url('tours?destination_id=' . encrypt($destination->id)) }}" class="text-white hover-theme" style="text-decoration: none;" onclick="event.stopPropagation();">{{ $destination->name }}</a>
                      </h5>
                      <span class="info text-white-50 fw-semibold" style="font-size: 14px; text-transform: uppercase;">
                        <i class="fa-solid fa-plane-departure text-theme-color me-2"></i>{{ $destination->tours_count }} {{ \Illuminate\Support\Str::plural('Trip', $destination->tours_count) }}
                      </span>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="col-12 text-center py-5">
                <h3 class="text-muted">No Destinations Found</h3>
              </div>
            @endif
          </div>
        </div>
      </section>
      <!--================= Destination Area End =================-->

      <style>
        /* Card hover animation zoom */
        .card-hover-effect:hover .destination-thumb {
          transform: scale(1.08);
        }
        .card-hover-effect {
          transition: all 0.3s ease;
        }
        .card-hover-effect:hover {
          box-shadow: 0 15px 35px rgba(0, 101, 108, 0.15) !important;
        }
      </style>
@endsection
