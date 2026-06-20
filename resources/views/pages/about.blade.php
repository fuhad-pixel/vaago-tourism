@extends('layouts.app')

@section('content')
<style>
.dynamic-about-desc ul {
  list-style: none;
  padding-left: 0;
}
.dynamic-about-desc ul li {
  position: relative;
  padding-left: 30px;
  margin-bottom: 15px;
  font-weight: 500;
  color: #475569;
}
.dynamic-about-desc ul li::before {
  content: '';
  position: absolute;
  left: 0;
  top: 4px;
  width: 18px;
  height: 16px;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='16' viewBox='0 0 18 16' fill='none'%3E%3Cpath d='M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z' fill='%23f15d30'/%3E%3C/svg%3E");
  background-size: cover;
}
</style>
      <!--================= Breadcrumb Area start =================-->
      <section
        class="vs-breadcrumb"
        data-bg-src="{{ isset($hero_setting) && $hero_setting->image_path ? asset($hero_setting->image_path) : asset('assets/img/bg/breadcrumb-bg-2.png') }}"
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
                <h1 class="breadcrumb-title">{{ isset($hero_setting) && $hero_setting->title ? $hero_setting->title : 'About us' }}</h1>
                @if(isset($hero_setting) && $hero_setting->description)
                    <p class="breadcrumb-description text-white">{{ $hero_setting->description }}</p>
                @endif
              </div>
              <div class="breadcrumb-menu">
                <ul class="custom-ul">
                  <li>
                    <a href="{{ url('/') }}">Home</a>
                  </li>
                  <li>About</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= About Area start =================-->
      <section class="vs-about position-relative space">
        <img
          src="{{ asset('assets/img/icons/plain-globe.png') }}"
          alt="plain-globe"
          class="about-icon-1 animate-parachute"
        />
        <img
          src="{{ asset('assets/img/icons/map.png') }}"
          alt="plain-globe"
          class="about-icon-2 animate-parachute"
        />
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span
                  class="sec-subtitle text-capitalize fade-anim"
                  data-direction="top"
                  >about {{ $company_setting->company_name ?? 'tripik' }}</span
                >
                @if(isset($about_setting) && $about_setting->header_title)
                    <h2 class="sec-title fade-anim" data-direction="bottom">
                        {!! nl2br(e($about_setting->header_title === 'Discover Organized Adventures Ultimate Travel Hack' ? "Discover Organized Adventures\nUltimate Travel Hack" : $about_setting->header_title)) !!}
                    </h2>
                @else
                    <h2 class="sec-title fade-anim" data-direction="bottom">
                      Discover Organized Adventures <br />
                      Ultimate Travel Hack
                    </h2>
                @endif
              </div>
            </div>
          </div>
          <div class="row g-4 align-items-center">
            <div class="col-md-6 order-1 order-md-0">
              <div class="about-info-area">
                <div class="title-area">
                  <span class="sec-subtitle text-capitalize"
                    >{{ isset($about_setting) && $about_setting->subtitle ? $about_setting->subtitle : 'Explore our trip' }}</span
                  >
                  <h2 class="sec-title">{{ isset($about_setting) && $about_setting->title ? $about_setting->title : 'Discover safe and memorable tours' }}</h2>
                </div>
                
                @if(isset($about_setting) && $about_setting->description)
                    <div class="about-info dynamic-about-desc">
                        {!! $about_setting->description !!}
                        <div class="btn-trigger btn-bounce" style="margin-top: 30px;">
                          <a
                            href="{{ url('/destination') }}"
                            class="vs-btn style6 text-capitalize"
                            >view all services</a
                          >
                        </div>
                    </div>
                @else
                    <div class="about-info">
                      <p>
                        We provide top tier tour management, customized vacation layouts, secure transactions, and private travel guide matchings. Make your vacation unforgettable with us.
                      </p>
                      <div class="services-lists">
                        <ul class="custom-ul">
                          <li>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="18"
                              height="16"
                              viewBox="0 0 18 16"
                              fill="none"
                            >
                              <path
                                d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z"
                                fill="currentColor"
                              />
                            </svg>
                            Professional private guides matching
                          </li>
                          <li>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="18"
                              height="16"
                              viewBox="0 0 18 16"
                              fill="none"
                            >
                              <path
                                d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z"
                                fill="currentColor"
                              />
                            </svg>
                            Discover Ultimate Travel Hacks
                          </li>
                          <li>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="18"
                              height="16"
                              viewBox="0 0 18 16"
                              fill="none"
                            >
                              <path
                                d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z"
                                fill="currentColor"
                              />
                            </svg>
                            Secure and flexible payment options
                          </li>
                        </ul>
                      </div>
                      <div class="btn-trigger btn-bounce">
                        <a
                          href="{{ url('/destination') }}"
                          class="vs-btn style6 text-capitalize"
                          >view all services</a
                        >
                      </div>
                    </div>
                @endif
              </div>
            </div>
            <div class="col-md-6 order-0 order-md-1">
              <div class="about-thumb fade-anim" data-direction="right">
                <img
                  src="{{ isset($about_setting) && $about_setting->image_path ? asset($about_setting->image_path) : asset('assets/img/about/about-thumb.png') }}"
                  alt="about-thumb"
                  class="w-100"
                />
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= About Area end =================-->

      <!--================= Travel-guides start =================-->
      @if(isset($travel_guide_status) && $travel_guide_status == '1' && isset($travel_guides) && $travel_guides->count() > 0)
      <section
        class="travel-guides bg-second-theme-color position-relative space"
        data-bg-src="{{ asset('assets/img/bg/travel-guides-bg.png') }}"
      >
        <img
          src="{{ asset('assets/img/icons/plain-sclation.png') }}"
          alt="icon"
          class="travel-guides-icon-1 animate-parachute"
        />
        <img
          src="{{ asset('assets/img/icons/rops.png') }}"
          alt="icon"
          class="travel-guides-icon-2 animate-parachute"
        />
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span class="sec-subtitle fade-anim" data-direction="top"
                  >Meet Our Guides</span
                >
                <h2
                  class="sec-title text-white-color fade-anim"
                  data-direction="bottom"
                >
                  Meet Our Travel Guides
                </h2>
              </div>
            </div>
          </div>
          <div class="row g-4">
            @foreach($travel_guides as $index => $guide)
            <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="{{ 0.30 + ($index * 0.10) }}">
              <div class="guide-box">
                <figure class="guide-thumb">
                  @if($guide->photo)
                  <img
                    src="{{ asset($guide->photo) }}"
                    alt="{{ $guide->name }}"
                    class="w-100"
                    style="height: 350px; object-fit: cover;"
                  />
                  @else
                  <div class="w-100" style="height: 350px; background: #e2e8f0; display: flex; align-items: center; justify-content: center;">
                      <i class="fa-solid fa-user text-secondary" style="font-size: 4rem;"></i>
                  </div>
                  @endif
                </figure>
                <div class="guide-content text-center">
                  <h5
                    class="guide-name line-clamp-1 text-second-theme-color text-capitalize"
                  >
                    {{ $guide->name }}
                  </h5>
                  <p
                    class="guide-designation line-clamp-1 text-theme-color text-capitalize"
                  >
                    {{ $guide->designation ?? 'Travel Guide' }}
                  </p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </section>
      @endif
      <!--================= Travel-guides end =================-->

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
                <span class="sec-subtitle fade-anim" data-direction="top"
                  >Discover Organized</span
                >
                <h2 class="sec-title fade-anim" data-direction="bottom">
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
            <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.30">
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
                        d="M80.5531 52.3525C81.4013 52.3525 82.2165 52.1074 82.9353 51.6249C84.1269 50.8194 84.954 49.3584 84.9862 47.8389C85.0231 47.0666 84.9862 46.2485 84.8733 45.337C84.8099 44.8155 84.3504 44.4116 83.7586 44.4703C82.747 44.6005 81.7104 45.0807 80.8462 45.8325C80.8054 45.496 80.7517 45.1621 80.6848 44.831C81.6436 44.3561 82.3848 43.5933 82.768 42.6415C83.3234 41.3088 83.1493 39.6629 82.3118 38.3458C81.8458 37.6114 81.3439 36.9373 80.8216 36.34C80.4587 35.9266 79.8323 35.8838 79.417 36.2467C78.5162 37.0336 77.9092 38.1756 77.6612 39.5588C77.4369 40.8865 77.6114 42.006 78.113 43.219C80.1978 48.1718 78.2832 53.8349 73.9463 56.6012C73.6393 56.7928 73.3967 57.3658H68.996V53.2966L72.5017 55.1169C72.8445 55.294 73.2485 55.2557 73.5464 55.038C73.8518 54.8163 74.0056 54.4418 73.9433 54.0692L73.1117 49.0654L76.7254 45.5061C76.9939 45.2415 77.0902 44.8475 76.9734 44.4895C76.8567 44.1306 76.5474 43.868 76.1748 43.8115L71.1827 43.0598L68.9074 38.0298C68.5845 37.3158 67.4152 37.3158 67.0923 38.0298L64.817 43.0598L59.8249 43.8117C59.4524 43.8682 59.143 44.1308 59.0263 44.4897C58.9096 44.8477 59.0059 45.2417 59.2744 45.5063L62.8881 49.0656L62.0564 54.0694C61.9941 54.4419 62.1478 54.8165 62.4533 55.0382C62.7432 55.0382 62.9644 54.9137 62.9644 54.9137Z"
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
                      received in happy award in <strong>2022</strong>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.60">
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
                      received in happy award in <strong>2023</strong>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.90">
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
                      received in happy award in <strong>2024</strong>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Awards Area end =================-->
@endsection
