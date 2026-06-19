@extends('layouts.app')

@section('content')
      <!--================= Breadcrumb Area start =================-->
      <section
        class="vs-breadcrumb"
        data-bg-src="{{ asset('assets/img/bg/breadcrumb-bg.png') }}"
      >
        <img
          src="{{ asset('assets/img/icons/cloud.png') }}"
          alt="vs-breadcrumb-icon"
          class="vs-breadcrumb-icon-1 animate-parachute"
        />
        <img
          src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
          alt="vs-breadcrumb-icon"
          class="vs-breadcrumb-icon-2 animate-parachute"
        />
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Premium Hotels</h1>
              </div>
              <div class="breadcrumb-menu">
                <ul class="custom-ul">
                  <li>
                    <a href="{{ url('/') }}">Home</a>
                  </li>
                  <li>Hotels</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Hotels Section start =================-->
      <section class="vs-tour-package style-2 space">
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span class="sec-subtitle text-capitalize">Luxury Stays</span>
                <h2 class="sec-title">Explore Premium Hotels</h2>
              </div>
            </div>
          </div>
          <div class="row g-4">
            @php
              $mockHotels = [
                ['name' => 'Manila Resort & Spa', 'location' => 'Manila, Philippines', 'price' => 200, 'img' => 'assets/img/tour-packages/tour-package-3-1.png', 'rating' => 5, 'duration' => 'Per Night'],
                ['name' => 'Grand Palace Hotel', 'location' => 'Bangkok, Thailand', 'price' => 250, 'img' => 'assets/img/tour-packages/tour-package-3-2.png', 'rating' => 5, 'duration' => 'Per Night'],
                ['name' => 'Ocean View Villa', 'location' => 'Maldives', 'price' => 450, 'img' => 'assets/img/tour-packages/tour-package-3-3.png', 'rating' => 5, 'duration' => 'Per Night'],
                ['name' => 'Himalayan Retreat', 'location' => 'Pokhara, Nepal', 'price' => 180, 'img' => 'assets/img/tour-packages/tour-package-3-4.png', 'rating' => 4, 'duration' => 'Per Night'],
                ['name' => 'Swiss Alps Cabin', 'location' => 'Zermatt, Switzerland', 'price' => 380, 'img' => 'assets/img/tour-packages/tour-package-3-5.png', 'rating' => 5, 'duration' => 'Per Night'],
                ['name' => 'Desert Oasis Resort', 'location' => 'Dubai, UAE', 'price' => 500, 'img' => 'assets/img/tour-packages/tour-package-3-6.png', 'rating' => 5, 'duration' => 'Per Night'],
              ];
            @endphp

            @foreach($mockHotels as $hotel)
              <div class="col-md-6 col-xl-4">
                <div class="tour-package-box style-3 bg-white-color">
                  <div class="tour-package-thumb">
                    <img
                      src="{{ asset($hotel['img']) }}"
                      alt="hotel"
                      class="w-100"
                      style="height: 250px; object-fit: cover;"
                    />
                  </div>
                  <div class="tour-package-content">
                    <div class="location">
                      <i class="fa-sharp fa-light fa-location-dot"></i>
                      <span>{{ $hotel['location'] }}</span>
                    </div>
                    <h5 class="title line-clamp-2">
                      <a href="{{ url('contact') }}">{{ $hotel['name'] }}</a>
                    </h5>
                    
                    <div class="rating-stars mb-3 text-warning">
                      @for($i = 0; $i < $hotel['rating']; $i++)
                        <i class="fa-solid fa-star"></i>
                      @endfor
                    </div>

                    <div class="tour-package-footer">
                      <div class="tour-duration">
                        <i class="fa-regular fa-clock"></i>
                        <span>{{ $hotel['duration'] }}</span>
                      </div>
                      <div class="pricing-info fw-medium">
                        From
                        <h5 class="new-price">${{ $hotel['price'] }}</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </section>
      <!--================= Hotels Section end =================-->
@endsection
