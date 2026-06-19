@extends('layouts.app')

@section('content')
      <!--================= Hero Area =================-->
      <section class="z-index-common hero-layout1 overflow-clip p-0" style="position: relative; min-height: 100vh;">
        <!-- Swiper Background and Text Slider -->
        <div class="swiper hero-swiper" style="width: 100%; height: 100vh;">
          <div class="swiper-wrapper">
            @if(isset($sliders) && $sliders->count() > 0)
              @foreach($sliders as $slider)
                <div class="swiper-slide" style="background-image: url('{{ asset($slider->image_path) }}'); background-size: cover; background-position: center; height: 100vh; display: flex; align-items: center; justify-content: center; position: relative;">
                  <!-- Dark overlay for text readability -->
                  <div class="hero-overlay-dark" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.45); z-index: 1;"></div>
                  
                  <div class="container-fluid p-xl-0" style="position: relative; z-index: 2; width: 100%;">
                    <div class="row justify-content-center">
                      <div class="col-xl-10 col-xxl-7">
                        <div class="hero-content text-center" style="margin-bottom: 120px;">
                          <img class="hero-sun-icon" src="{{ asset('assets/img/icons/hero-sun.png') }}" alt="icon" style="margin-bottom: 20px;" />
                          <div class="title-area text-center">
                            <span class="sec-subtitle text-white mb-0" style="font-size: 1.5rem; font-weight: 500; text-transform: uppercase; letter-spacing: 2px; display: block;">
                              {{ $slider->subtitle ?? 'about tripik' }}
                            </span>
                            <h1 class="sec-title text-white-color" style="font-size: 4rem; font-weight: 800; line-height: 1.1; margin-top: 15px;">
                              {!! nl2br(e($slider->title)) !!}
                            </h1>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <!-- Fallback Slide -->
              <div class="swiper-slide" style="background-image: url('{{ asset('assets/img/hero/hero-layout1-bg.png') }}'); background-size: cover; background-position: center; height: 100vh; display: flex; align-items: center; justify-content: center; position: relative;">
                <div class="hero-overlay-dark" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.45); z-index: 1;"></div>
                <div class="container-fluid p-xl-0" style="position: relative; z-index: 2; width: 100%;">
                  <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-7">
                      <div class="hero-content text-center" style="margin-bottom: 120px;">
                        <img class="hero-sun-icon" src="{{ asset('assets/img/icons/hero-sun.png') }}" alt="icon" style="margin-bottom: 20px;" />
                        <div class="title-area text-center">
                          <span class="sec-subtitle text-white mb-0">Welcome to Pacific</span>
                          <h1 class="sec-title text-white-color" style="font-size: 4rem; font-weight: 800; line-height: 1.1; margin-top: 15px;">Find your holiday <br class="d-none d-xxl-block" /> with us</h1>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
          
          <!-- Swiper Pagination -->
          <div class="swiper-pagination hero-swiper-pagination" style="bottom: 180px; z-index: 5;"></div>
        </div>
        
        <!-- Floating Static Search Box in Foreground -->
        <div class="hero-search-container" style="position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); z-index: 10; width: 100%; max-width: 1100px; padding: 0 20px; box-sizing: border-box;">
          <div class="search-box">
            <form action="{{ url('tours') }}" method="GET" class="align-items-center">
              <!-- Destination Field -->
              <div class="form-group ps-0">
                <label for="select-division" class="form-label d-flex align-items-center">
                  <i class="fa-sharp fa-light fa-location-dot me-2"></i>
                  Destinations
                </label>
                <select id="select-division" name="destination_id" class="form-select">
                  <option value="">Select Destination</option>
                  @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                  @endforeach
                </select>
              </div>
              <!-- Category Field -->
              <div class="form-group">
                <label for="category-dropdown" class="form-label d-flex align-items-center">
                  <i class="fa-regular fa-grid-2 me-2"></i> Category
                </label>
                <select id="category-dropdown" name="category_id" class="form-select">
                  <option value="">Select Category</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                  @endforeach
                </select>
              </div>
              <!-- Price Field -->
              <div class="form-group">
                <label for="price-dropdown" class="form-label d-flex align-items-center">
                  <i class="fa-regular fa-usd-circle me-2"></i> Price Limit
                </label>
                <select id="price-dropdown" name="price" class="form-select">
                  <option value="">No Limit</option>
                  <option value="500">Up to $500</option>
                  <option value="1000">Up to $1,000</option>
                  <option value="2000">Up to $2,000</option>
                  <option value="5000">Up to $5,000</option>
                  <option value="10000">Up to $10,000</option>
                </select>
              </div>
              <!-- Submit Button -->
              <div class="form-group pe-0">
                <button type="submit" class="vs-btn style4 w-100">
                  Search
                </button>
              </div>
            </form>
          </div>
        </div>
      </section>
      <!--================= Hero Area end =================-->

      <!--================= Destination Area start =================-->
      <section
        class="vs-destination-style1 bg-third-theme-12 overflow-hidden space"
        data-bg-src="{{ asset('assets/img/bg/destination.png') }}"
      >
        <img
          class="des-icon-1 animate-parachute"
          src="{{ asset('assets/img/icons/destination-icon-1.png') }}"
          alt="icon"
        />
        <img
          class="des-icon-2 animate-tree"
          src="{{ asset('assets/img/icons/destination-icon-2.png') }}"
          alt="icon"
        />
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span class="sec-subtitle fade-anim" data-direction="top"
                  >Top Destinations</span
                >
                <h2 class="sec-title move-anim">Discover Top Destinations</h2>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              @if($destinations->count() > 0)
                <div class="destination-box-wrapper">
                  @foreach($destinations->take(4) as $destination)
                    <div class="destination-box @if($loop->first) active @endif" style="cursor: pointer;" onclick="window.location='{{ url('tours?destination_id=' . encrypt($destination->id)) }}'">
                      <div class="destination-thumb">
                        <img
                          src="{{ asset($destination->image) }}"
                          alt="{{ $destination->name }}"
                          class="w-100"
                          style="height: 380px; object-fit: cover;"
                        />
                      </div>
                      <div class="destination-content">
                        <div class="info">
                          <h4 class="text-white text-capitalize">
                            <a href="{{ url('tours?destination_id=' . encrypt($destination->id)) }}" onclick="event.stopPropagation();">{{ $destination->name }}</a>
                          </h4>
                          <span class="text-theme-color d-block">{{ $destination->tours_count }} {{ Str::plural('Tour', $destination->tours_count) }}</span>
                        </div>
                        <a href="{{ url('tours?destination_id=' . encrypt($destination->id)) }}" class="icon bg-theme-color text-white-color" onclick="event.stopPropagation();">
                          <i class="fa-solid fa-location-dot"></i>
                        </a>
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <div class="text-center py-5" style="background: rgba(255,255,255,0.8); border-radius: 10px;">
                  <h4 class="text-muted mb-0"><i class="fa-solid fa-map-location-dot"></i> Destinations will be added soon.</h4>
                </div>
              @endif
            </div>
          </div>
        </div>
      </section>
      <!--================= Destination Area end =================-->

      <!--================= Tour Package Area start =================-->
      <section class="vs-tour-package space">
        <div class="container">
          <div class="row justify-content-between align-items-center">
            <div class="col-md-6 col-lg-6 col-xxl-5">
              <div class="title-area text-center text-md-start">
                <span class="sec-subtitle fade-anim" data-direction="bottom"
                  >Awesome Tours</span
                >
                <h2 class="sec-title fade-anim" data-direction="top">
                  Awesome Trips with us
                </h2>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xxl-5">
              <div
                class="swiper-arrow2 tour-packages-navigation justify-content-center justify-content-md-end"
              >
                <button class="tour-packages-next">
                  <svg
                    width="9"
                    height="18"
                    viewBox="0 0 9 18"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M8.08984 16.92L1.56984 10.4C0.799843 9.62996 0.799843 8.36996 1.56984 7.59996L8.08984 1.07996"
                      stroke="currentColor"
                      stroke-width="1.5"
                      stroke-miterlimit="10"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></path>
                  </svg>
                </button>
                <button class="tour-packages-prev btn-right">
                  <svg
                    width="9"
                    height="18"
                    viewBox="0 0 9 18"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M0.910156 16.92L7.43016 10.4C8.20016 9.62996 8.20016 8.36996 7.43016 7.59996L0.910156 1.07996"
                      stroke="currentColor"
                      stroke-width="1.5"
                      stroke-miterlimit="10"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="col-12 mt-30 mt-md-0 fade-anim" data-direction="right">
              @if($tours->count() > 0)
                <div class="swiper tour-package-slider">
                  <div class="swiper-wrapper">
                    @foreach($tours as $tour)
                      <div class="swiper-slide">
                        <div class="tour-package-box bg-white-color">
                          <div class="tour-package-thumb">
                            <img
                              src="{{ $tour->images->count() > 0 ? asset($tour->images->first()->image_path) : asset('assets/img/tour-packages/tour-package-1-1.png') }}"
                              alt="{{ $tour->name }}"
                              class="w-100"
                              style="height: 250px; object-fit: cover;"
                            />
                          </div>
                          <div class="tour-package-content">
                            <h5 class="title line-clamp-2">
                              <a href="{{ url('tour/' . $tour->slug) }}">{{ $tour->name }}</a>
                            </h5>
                            <div class="pricing-container">
                              <div class="package-info">
                                <span class="package-location">
                                  <i class="fa-sharp fa-thin fa-location-dot"></i>
                                  {{ $tour->destinations->pluck('name')->implode(', ') }}
                                </span>
                                @if($tour->duration_days > 0 || $tour->duration_nights > 0)
                                  <span class="package-time">
                                    <i class="fa-sharp fa-thin fa-clock"></i>
                                    @if($tour->duration_days > 0)
                                      {{ $tour->duration_days }} {{ Str::plural('Day', $tour->duration_days) }}
                                    @endif
                                    @if($tour->duration_nights > 0)
                                      {{ $tour->duration_days > 0 ? ' - ' : '' }}{{ $tour->duration_nights }} {{ Str::plural('Night', $tour->duration_nights) }}
                                    @endif
                                  </span>
                                @endif
                              </div>
                              <div class="price-info">
                                @if($tour->discount_price)
                                  @php
                                    $pct = round((($tour->original_price - $tour->discount_price) / $tour->original_price) * 100);
                                  @endphp
                                  @if($pct > 0)
                                    <span class="price-off text-white-color ff-poppins">{{ $pct }}% off</span>
                                  @endif
                                  <div class="price">
                                    <h6 class="fs-30 ff-rubik">${{ number_format($tour->discount_price, 0) }}</h6>
                                    <del class="fs-sm ff-rubik">${{ number_format($tour->original_price, 0) }}</del>
                                  </div>
                                @else
                                  <div class="price">
                                    <h6 class="fs-30 ff-rubik">${{ number_format($tour->original_price, 0) }}</h6>
                                  </div>
                                @endif
                              </div>
                            </div>
                            <a
                              href="{{ url('tour/' . $tour->slug) }}"
                              class="vs-btn style7 w-100"
                              >Book Now</a
                            >
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @else
                <div class="text-center py-5">
                  <h4 class="text-muted">No tours available at the moment.</h4>
                </div>
              @endif
            </div>
          </div>
        </div>
      </section>
      <!--================= Tour Package Area end =================-->

      <!--================= Testimonial Section Start =================-->
      @if($testimonials->count() > 0)
        <section
          class="testimonial position-relative space"
          data-bg-src="{{ asset('assets/img/bg/testimonial-bg.png') }}"
        >
          <img
            src="{{ asset('assets/img/icons/eiffel-tower-dark.png') }}"
            alt="testimonial-icon"
            class="testimonial-icon"
          />
          <div class="container">
            <div class="row">
              <div class="col-lg-auto mx-auto">
                <div class="title-area text-center">
                  <span class="sec-subtitle fade-anim" data-direction="bottom"
                    >Our Testimonials</span
                  >
                  <h2 class="sec-title fade-anim" data-direction="top">
                    What Customers Say About Us
                  </h2>
                </div>
              </div>
            </div>
            <div class="row fade-anim">
              <div class="col-xl-10 mx-auto">
                <div class="row g-4">
                  <div class="col-lg-5">
                    <div class="swiper testimonial-thumbnail-slider">
                      <div class="swiper-wrapper">
                        @foreach($testimonials as $testimony)
                          <div class="swiper-slide">
                            <div class="testimonial-thumbnail">
                              @if($testimony->client_dp)
                                <img
                                  src="{{ asset($testimony->client_dp) }}"
                                  alt="{{ $testimony->client_name }}"
                                />
                              @else
                                @php
                                  $words = explode(' ', $testimony->client_name);
                                  $initials = '';
                                  foreach ($words as $w) {
                                      $initials .= strtoupper(substr($w, 0, 1));
                                  }
                                  $initials = substr($initials, 0, 2);
                                @endphp
                                <div class="testimonial-avatar-placeholder">
                                  <span>{{ $initials }}</span>
                                </div>
                              @endif
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-7 d-lg-flex align-items-lg-center">
                    <!-- Swiper Content Slider -->
                    <div class="swiper testimonial-content-slider">
                      <div class="swiper-wrapper">
                        @foreach($testimonials as $testimony)
                          <div class="swiper-slide">
                            <div class="testimonial-content">
                              <i class="fa-solid fa-quote-left"></i>
                              <div class="rating">
                                <ul class="custom-ul">
                                  @for($i=1; $i<=5; $i++)
                                    <li><i class="fa-solid fa-star {{ $i <= $testimony->rating ? 'text-theme-color' : 'text-muted' }}"></i></li>
                                  @endfor
                                </ul>
                              </div>
                              <p class="revew">
                                “{{ $testimony->review }}”
                              </p>
                              <div class="author">
                                <h5 class="author-name">{{ $testimony->client_name }}</h5>
                                <span class="author-degi">{{ $testimony->designation }}</span>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                      <div class="swiper-pagination"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      @endif
      <!--================= Testimonial Section End =================-->

      <!--================= Services Area Start =================-->
      <div
        class="vs-services-style1 space bg-second-theme-color"
        data-bg-src="{{ asset('assets/img/services/vs-services-style1-bg.png') }}"
      >
        <img
          src="{{ asset('assets/img/icons/cloud.png') }}"
          alt="icon"
          class="vs-services-style1-icon-1 animate-parachute"
        />
        <img
          src="{{ asset('assets/img/icons/ballon.png') }}"
          alt="icon"
          class="vs-services-style1-icon-2 animate-parachute"
        />
        <div class="container">
          <div class="row g-4">
            <div class="col-md-6 text-center text-md-start">
              <div class="row">
                <div class="col-12 col-xl-11">
                  <div class="title-area text-center text-md-start">
                    <span class="sec-subtitle fade-anim" data-direction="bottom"
                      >{{ $serviceHeader->description ?? 'our services' }}</span
                    >
                    <h2
                      class="sec-title text-white-color fade-anim"
                      data-direction="top"
                    >
                      {!! $serviceHeader->title ?? 'It’s Time to Travel with our Company' !!}
                    </h2>
                  </div>
                  <a
                    class="vs-btn style-4 fade-anim"
                    data-direction="top"
                    href="{{ url('tours') }}"
                    >view service</a
                  >
                </div>
              </div>
              <div class="row g-4 pt-120">
                @foreach($services->slice(2, 2) as $service)
                <div class="col-lg-6 fade-anim">
                  <div class="vs-services-box-style1">
                    <figure class="services-thumb">
                      <img
                        src="{{ $service->image_path ? asset($service->image_path) : asset('assets/img/services/services-thumb-1-3.png') }}"
                        alt="{{ $service->title }}"
                        class="w-100"
                        style="height: 189px; object-fit: cover;"
                      />
                    </figure>
                    <div class="services-content">
                      <div class="services-icon" style="display: flex; align-items: center; justify-content: center; width: 66px; height: 66px; border-radius: 50%; background-color: #556B2F; margin-top: -33px; position: relative; z-index: 2; margin-left: auto; margin-right: 20px;">
                        @if($service->icon_path)
                          <img src="{{ asset($service->icon_path) }}" alt="icon" style="width: 32px; height: 32px; object-fit: contain;">
                        @else
                          <i class="fa-solid fa-star text-white" style="font-size: 24px;"></i>
                        @endif
                      </div>
                      <div class="services-content-inner" style="padding: 20px;">
                        <h5 class="services-title">
                          <a href="{{ $service->link ? url($service->link) : url('tours') }}">{{ $service->title }}</a>
                        </h5>
                        <p class="fs-16 fw-medium">
                          {{ $service->description }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <div class="col-md-6">
              <div class="row g-4">
                @foreach($services->take(2) as $service)
                <div class="col-lg-6 fade-anim">
                  <div class="vs-services-box-style1">
                    <figure class="services-thumb">
                      <img
                        src="{{ $service->image_path ? asset($service->image_path) : asset('assets/img/services/services-thumb-1-1.png') }}"
                        alt="{{ $service->title }}"
                        class="w-100"
                        style="height: 189px; object-fit: cover;"
                      />
                    </figure>
                    <div class="services-content">
                      <div class="services-icon" style="display: flex; align-items: center; justify-content: center; width: 66px; height: 66px; border-radius: 50%; background-color: #556B2F; margin-top: -33px; position: relative; z-index: 2; margin-left: auto; margin-right: 20px;">
                        @if($service->icon_path)
                          <img src="{{ asset($service->icon_path) }}" alt="icon" style="width: 32px; height: 32px; object-fit: contain;">
                        @else
                          <i class="fa-solid fa-star text-white" style="font-size: 24px;"></i>
                        @endif
                      </div>
                      <div class="services-content-inner" style="padding: 20px;">
                        <h5 class="services-title">
                          <a href="{{ $service->link ? url($service->link) : url('tours') }}">{{ $service->title }}</a>
                        </h5>
                        <p class="fs-16 fw-medium">
                          {{ $service->description }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                
                @if($services->count() > 4)
                @php $fifthService = $services->values()->get(4); @endphp
                <div class="col-12 fade-anim">
                  <div class="vs-services-box-style1">
                    <figure class="services-thumb">
                      <img
                        src="{{ $fifthService->image_path ? asset($fifthService->image_path) : asset('assets/img/services/services-thumb-1-1.png') }}"
                        alt="{{ $fifthService->title }}"
                        class="w-100"
                        style="height: 250px; object-fit: cover;"
                      />
                    </figure>
                    <div class="services-content">
                      <div class="services-icon" style="display: flex; align-items: center; justify-content: center; width: 66px; height: 66px; border-radius: 50%; background-color: #556B2F; margin-top: -33px; position: relative; z-index: 2; margin-left: auto; margin-right: 20px;">
                        @if($fifthService->icon_path)
                          <img src="{{ asset($fifthService->icon_path) }}" alt="icon" style="width: 32px; height: 32px; object-fit: contain;">
                        @else
                          <i class="fa-solid fa-star text-white" style="font-size: 24px;"></i>
                        @endif
                      </div>
                      <div class="services-content-inner" style="padding: 20px;">
                        <h5 class="services-title">
                          <a href="{{ $fifthService->link ? url($fifthService->link) : url('tours') }}">{{ $fifthService->title }}</a>
                        </h5>
                        <p class="fs-16 fw-medium">
                          {{ $fifthService->description }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>  </div>
      </div>
      <!--================= Services Area End =================-->

      <!--================= Awards Area start =================-->
      <section
        class="awards-style1 space"
        data-bg-src="{{ asset('assets/img/awards/awards-style1-bg.png') }}"
      >
        <img
          class="awards-icon-1"
          src="{{ asset('assets/img/icons/award-icon-1.png') }}"
          alt="icon"
        />
        <img
          class="awards-icon-2 move-item"
          src="{{ asset('assets/img/icons/award-icon-2.png') }}"
          alt="icon"
        />
        <div class="container">
          <div class="row justify-content-between align-items-center">
            <div class="col-md-6 col-lg-6 col-xxl-5">
              <div class="title-area text-center text-md-start">
                <span class="sec-subtitle fade-anim" data-direction="bottom"
                  >Discover Organized</span
                >
                <h2 class="sec-title fade-anim" data-direction="top">
                  Tours and Adventures our awards
                </h2>
              </div>
            </div>
            <div class="col-md-6 col-lg-5 col-xxl-5">
              <div class="google-reviewed mx-auto overflow-hidden">
                <div
                  class="left bg-white-color d-flex align-items-center gap-2"
                >
                  <img
                    src="{{ asset('assets/img/icons/awards-google.png') }}"
                    alt="google"
                  />
                  <div class="info">
                    <strong class="d-block">Google</strong>
                    <span class="d-block fs-xxs text-uppercase"
                      >Reviewed by</span
                    >
                  </div>
                </div>
                <div class="right bg-second-theme-color">
                  <div class="rating d-flex align-items-baseline gap-2">
                    <h4 class="fs-32 fw-semibold ff-rubik text-white-color">
                      4.5
                    </h4>
                    <div class="stars">
                      <ul
                        class="custom-ul d-flex align-items-center text-theme-color fs-xxs"
                      >
                        <li><i class="fa-solid fa-star"></i></li>
                        <li><i class="fa-solid fa-star"></i></li>
                        <li><i class="fa-solid fa-star"></i></li>
                        <li><i class="fa-solid fa-star"></i></li>
                        <li><i class="fa-solid fa-star"></i></li>
                      </ul>
                    </div>
                  </div>
                  <span class="review fs-xxs d-block">8.5k reviews</span>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-2 g-lg-4 award-box-style1__row">
            <div class="line-Shape"></div>
            <div
              class="col-md-6 col-lg-4 fade-anim"
              data-delay="0.30"
              data-direction="right"
            >
              <div class="award-box-style1">
                <div class="award-box-style1-wrapper">
                  <figure class="award-box-icon">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="132"
                      height="103"
                      viewBox="0 0 132 103"
                      fill="none"
                    >
                      <path
                        d="M113.179 31.5771L114.345 33.9106C118.132 41.484 124.273 47.6249 131.846 51.4116H113.179V31.5771Z"
                        fill="white"
                      />
                      <path
                        d="M18.668 31.5771L17.5012 33.9106C13.7145 41.484 7.57363 47.6249 0.000244141 51.4116H18.668V31.5771Z"
                        fill="white"
                      />
                      <circle
                        cx="51.1642"
                        cy="51.1642"
                        r="47.1642"
                        transform="matrix(1 0 0 -1 14.7588 102.328)"
                        fill="white"
                        stroke="white"
                        stroke-width="8"
                      />
                      <circle
                        cx="67.5308"
                        cy="51.5308"
                        r="39.2808"
                        fill="currentColor"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-dasharray="3 3"
                      />
                      <path
                        d="M80.5531 52.3525C81.4013 52.3525 82.2165 52.1074 82.9353 51.6249C84.1269 50.8194 84.954 49.3584 84.9862 47.8389C85.0231 47.0666 84.9862 46.2485 84.8733 45.337C84.8099 44.8155 84.3504 44.4116 83.7586 44.4703C82.747 44.6005 81.7104 45.0807 80.8462 45.8325C80.8054 45.496 80.7517 45.1621 80.6848 44.831C81.6436 44.3561 82.3848 43.5933 82.768 42.6415C83.3234 41.3088 83.1493 39.6629 82.3118 38.3458C81.8458 37.6114 81.3439 36.9373 80.8216 36.34C80.4587 35.9266 79.8323 35.8838 79.417 36.2467C78.5162 37.0336 77.9092 38.1756 77.6612 39.5588C77.4369 40.8865 77.6114 42.006 78.113 43.219C80.1978 48.1718 78.2832 53.8349 73.9463 56.6012C73.6393 56.7928 73.3967 57.0576 73.2307 57.3658H68.996V53.2966L72.5017 55.1169C72.8445 55.294 73.2485 55.2557 73.5464 55.038C73.8518 54.8163 74.0056 54.4418 73.9433 54.0692L73.1117 49.0654L76.7254 45.5061C76.9939 45.2415 77.0902 44.8475 76.9734 44.4895C76.8567 44.1306 76.5474 43.868 76.1748 43.8115L71.1827 43.0598L68.9074 38.0298C68.5845 37.3158 67.4152 37.3158 67.0923 38.0298L64.817 43.0598L59.8249 43.8117C59.4524 43.8682 59.143 44.1308 59.0263 44.4897C58.9096 44.8477 59.0059 45.2417 59.2744 45.5063L62.8881 49.0656L62.0564 54.0694C61.9941 54.4419 62.1478 54.8165 62.4533 55.0382C62.7588 55.26 63.1615 55.2902 63.498 55.1171L67.0038 53.2968V57.366H62.7378C62.369 56.7477 61.8054 56.4673 61.2775 56.0547C58.4798 53.7922 57.0624 50.5337 57.0624 47.4051C57.0624 43.4278 58.8985 42.7963 58.3552 39.5473C58.1071 38.1748 57.5011 37.0337 56.6013 36.2468C56.1899 35.8849 55.5576 35.9258 55.1967 36.3402C54.6704 36.9413 54.1685 37.6164 53.7065 38.3449C52.869 39.662 52.6929 41.3079 53.2444 42.6308C53.6317 43.5915 54.3747 44.3563 55.3344 44.8317C55.2674 45.163 55.2138 45.4971 55.173 45.8339C54.3059 45.0807 53.2514 44.6004 52.2409 44.4704C51.9783 44.4421 51.7117 44.5093 51.5026 44.6727C51.2935 44.8351 51.1573 45.0754 51.1262 45.3381C51.0143 46.2505 50.9783 47.0695 51.0123 47.8225C51.0542 49.3973 51.9107 50.8622 53.0916 51.6327C53.7833 52.1094 54.6013 52.3535 55.4564 52.3535C55.6558 52.3535 55.8583 52.3294 56.0608 52.3027C56.1869 52.6104 56.3131 52.9174 56.4619 53.2147C55.5658 53.0989 54.4449 53.1272 53.3474 53.6715C52.8413 53.9226 52.6488 54.5387 52.9078 55.0285C53.257 55.6929 53.6733 56.4605 54.1684 57.1306C55.0122 58.3623 56.3999 59.2094 58.0389 59.2094C59.0305 59.2094 59.9837 58.8294 60.7703 58.1474C60.8923 58.2345 61.0069 58.3201 61.0272 58.3622V65.3348H60.0311C59.4805 65.3348 59.035 65.7803 59.035 66.3309C59.035 66.8815 59.4805 67.327 60.0311 67.327H75.9685C76.5191 67.327 76.9646 66.8815 76.9646 66.3309C76.9646 65.7803 76.5191 65.3348 75.9685 65.3348H74.9724V58.4692C74.9844 58.4074 75.0103 58.3495 75.0103 58.2852C75.088 58.2356 75.1552 58.1747 75.2315 58.1237C77.3039 59.9518 80.2379 59.3905 81.8731 57.1365C82.3402 56.4252 82.7961 55.7483 83.1483 54.9838C83.374 54.4945 83.1688 53.9138 82.6853 53.6745C81.7762 53.2242 80.7443 53.092 79.5527 53.2383C79.7071 52.9318 79.8592 52.6239 79.9889 52.3051C80.1778 52.3288 80.3668 52.3525 80.5531 52.3525ZM69.9921 63.3425H66.0077C65.4571 63.3425 65.0116 62.897 65.0116 62.3464C65.0116 61.7958 65.4571 61.3503 66.0077 61.3503H69.9921C70.5426 61.3503 70.9881 61.7958 70.9881 62.3464C70.9881 62.897 70.5426 63.3425 69.9921 63.3425Z"
                        fill="white"
                      />
                    </svg>
                  </figure>
                  <div
                    class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center"
                  >
                    <img
                      src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                      alt="award-box-left-wings"
                    />
                    <h6 class="text-capitalize ff-rubik fw-semibold">
                      world travelers Award
                    </h6>
                    <img
                      src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                      alt="award-box-right-wings"
                    />
                  </div>
                  <div class="award-box-body text-center">
                    <span class="text-third-theme-color bg-white-color"
                      >world travel</span
                    >
                  </div>
                  <div class="award-box-footer text-capitalize text-center">
                    <p class="line1">
                      recived in happy award in <strong>2022</strong>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="col-md-6 col-lg-4 fade-anim"
              data-delay="0.45"
              data-direction="right"
            >
              <div class="award-box-style1">
                <div class="award-box-style1-wrapper">
                  <figure class="award-box-icon text-center">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="132"
                      height="103"
                      viewBox="0 0 132 103"
                      fill="none"
                    >
                      <path
                        d="M113.179 31.5771L114.345 33.9106C118.132 41.484 124.273 47.6249 131.846 51.4116H113.179V31.5771Z"
                        fill="white"
                      />
                      <path
                        d="M18.668 31.5771L17.5012 33.9106C13.7145 41.484 7.57363 47.6249 0.000244141 51.4116H18.668V31.5771Z"
                        fill="white"
                      />
                      <circle
                        cx="51.1642"
                        cy="51.1642"
                        r="47.1642"
                        transform="matrix(1 0 0 -1 14.7588 102.328)"
                        fill="white"
                        stroke="white"
                        stroke-width="8"
                      />
                      <circle
                        cx="67.5308"
                        cy="51.5308"
                        r="39.2808"
                        fill="currentColor"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-dasharray="3 3"
                      />
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M70.1325 38.2514C68.1798 37.1867 65.8201 37.1867 63.8675 38.2514L53.4108 43.9532C51.3083 45.0997 50 47.3032 50 49.6981V60.4675C50 62.8623 51.3083 65.0659 53.4108 66.2123L63.8675 71.9141C65.8201 72.9787 68.1798 72.9787 70.1325 71.9141L80.5892 66.2123C82.6918 65.0659 84 62.8623 84 60.4675V49.6981C84 47.3032 82.6918 45.0997 80.5892 43.9532L70.1325 38.2514ZM67.0005 48.5395C66.3808 48.5395 65.9664 49.2828 65.1376 50.7696L64.9232 51.1544C64.6878 51.5769 64.5701 51.788 64.3864 51.9274C64.2028 52.0667 63.9742 52.1187 63.5168 52.222L63.1004 52.3163C61.4909 52.6805 60.6862 52.8624 60.4947 53.4781C60.3033 54.0939 60.8519 54.7353 61.9491 56.0185L62.233 56.3504C62.5448 56.7149 62.7006 56.8972 62.7709 57.1228C62.8409 57.3483 62.8173 57.5915 62.7702 58.0781L62.7272 58.5208C62.5614 60.2328 62.4785 61.0887 62.9796 61.4693C63.481 61.8497 64.2344 61.5029 65.7413 60.809L66.1311 60.6295C66.5594 60.4324 66.7734 60.3338 67.0005 60.3338C67.2275 60.3338 67.4415 60.4324 67.8699 60.6295L68.2596 60.809C69.7665 61.5029 70.5199 61.8497 71.0213 61.4693C71.5226 61.0887 71.4395 60.2328 71.2737 58.5208L71.2307 58.0781C71.1836 57.5915 71.1601 57.3483 71.2301 57.1228C71.3003 56.8972 71.4562 56.7149 71.7679 56.3504L72.0519 56.0185C73.149 54.7353 73.6978 54.0939 73.5063 53.4781C73.3148 52.8624 72.5099 52.6805 70.9005 52.3163L70.4841 52.222C70.0268 52.1187 69.7982 52.0667 69.6145 51.9274C69.4309 51.788 69.3131 51.5769 69.0778 51.1544L68.8633 50.7696C68.0345 49.2828 67.6201 48.5395 67.0005 48.5395Z"
                        fill="white"
                      />
                      <path
                        d="M64.8191 30H69.1814C73.294 30 75.3504 30 76.6281 31.2777C77.9058 32.5553 77.9058 34.6117 77.9058 38.7244V38.7636L71.6986 35.379C68.7696 33.7819 65.2301 33.7819 62.3011 35.379L56.0947 38.7631V38.7244C56.0947 34.6117 56.0947 32.5553 57.3724 31.2777C58.65 30 60.7064 30 64.8191 30Z"
                        fill="white"
                      />
                    </svg>
                  </figure>
                  <div
                    class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center"
                  >
                    <img
                      src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                      alt="award-box-left-wings"
                    />
                    <h6 class="text-capitalize ff-rubik fw-semibold">
                      Tours Adventures Award
                    </h6>
                    <img
                      src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                      alt="award-box-right-wings"
                    />
                  </div>
                  <div class="award-box-body text-center">
                    <span class="text-third-theme-color bg-white-color"
                      >tours award</span
                    >
                  </div>
                  <div class="award-box-footer text-capitalize text-center">
                    <p class="line1">
                      recived in happy award in <strong>2023</strong>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="col-md-6 col-lg-4 fade-anim"
              data-delay="0.60"
              data-direction="right"
            >
              <div class="award-box-style1">
                <div class="award-box-style1-wrapper">
                  <figure class="award-box-icon text-center">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="132"
                      height="103"
                      viewBox="0 0 132 103"
                      fill="none"
                    >
                      <path
                        d="M113.179 31.5771L114.345 33.9106C118.132 41.484 124.273 47.6249 131.846 51.4116H113.179V31.5771Z"
                        fill="white"
                      />
                      <path
                        d="M18.668 31.5771L17.5012 33.9106C13.7145 41.484 7.57363 47.6249 0.000244141 51.4116H18.668V31.5771Z"
                        fill="white"
                      />
                      <circle
                        cx="51.1642"
                        cy="51.1642"
                        r="47.1642"
                        transform="matrix(1 0 0 -1 14.7588 102.328)"
                        fill="white"
                        stroke="white"
                        stroke-width="8"
                      />
                      <circle
                        cx="67.5308"
                        cy="51.5308"
                        r="39.2808"
                        fill="currentColor"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-dasharray="3 3"
                      />
                      <path
                        d="M51.6644 46.8563L60.6171 62.9798C60.8081 66.9046 64.0328 70.0656 68 70.0656C71.9672 70.0656 75.2131 66.9046 75.3828 62.9798L84.3356 46.8563C85.4812 44.7985 85.1206 42.189 83.4446 40.5342L77.2286 34.3182C77.0376 34.1273 76.6982 34 76.486 34H59.514C59.3018 34 58.9624 34.1273 58.7714 34.3182L52.5554 40.5342C50.8794 42.2102 50.5188 44.7985 51.6644 46.8563ZM68.0212 67.9441C65.0935 67.9441 62.7174 65.568 62.7174 62.6404C62.7174 59.7127 65.0935 57.3366 68.0212 57.3366C70.9489 57.3366 73.325 59.7127 73.325 62.6404C73.325 65.568 70.9489 67.9441 68.0212 67.9441ZM63.6509 42.486L62.8023 40.3645H73.2401L72.3915 42.486H63.6509ZM71.5429 44.6075L68.0212 53.4118L64.4995 44.6075H71.5429ZM78.3742 41.8708C78.6288 41.3404 79.2652 41.1071 79.7956 41.3616C80.326 41.6162 80.5593 42.2527 80.3047 42.783L74.2372 55.6606C73.9827 56.191 73.3462 56.4243 72.8158 56.1698C72.2854 55.9152 72.0521 55.2787 72.3067 54.7484L78.3742 41.8708ZM74.9373 36.1215L74.0887 38.243H61.9537L61.1051 36.1215H74.9373ZM56.2468 41.3616C56.7772 41.1071 57.4137 41.3404 57.6683 41.8708L63.7358 54.7484C63.9903 55.2787 63.757 55.9152 63.2266 56.1698C62.6962 56.4243 62.0598 56.191 61.8052 55.6606L55.7377 42.783C55.4831 42.2527 55.7165 41.6162 56.2468 41.3616Z"
                        fill="white"
                      />
                      <path
                        d="M68.0217 59.458C67.4277 59.458 66.9609 59.9247 66.9609 60.5188C66.9609 61.1128 67.4277 61.5795 68.0217 61.5795C68.6157 61.5795 69.0824 62.0462 69.0824 62.6403C69.0824 63.2343 69.5492 63.701 70.1432 63.701C70.7372 63.701 71.204 63.2343 71.204 62.6403C71.204 60.8794 69.7825 59.458 68.0217 59.458Z"
                        fill="white"
                      />
                    </svg>
                  </figure>
                  <div
                    class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center"
                  >
                    <img
                      src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                      alt="award-box-left-wings"
                    />
                    <h6 class="text-capitalize ff-rubik fw-semibold">
                      vecuro Adventure Award
                    </h6>
                    <img
                      src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                      alt="award-box-right-wings"
                    />
                  </div>
                  <div class="award-box-body text-center">
                    <span class="text-third-theme-color bg-white-color"
                      >vecuro award</span
                    >
                  </div>
                  <div class="award-box-footer text-capitalize text-center">
                    <p class="line1">
                      recived in happy award in <strong>2024</strong>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Awards Area end =================-->

      <!--================= Blog Area start =================-->
      <section class="blog-style1 space-top space-extra-bottom">
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span class="sec-subtitle fade-anim" data-direction="bottom"
                  >Blog & Articles</span
                >
                <h2 class="sec-title fade-anim" data-direction="top">
                  latest news update
                </h2>
              </div>
            </div>
          </div>
          <div class="row g-4">
            @foreach($latestBlogs as $blog)
              <div class="col-md-6 col-lg-4 move-anim">
                <div class="vs-blog-box style1">
                  <figure class="blog-thumb">
                    <a href="{{ url('blog-single/' . $blog->slug) }}">
                      <img
                        src="{{ $blog->images->count() > 0 ? asset($blog->images->first()->image_path) : asset('assets/img/blog/blog-1-1.png') }}"
                        alt="{{ $blog->title }}"
                        class="w-100"
                        style="height: 250px; object-fit: cover;"
                      />
                    </a>
                  </figure>
                  <div class="blog-content">
                    <div class="blog-meta">
                      <ul class="custom-ul">
                        <li>
                          <a href="{{ url('blog-single/' . $blog->slug) }}">
                            <i class="fa-sharp fa-solid fa-circle-user"></i>
                            by Admin
                          </a>
                        </li>
                        <li class="date">{{ $blog->created_at->format('d M') }}</li>
                      </ul>
                    </div>
                    <h5 class="blog-title line-clamp-2">
                      <a href="{{ url('blog-single/' . $blog->slug) }}">{{ $blog->title }}</a>
                    </h5>
                    <div class="blog-footer">
                      <a href="{{ url('blog-single/' . $blog->slug) }}" class="vs-btn style4">
                        <span>Read More</span>
                        <i class="fa-duotone fa-regular fa-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </section>
      <!--================= Blog Area end =================-->

      <style>
        /* Swiper custom bullet styles */
        .hero-swiper-pagination .swiper-pagination-bullet {
          width: 12px;
          height: 12px;
          background: rgba(255, 255, 255, 0.5) !important;
          opacity: 1 !important;
          transition: all 0.3s ease;
          margin: 0 6px !important;
        }
        .hero-swiper-pagination .swiper-pagination-bullet-active {
          background: #296c72 !important; /* Brand teal theme accent */
          width: 32px !important;
          border-radius: 6px !important;
        }
        
        /* Swiper custom navigation arrow styles */
        .hero-swiper-next,
        .hero-swiper-prev {
          width: 50px !important;
          height: 50px !important;
          background: rgba(255, 255, 255, 0.15) !important;
          backdrop-filter: blur(8px) !important;
          -webkit-backdrop-filter: blur(8px) !important;
          border: 1px solid rgba(255, 255, 255, 0.25) !important;
          border-radius: 50% !important;
          transition: all 0.3s ease !important;
        }
        .hero-swiper-next:hover,
        .hero-swiper-prev:hover {
          background: #296c72 !important;
          border-color: #296c72 !important;
          color: #ffffff !important;
          transform: scale(1.08);
        }
        .hero-swiper-next::after,
        .hero-swiper-prev::after {
          font-size: 1.25rem !important;
          color: #ffffff !important;
          font-weight: 900;
        }

        /* Micro-animations inside Swiper slides */
        .hero-swiper .swiper-slide .hero-sun-icon,
        .hero-swiper .swiper-slide .sec-subtitle,
        .hero-swiper .swiper-slide .sec-title {
          opacity: 0;
          transform: translateY(30px);
          transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hero-swiper .swiper-slide-active .hero-sun-icon {
          opacity: 1;
          transform: translateY(0);
          transition-delay: 0.2s;
        }
        .hero-swiper .swiper-slide-active .sec-subtitle {
          opacity: 1;
          transform: translateY(0);
          transition-delay: 0.4s;
        }
        .hero-swiper .swiper-slide-active .sec-title {
          opacity: 1;
          transform: translateY(0);
          transition-delay: 0.6s;
        }

        /* Responsive spacing adjustments for mobile viewports */
        @media (max-width: 991px) {
          .hero-swiper .swiper-slide .hero-content {
            margin-bottom: 250px !important;
          }
          .hero-search-container {
            bottom: 20px !important;
          }
          .hero-swiper-pagination {
            bottom: 290px !important;
          }
        }
        @media (max-width: 575px) {
          .hero-swiper .swiper-slide .hero-content {
            margin-bottom: 360px !important;
          }
          .hero-swiper-pagination {
            bottom: 400px !important;
          }
          .hero-swiper .swiper-slide .sec-title {
            font-size: 2.4rem !important;
            line-height: 1.2 !important;
          }
          .hero-swiper .swiper-slide .sec-subtitle {
            font-size: 1.1rem !important;
          }
        }
      </style>

@endsection

@section('scripts')
      <script>
        $(document).ready(function() {
          if (typeof Swiper !== 'undefined') {
            const heroSwiper = new Swiper('.hero-swiper', {
              loop: true,
              effect: 'fade',
              fadeEffect: {
                crossFade: true
              },
              speed: 1200,
              autoplay: {
                delay: 5000,
                disableOnInteraction: false,
              },
              pagination: {
                el: '.hero-swiper-pagination',
                clickable: true,
              },
            });
          }
        });
      </script>
@endsection
