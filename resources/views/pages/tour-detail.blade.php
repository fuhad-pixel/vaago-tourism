@extends('layouts.app')

@section('content')
<style>
  /* Styling for dynamic lists */
  .inc-list-styled ul,
  .inc-list-styled ol {
    list-style-type: none;
    padding-left: 0;
    margin-bottom: 20px;
  }

  .inc-list-styled li {
    position: relative;
    padding-left: 25px;
    margin-bottom: 12px;
    color: #4b5563;
    font-size: 15px;
  }

  .inc-list-styled li::before {
    content: '\f00c';
    font-family: 'Font Awesome 6 Free', 'FontAwesome';
    font-weight: 900;
    position: absolute;
    left: 0;
    top: 2px;
    color: #10B981;
    font-size: 15px;
  }

  .exc-list-styled ul,
  .exc-list-styled ol {
    list-style-type: none;
    padding-left: 0;
    margin-bottom: 20px;
  }

  .exc-list-styled li {
    position: relative;
    padding-left: 25px;
    margin-bottom: 12px;
    color: #4b5563;
    font-size: 15px;
  }

  .exc-list-styled li::before {
    content: '\f00d';
    font-family: 'Font Awesome 6 Free', 'FontAwesome';
    font-weight: 900;
    position: absolute;
    left: 0;
    top: 2px;
    color: #EF4444;
    font-size: 15px;
  }

  .tour-rich-content p {
    margin-bottom: 15px;
    line-height: 1.75;
    color: #555;
  }

  /* Sticky Bottom Bar */
  .sticky-bottom-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-top: 1px solid rgba(229, 231, 235, 0.5);
    box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.08);
    z-index: 1000;
    padding: 15px 0;
    box-sizing: border-box;
    overflow: hidden;
  }

  .bottom-btn-group {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    padding: 0 15px;
    box-sizing: border-box;
  }

  .bottom-btn {
    flex: 1;
    min-width: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 12px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none !important;
    border: none;
    box-sizing: border-box;
    overflow: hidden;
    white-space: nowrap;
  }

  .bottom-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }

  .btn-call {
    background: #00656c;
    color: #fff !important;
    box-shadow: 0 4px 15px rgba(0, 101, 108, 0.3);
  }

  .btn-enquire {
    background: #223740;
    color: #fff !important;
    box-shadow: 0 4px 15px rgba(34, 55, 64, 0.3);
  }

  .btn-whatsapp {
    background: #25D366;
    color: #fff !important;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
  }

  body {
    padding-bottom: 90px;
  }

  /* Shift scroll to top button above the sticky bottom bar on tour details page */
  .scrollToTop.show {
    bottom: 110px !important;
  }

  .scrollToTop {
    bottom: 85px !important;
  }

  @media (max-width: 767px) {
    .scrollToTop.show {
      bottom: 100px !important;
    }
  }

  /* Prevent horizontal overflow on details section */
  .vs-destination-details {
    overflow-x: hidden;
  }

  /* Restore standard lists inside accordion-body and tour-rich-content (CKEditor) */
  .accordion-body ul,
  .tour-rich-content ul {
    list-style-type: disc !important;
    padding-left: 20px !important;
    margin-top: 10px !important;
    margin-bottom: 15px !important;
  }

  .accordion-body ol,
  .tour-rich-content ol {
    list-style-type: decimal !important;
    padding-left: 20px !important;
    margin-top: 10px !important;
    margin-bottom: 15px !important;
  }

  .accordion-body li,
  .tour-rich-content li {
    margin-bottom: 6px !important;
    list-style: inherit !important;
    padding-left: 0 !important;
  }

  .accordion-body li::before,
  .tour-rich-content li::before {
    display: none !important;
  }

  /* Trip Planner Popup Styles */
  .trip-planner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.4s ease;
  }

  .trip-planner-overlay.active {
    opacity: 1;
    pointer-events: auto;
  }

  .trip-planner-box {
    background: #fff;
    border-radius: 24px;
    width: 90%;
    max-width: 440px;
    padding: 35px 30px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    position: relative;
    transform: scale(0.8);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  .trip-planner-overlay.active .trip-planner-box {
    transform: scale(1);
    opacity: 1;
  }

  .trip-planner-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #f1f5f9;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-size: 20px;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
  }

  .trip-planner-close:hover {
    background: #e2e8f0;
    color: #334155;
  }

  .trip-planner-title {
    font-size: 20px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 25px;
    line-height: 1.4;
    text-align: left;
    padding-right: 20px;
  }

  .trip-options-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 25px;
  }

  .trip-option-card {
    background: #fff8f5;
    border: 1.5px solid transparent;
    border-radius: 16px;
    padding: 15px 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .trip-option-card:hover {
    background: #fff3f1;
    transform: translateY(-2px);
  }

  .trip-option-card.active {
    background: #f2f9f9;
    border-color: #00656c;
    box-shadow: 0 4px 15px rgba(0, 101, 108, 0.12);
  }

  .trip-option-card.solo-option {
    grid-column: span 2;
    width: calc(50% - 7.5px);
    margin: 0 auto;
  }

  .trip-option-card svg {
    transition: transform 0.3s;
  }

  .trip-option-card:hover svg {
    transform: scale(1.1);
  }

  .trip-option-card span {
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
  }

  #popup-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 101, 108, 0.4);
  }

  @media (max-width: 480px) {
    .bottom-btn-group {
      gap: 8px !important;
      padding: 0 10px !important;
    }

    .bottom-btn {
      font-size: 11px !important;
      padding: 10px 8px !important;
      gap: 3px !important;
    }

    .bottom-btn i {
      font-size: 13px !important;
    }
  }

  @media (max-width: 360px) {
    .bottom-btn {
      font-size: 10px !important;
      padding: 9px 6px !important;
    }
  }
</style>

<!--================= Breadcrumb Area start =================-->
<section
  class="vs-breadcrumb"
  data-bg-src="{{ $tour->images->count() > 0 ? asset($tour->images->first()->image_path) : asset('assets/img/bg/breadcrumb-bg.png') }}"
  style="background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
  <!-- Overlay for better text readability -->
  <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.45); z-index: 1;"></div>

  <img
    src="{{ asset('assets/img/icons/cloud.png') }}"
    alt="vs-breadcrumb-icon"
    class="vs-breadcrumb-icon-1 animate-parachute"
    style="z-index: 2;" />
  <img
    src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
    alt="vs-breadcrumb-icon"
    class="vs-breadcrumb-icon-2 animate-parachute"
    style="z-index: 2;" />
  <div class="container" style="position: relative; z-index: 2;">
    <div class="row text-center">
      <div class="col-12">
        <div class="breadcrumb-content">
          <h1 class="breadcrumb-title">{{ $tour->name }}</h1>
        </div>
        <div class="breadcrumb-menu">
          <ul class="custom-ul">
            <li>
              <a href="{{ url('/') }}">Home</a>
            </li>
            <li>
              <a href="{{ url('/destination') }}">Trips</a>
            </li>
            <li>{{ $tour->name }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!--================= Breadcrumb Area end =================-->

<!--================= Destination Details Area Start =================-->
<section class="vs-destination-details space bg-theme-07">
  <div class="container">
    <div class="row gx-3 gx-xl-5 gy-5">
      <div class="col-lg-8">
        <div class="vs-destination-single">
          <div class="row align-items-center gy-3 mb-4">
            <div class="col-12">
              <h2 class="destination-single-title">
                {{ $tour->name }}
              </h2>
            </div>
          </div>

          <div class="destination-single-info">
            <!-- Main Image -->
            <figure class="destination-single-img d-block" id="main-tour-hero-img">
              <img
                src="{{ $tour->images->count() > 0 ? asset($tour->images->first()->image_path) : asset('assets/img/destination/destination-single-1.png') }}"
                alt="{{ $tour->name }}"
                class="w-100"
                style="border-radius: 15px; height: 450px; object-fit: cover;" />
            </figure>

            <div class="destination-single-px">
              <div class="trip-info">
                @if($tour->category)
                <div class="trip-info-box">
                  <div class="header">
                    <i class="fa-regular fa-grid-2 text-theme-color" style="font-size: 18px; margin-right: 8px;"></i>
                    <span>Category</span>
                  </div>
                  <h6 class="info-title">{{ $tour->category->name }}</h6>
                </div>
                @endif

                <div class="trip-info-box">
                  <div class="header">
                    <i class="fa-solid fa-location-dot text-theme-color" style="font-size: 18px; margin-right: 8px;"></i>
                    <span>Destination</span>
                  </div>
                  <h6 class="info-title">{{ $tour->destinations->pluck('name')->implode(', ') }}</h6>
                </div>

                @if($tour->duration_days > 0 || $tour->duration_nights > 0)
                <div class="trip-info-box">
                  <div class="header">
                    <i class="fa-regular fa-clock text-theme-color" style="font-size: 18px; margin-right: 8px;"></i>
                    <span>Duration</span>
                  </div>
                  <h6 class="info-title">
                    @if($tour->duration_days > 0 && $tour->duration_nights > 0)
                      {{ $tour->duration_days }} {{ \Illuminate\Support\Str::plural('Day', $tour->duration_days) }} / {{ $tour->duration_nights }} {{ \Illuminate\Support\Str::plural('Night', $tour->duration_nights) }}
                    @elseif($tour->duration_days > 0)
                      {{ $tour->duration_days }} {{ \Illuminate\Support\Str::plural('Day', $tour->duration_days) }}
                    @else
                      {{ $tour->duration_nights }} {{ \Illuminate\Support\Str::plural('Night', $tour->duration_nights) }}
                    @endif
                  </h6>
                </div>
                @endif

                <div class="trip-info-box">
                  <div class="header">
                    <i class="fa-solid fa-users text-theme-color" style="font-size: 18px; margin-right: 8px;"></i>
                    <span>Guests</span>
                  </div>
                  <h6 class="info-title">
                    @if($tour->min_guests && $tour->max_guests)
                    {{ $tour->min_guests }}-{{ $tour->max_guests }}
                    @elseif($tour->min_guests)
                    Min {{ $tour->min_guests }}
                    @elseif($tour->max_guests)
                    Max {{ $tour->max_guests }}
                    @else
                    No Limit
                    @endif
                  </h6>
                </div>

                <div class="trip-info-box">
                  <div class="header">
                    <i class="fa-solid fa-barcode text-theme-color" style="font-size: 18px; margin-right: 8px;"></i>
                    <span>Tour Code</span>
                  </div>
                  <h6 class="info-title">{{ $tour->tour_code }}</h6>
                </div>
              </div>

              <!-- Destination Tabs menu -->
              <div class="destination-info-tabs">
                <ul class="custom-ul">
                  <li class="current"><a href="#overview-tab">Overview</a></li>
                  @if($tour->itineraries->count() > 0)
                  <li class=""><a href="#itinerary-tab">Itinerary</a></li>
                  @endif
                  @if($tour->inclusions || $tour->exclusions)
                  <li class=""><a href="#cost-tab">Inclusions</a></li>
                  @endif
                  @if($tour->faqs->count() > 0)
                  <li class=""><a href="#faq-tab">FAQs</a></li>
                  @endif
                  @if($tour->images->count() > 1)
                  <li class=""><a href="#gallery-tab">Gallery</a></li>
                  @endif
                </ul>
              </div>

              <!-- Tab content: Overview -->
              <div id="overview-tab" class="destination-overview tab-content">
                <h4 class="title">Overview</h4>
                <div class="tour-rich-content">
                  {!! $tour->overview !!}
                </div>

                @if(isset($additionalInclusions) && $additionalInclusions->count() > 0)
                <h4 class="title mt-4 pt-3">Additional Inclusions</h4>
                <div class="row g-3 mt-1">
                  @foreach($additionalInclusions as $inclusion)
                  <div class="col-sm-6 col-md-4">
                    <div class="d-flex align-items-center p-3 rounded-3" style="background: #f2f9f9; border: 1px solid rgba(0, 101, 108, 0.1);">
                      <span class="d-flex align-items-center justify-content-center text-white bg-theme-color rounded-2 me-3" style="width: 36px; height: 36px; font-size: 16px;">
                        <i class="{{ $inclusion->icon }}"></i>
                      </span>
                      <span class="fw-semibold text-title-color" style="font-size: 14px;">{{ $inclusion->name }}</span>
                    </div>
                  </div>
                  @endforeach
                </div>
                @endif
              </div>

              <!-- Tab content: Itinerary -->
              @if($tour->itineraries->count() > 0)
              <div id="itinerary-tab" class="destination-ltinerary tab-content">
                <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
                  <h4 class="title mb-0">Itinerary</h4>
                  <a href="#" class="expand-btn text-theme-color fw-bold" id="itinerary-expand-all" style="font-size: 14px; text-decoration: none;">Expand All</a>
                </div>
                <div class="d-flex gap-2 gap-xl-4">
                  <div class="progress-area">
                    <!-- SVG 1: Map Pin (first Day) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37" fill="none">
                      <circle cx="18.5" cy="18.5" r="18.5" fill="#00656c" />
                      <path d="M23.4463 11.5947C22.6394 10.934 21.6959 10.4606 20.6839 10.2087C19.6719 9.95679 18.6167 9.93261 17.5942 10.1379C16.2795 10.4074 15.07 11.0492 14.1098 11.9867C13.1496 12.9243 12.4791 14.1181 12.1782 15.4259C11.8773 16.7338 11.9587 18.1006 12.4127 19.3635C12.8667 20.6264 13.6742 21.7322 14.7389 22.5491C15.9546 23.4388 16.9896 24.552 17.7886 25.829L18.3331 26.7344C18.4022 26.8494 18.5 26.9445 18.6168 27.0106C18.7336 27.0766 18.8655 27.1114 18.9997 27.1114C19.1338 27.1114 19.2658 27.0766 19.3826 27.0106C19.4994 26.9445 19.5971 26.8494 19.6662 26.7344L20.1881 25.8648C20.8839 24.6416 21.8327 23.581 22.9711 22.7536C23.8637 22.1395 24.6013 21.3264 25.1259 20.3784C25.6504 19.4304 25.9475 18.3734 25.9937 17.291C26.0398 16.2085 25.8338 15.1301 25.3918 14.1409C24.9499 13.1517 24.2841 12.2787 23.4471 11.5908L23.4463 11.5947ZM18.9989 20.1123C18.3836 20.1123 17.782 19.9298 17.2704 19.5879C16.7588 19.2461 16.36 18.7602 16.1245 18.1917C15.8891 17.6232 15.8275 16.9977 15.9475 16.3942C16.0675 15.7907 16.3639 15.2363 16.799 14.8012C17.2341 14.3661 17.7884 14.0698 18.3919 13.9497C18.9954 13.8297 19.621 13.8913 20.1895 14.1268C20.758 14.3623 21.2439 14.761 21.5857 15.2726C21.9276 15.7843 22.11 16.3858 22.11 17.0011C22.11 17.8262 21.7823 18.6176 21.1988 19.201C20.6153 19.7845 19.824 20.1123 18.9989 20.1123Z" fill="white" />
                    </svg>
                    <!-- SVG 2: Flag (last Day) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37" fill="none">
                      <circle cx="18.5" cy="18.5" r="18.5" fill="#00656c" />
                      <path d="M28.7986 16.489C28.611 16.3202 28.3423 16.2765 28.1173 16.3827C26.936 16.9202 26.2734 16.314 25.1984 15.1952C24.3796 14.3389 23.392 13.3138 21.967 13.4388C21.917 13.2576 21.7794 13.1076 21.5857 13.0388C21.2607 12.92 20.9044 13.0826 20.7856 13.4076L20.5356 14.0951L19.0012 18.3107L17.4667 14.0951L17.2167 13.4076C17.0979 13.0826 16.7354 12.92 16.4167 13.0388C16.2229 13.1076 16.0916 13.2576 16.0354 13.4388C14.6103 13.3076 13.6228 14.3389 12.7977 15.1952C11.7289 16.314 11.0664 16.9202 9.88507 16.3827C9.65381 16.2765 9.38505 16.3202 9.19751 16.489C9.01627 16.664 8.95378 16.9265 9.03504 17.164L10.7664 21.9205C10.8226 22.0768 10.9414 22.2018 11.0976 22.2706C11.5851 22.4956 12.0289 22.5893 12.4352 22.5893C13.729 22.5893 14.6541 21.6268 15.4354 20.8142C16.4354 19.7766 17.073 19.1766 18.1167 19.5391L18.3364 20.1435L16.7479 24.5081C16.6292 24.8332 16.7917 25.1894 17.1167 25.3082C17.4799 25.4292 17.8146 25.2311 17.9167 24.9394L18.9998 21.9688L20.0794 24.9394C20.2014 25.2649 20.562 25.4236 20.8794 25.3082C21.2044 25.1894 21.3732 24.8332 21.2544 24.5081L19.6662 20.1407L19.8856 19.5391C20.9294 19.1829 21.5732 19.7766 22.567 20.8142C23.342 21.6268 24.2671 22.5893 25.5671 22.5893C25.9734 22.5893 26.4172 22.4956 26.9047 22.2706C27.0547 22.2018 27.1735 22.0768 27.2297 21.9205L28.9611 17.164C29.0486 16.9265 28.9861 16.664 28.7986 16.489Z" fill="white" />
                    </svg>
                  </div>
                  <div class="accordion-style2 accordion flex-grow-1" id="tourItineraryAccordion">
                    @foreach($tour->itineraries as $index => $itinerary)
                    <div class="accordion-item">
                      <h6 class="accordion-header" id="itineraryHeading{{ $index }}">
                        <button
                          class="accordion-button @if(!$loop->first) collapsed @endif"
                          type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#itineraryCollapse{{ $index }}"
                          aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                          aria-controls="itineraryCollapse{{ $index }}">
                          Day 0{{ $index + 1 }} : {{ $itinerary->title }}
                        </button>
                      </h6>
                      <div
                        id="itineraryCollapse{{ $index }}"
                        class="accordion-collapse collapse @if($loop->first) show @endif"
                        aria-labelledby="itineraryHeading{{ $index }}"
                        data-bs-parent="#tourItineraryAccordion">
                        <div class="accordion-body">
                          {!! $itinerary->description !!}
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              @endif

              <!-- Tab content: Inclusions/Exclusions -->
              @if($tour->inclusions || $tour->exclusions)
              <div id="cost-tab" class="destination-cost tab-content">
                <h4 class="title">Inclusions & Exclusions</h4>
                @if($tour->inclusions)
                <div class="includes">
                  <h5 class="sub-title text-success"><i class="fa-solid fa-circle-check me-2"></i>What's Included</h5>
                  <div class="inc-list-styled">
                    {!! $tour->inclusions !!}
                  </div>
                </div>
                @endif
                @if($tour->exclusions)
                <div class="excludes mt-4">
                  <h5 class="sub-title text-danger"><i class="fa-solid fa-circle-xmark me-2"></i>What's Excluded</h5>
                  <div class="exc-list-styled">
                    {!! $tour->exclusions !!}
                  </div>
                </div>
                @endif
              </div>
              @endif

              <!-- Tab content: FAQs -->
              @if($tour->faqs->count() > 0)
              <div id="faq-tab" class="destination-faq tab-content">
                <h4 class="title">FAQs & Important Information</h4>
                <div class="accordion-style2 accordion" id="tourFaqAccordion">
                  @foreach($tour->faqs as $index => $faq)
                  <div class="accordion-item">
                    <h6 class="accordion-header" id="faqHeading{{ $faq->id }}">
                      <button
                        class="accordion-button @if(!$loop->first) collapsed @endif"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faqCollapse{{ $faq->id }}"
                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="faqCollapse{{ $faq->id }}">
                        {{ $faq->question }}
                      </button>
                    </h6>
                    <div
                      id="faqCollapse{{ $faq->id }}"
                      class="accordion-collapse collapse @if($loop->first) show @endif"
                      aria-labelledby="faqHeading{{ $faq->id }}"
                      data-bs-parent="#tourFaqAccordion">
                      <div class="accordion-body">
                        {{ $faq->answer }}
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif

              <!-- Tab content: Gallery -->
              @if($tour->images->count() > 1)
              <div id="gallery-tab" class="destination-overview tab-content">
                <h4 class="title">Photo Gallery</h4>
                <div class="row g-2">
                  @foreach($tour->images as $index => $image)
                  <div class="col-4 col-sm-3 col-md-2">
                    <div class="gallery-thumb-item rounded-3 overflow-hidden {{ $index == 0 ? 'active' : '' }}" style="cursor: pointer; height: 80px; border: 2px solid {{ $index == 0 ? '#00656c' : 'transparent' }};" onclick="changeMainImage('{{ asset($image->image_path) }}', this)">
                      <img src="{{ asset($image->image_path) }}" alt="Thumbnail" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif


            </div>
          </div>
        </div>
      </div>

      <!-- Right Sidebar -->
      <div class="col-lg-4">
        <div class="sidebar-area tours-sidebar">

          <!-- Price widget -->
          <div class="widget widget_trip-Availability accordion" id="accordionTripAvailability">
            <div class="accordion-item">
              <h6 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1">
                  Tour Pricing
                </button>
              </h6>
              <div id="collapseOne_1" class="accordion-collapse collapse show" data-bs-parent="#accordionTripAvailability">
                <div class="accordion-body">
                  <div class="header">
                    @if($tour->discount_price)
                    @php
                    $discountPercent = round((($tour->original_price - $tour->discount_price) / $tour->original_price) * 100);
                    @endphp
                    <span class="offer">{{ $discountPercent }}% off</span>
                    @endif
                    <div class="package-wrapper d-flex justify-content-center py-3">
                      <div class="adult-price text-center">
                        <div class="title text-muted">
                          @if($tour->discount_price)
                          from <del>${{ number_format($tour->original_price, 0) }}</del>
                          @else
                          Price
                          @endif
                        </div>
                        <h5 class="price text-theme-color mb-0" style="font-size: 28px;">
                          ${{ number_format($tour->discount_price ?? $tour->original_price, 0) }}
                          <span class="text-muted" style="font-size: 14px; font-weight: normal;">/{{ $tour->price_type == 'per_person' ? 'person' : ($tour->price_type == 'per_vehicle' ? 'vehicle' : 'group') }}</span>
                        </h5>
                      </div>
                    </div>
                  </div>
                  <div class="body">
                    <ul class="custom-ul">
                      <li><i class="fa-solid fa-badge-check text-theme-color me-2"></i>Best Price Guaranteed</li>
                      <li><i class="fa-solid fa-badge-check text-theme-color me-2"></i>Secure Booking Guaranteed</li>
                      <li><i class="fa-solid fa-badge-check text-theme-color me-2"></i>Professional Local Guides</li>
                    </ul>
                  </div>
                  <div class="footer pt-3">
                    <a href="{{ url('contact?tour=' . urlencode($tour->slug)) }}" class="vs-btn style9 w-100 text-center text-uppercase">
                      Book Now
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Company details widget -->
          <div class="widget widget_trip" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); background: #fff; padding: 25px;">
            <h4 class="widget_title border-bottom pb-2 mb-3" style="font-size: 18px; font-weight: 700;"><i class="fa-solid fa-building me-2 text-theme-color"></i>Company Contacts</h4>
            <div class="d-flex flex-column gap-3">
              @if($company_setting->company_name)
              <div class="d-flex align-items-center">
                <span class="d-flex align-items-center justify-content-center bg-light text-theme-color rounded-circle me-3" style="width: 36px; height: 36px;"><i class="fa-solid fa-info"></i></span>
                <div>
                  <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase;">Agency</small>
                  <span class="fw-semibold text-title-color" style="font-size: 14px;">{{ $company_setting->company_name }}</span>
                </div>
              </div>
              @endif

              @if($company_setting->phone)
              <div class="d-flex align-items-center">
                <span class="d-flex align-items-center justify-content-center bg-light text-theme-color rounded-circle me-3" style="width: 36px; height: 36px;"><i class="fa-solid fa-phone"></i></span>
                <div>
                  <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase;">Call Us</small>
                  <a href="tel:{{ $company_setting->phone }}" class="fw-semibold text-title-color hover-theme" style="font-size: 14px;">{{ $company_setting->phone }}</a>
                </div>
              </div>
              @endif

              @if($company_setting->whatsapp)
              <div class="d-flex align-items-center">
                <span class="d-flex align-items-center justify-content-center bg-light text-success rounded-circle me-3" style="width: 36px; height: 36px;"><i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i></span>
                <div>
                  <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase;">WhatsApp</small>
                  <a href="https://wa.me/{{ $company_setting->whatsapp }}" target="_blank" class="fw-semibold text-title-color hover-theme" style="font-size: 14px;">{{ $company_setting->whatsapp }}</a>
                </div>
              </div>
              @endif

              @if($company_setting->company_email)
              <div class="d-flex align-items-center">
                <span class="d-flex align-items-center justify-content-center bg-light text-theme-color rounded-circle me-3" style="width: 36px; height: 36px;"><i class="fa-solid fa-envelope"></i></span>
                <div>
                  <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase;">Email</small>
                  <a href="mailto:{{ $company_setting->company_email }}" class="fw-semibold text-title-color hover-theme" style="font-size: 14px;">{{ $company_setting->company_email }}</a>
                </div>
              </div>
              @endif
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
<!--================= Destination Details end =================-->

<!--================= Related Tours Section start =================-->
@php
  $relatedTours = $tour->related_tours_models;
@endphp

@if($relatedTours && $relatedTours->count() > 0)
<section class="vs-tour-package space-bottom bg-theme-07">
  <div class="container border-top pt-5">
    <div class="row justify-content-center text-center">
      <div class="col-xl-6 col-lg-8 col-md-10">
        <div class="section-title mb-45">
          <span class="sub-title text-theme-color">Recommended</span>
          <h2 class="title h1">Related Tours</h2>
        </div>
      </div>
    </div>
    <div class="row g-4 justify-content-center">
      @foreach($relatedTours as $rt)
      <div class="col-md-6 col-xl-4">
        <div class="tour-package-box style-3 bg-white-color shadow-sm" style="border-radius: 15px; overflow: hidden;">
          <div class="tour-package-thumb">
            <a href="{{ url('tour/' . $rt->slug) }}">
              <img
                src="{{ $rt->images->count() > 0 ? asset($rt->images->first()->image_path) : asset('assets/img/tour-packages/tour-package-3-1.png') }}"
                alt="{{ $rt->name }}"
                class="w-100"
                style="height: 250px; object-fit: cover;"
              />
            </a>
          </div>
          <div class="tour-package-content p-4">
            <div class="location mb-2" style="font-size: 13px; color: var(--text-color);">
              <i class="fa-sharp fa-light fa-location-dot text-theme-color me-1"></i>
              <span>{{ $rt->destinations->pluck('name')->implode(', ') }}</span>
            </div>
            <h5 class="title line-clamp-2" style="font-size: 18px; font-weight: 700; margin-bottom: 15px;">
              <a href="{{ url('tour/' . $rt->slug) }}" class="text-title-color hover-theme" title="{{ $rt->name }}">{{ $rt->name }}</a>
            </h5>
            <div class="tour-package-footer d-flex justify-content-between align-items-center pt-3 border-top">
              <div class="tour-duration d-flex align-items-center gap-1 text-muted" style="font-size: 13px;">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 0C3.58888 0 0 3.58888 0 8C0 12.4111 3.58888 16 8 16C12.4111 16 16 12.4111 16 8C16 3.58888 12.4111 0 8 0ZM8 15C4.14013 15 1 11.8599 1 8C1 4.14013 4.14013 1 8 1C11.8599 1 15 4.14013 15 8C15 11.8599 11.8599 15 8 15Z" fill="#556065" />
                  <path d="M8.5 3H7.5V8.20702L10.6465 11.3535L11.3535 10.6465L8.5 7.79295V3Z" fill="#556065" />
                </svg>
                <span>
                  @if($rt->duration_days > 0)
                    {{ $rt->duration_days }} {{ \Illuminate\Support\Str::plural('Day', $rt->duration_days) }}
                  @endif
                  @if($rt->duration_nights > 0)
                    {{ $rt->duration_days > 0 ? '/' : '' }} {{ $rt->duration_nights }} {{ \Illuminate\Support\Str::plural('Night', $rt->duration_nights) }}
                  @endif
                </span>
              </div>
              <div class="pricing-info fw-medium">
                @if($rt->discount_price)
                  <del class="text-muted me-1">${{ number_format($rt->original_price, 0) }}</del>
                  <h5 class="new-price text-theme-color d-inline-block mb-0">${{ number_format($rt->discount_price, 0) }}</h5>
                @else
                  <h5 class="new-price text-theme-color mb-0">${{ number_format($rt->original_price, 0) }}</h5>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif
<!--================= Related Tours Section end =================-->

<!-- Sticky Bottom Action Bar -->
<div class="sticky-bottom-bar">
  <div class="bottom-btn-group">
    @if($company_setting->phone)
    <a href="tel:{{ $company_setting->phone }}" class="bottom-btn btn-call">
      <i class="fa fa-phone"></i> Call Now
    </a>
    @endif

    <a href="{{ url('contact?tour=' . urlencode($tour->slug)) }}" class="bottom-btn btn-enquire">
      <i class="fa fa-paper-plane"></i> Enquire
    </a>

    @if($company_setting->whatsapp)
    <a href="https://wa.me/{{ $company_setting->whatsapp }}?text=Hi,%20I'm%20interested%20in%20the%20tour:%20{{ urlencode($tour->name) }}%20(Code:%20{{ $tour->tour_code }})" target="_blank" class="bottom-btn btn-whatsapp">
      <i class="fa-brands fa-whatsapp"></i> WhatsApp
    </a>
    @endif
  </div>
</div>

<!-- Trip Planner Popup -->
<div class="trip-planner-overlay" id="trip-planner-popup">
  <div class="trip-planner-box">
    <button class="trip-planner-close" onclick="closeTripPlannerPopup()">&times;</button>
    <h3 class="trip-planner-title">Hey! Are you looking for help in planning your trip?</h3>

    <div class="trip-options-grid">
      <div class="trip-option-card active" onclick="selectTripType(this, 'family')">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="16" cy="18" r="5" fill="#fbcfe8" stroke="#334155" stroke-width="2" />
          <path d="M8 32C8 26.4772 12.4772 24 16 24C19.5228 24 24 26.4772 24 32V38H8V32Z" fill="#38bdf8" stroke="#334155" stroke-width="2" />
          <circle cx="32" cy="18" r="5" fill="#fed7aa" stroke="#334155" stroke-width="2" />
          <path d="M24 32C24 26.4772 28.4772 24 32 24C35.5228 24 40 26.4772 40 32V38H24V32Z" fill="#f472b6" stroke="#334155" stroke-width="2" />
          <circle cx="24" cy="27" r="4" fill="#fde047" stroke="#334155" stroke-width="2" />
          <path d="M18 38C18 34 21 32 24 32C27 32 30 34 30 38V41H18V38Z" fill="#4ade80" stroke="#334155" stroke-width="2" />
        </svg>
        <span>Family Trip</span>
      </div>

      <div class="trip-option-card" onclick="selectTripType(this, 'honeymoon')">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M24 13.5C24 13.5 22.5 10 20 10C17.5 10 16 11.5 16 13.5C16 16.5 20.5 19 24 21C27.5 19 32 16.5 32 13.5C32 11.5 30.5 10 28 10C25.5 10 24 13.5 24 13.5Z" fill="#ef4444" />
          <circle cx="16" cy="24" r="5" fill="#38bdf8" stroke="#334155" stroke-width="2" />
          <path d="M8 38C8 32.4772 12.4772 30 16 30C19.5228 30 24 32.4772 24 38V41H8V38Z" fill="#0284c7" stroke="#334155" stroke-width="2" />
          <circle cx="32" cy="24" r="5" fill="#fbcfe8" stroke="#334155" stroke-width="2" />
          <path d="M24 38C24 32.4772 28.4772 30 32 30C35.5228 30 40 32.4772 40 38V41H24V38Z" fill="#ec4899" stroke="#334155" stroke-width="2" />
        </svg>
        <span>Honeymoon</span>
      </div>

      <div class="trip-option-card" onclick="selectTripType(this, 'friends')">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="17" cy="20" r="6" fill="#fde047" stroke="#334155" stroke-width="2" />
          <path d="M8 36C8 30 13 28 17 28C21 28 26 30 26 36V40H8V36Z" fill="#38bdf8" stroke="#334155" stroke-width="2" />
          <circle cx="31" cy="20" r="6" fill="#fed7aa" stroke="#334155" stroke-width="2" />
          <path d="M22 36C22 30 27 28 31 28C35 28 40 30 40 36V40H22V36Z" fill="#4ade80" stroke="#334155" stroke-width="2" />
        </svg>
        <span>With Friends</span>
      </div>

      <div class="trip-option-card" onclick="selectTripType(this, 'group')">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="24" cy="15" r="4.5" fill="#fed7aa" stroke="#334155" stroke-width="1.5" />
          <path d="M17 27C17 22.5 20.5 21 24 21C27.5 21 31 22.5 31 27V30H17V27Z" fill="#818cf8" stroke="#334155" stroke-width="1.5" />
          <circle cx="14" cy="23" r="4.5" fill="#fde047" stroke="#334155" stroke-width="1.5" />
          <path d="M7 35C7 30.5 10.5 29 14 29C17.5 29 21 30.5 21 35V38H7V35Z" fill="#f472b6" stroke="#334155" stroke-width="1.5" />
          <circle cx="34" cy="23" r="4.5" fill="#fbcfe8" stroke="#334155" stroke-width="1.5" />
          <path d="M27 35C27 30.5 30.5 29 34 29C37.5 29 41 30.5 41 35V38H27V35Z" fill="#2dd4bf" stroke="#334155" stroke-width="1.5" />
          <circle cx="24" cy="26" r="4.5" fill="#fed7aa" stroke="#334155" stroke-width="1.5" />
          <path d="M17 38C17 33.5 20.5 32 24 32C27.5 32 31 33.5 31 38V41H17V38Z" fill="#fb7185" stroke="#334155" stroke-width="1.5" />
        </svg>
        <span>Group Trip</span>
      </div>

      <div class="trip-option-card solo-option" onclick="selectTripType(this, 'solo')">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="24" cy="18" r="7" fill="#fed7aa" stroke="#334155" stroke-width="2" />
          <path d="M12 36C12 28.5 18 26 24 26C30 26 36 28.5 36 36V40H12V36Z" fill="#38bdf8" stroke="#334155" stroke-width="2" />
        </svg>
        <span>Solo Trip</span>
      </div>
    </div>

    <a href="{{ url('contact?tour=' . urlencode($tour->slug) . '&trip_type=family') }}" id="popup-cta-btn" class="vs-btn style4 w-100 py-3 mt-2 text-center text-white" style="display: block; box-shadow: 0 4px 15px rgba(247,146,31,0.3); transition: all 0.3s;">Get a FREE Holiday Plan</a>
  </div>
</div>

<script>
  // Tab switcher logic
  document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.destination-info-tabs a');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
      tab.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');

        // Update active state in tabs
        tabs.forEach(t => t.parentElement.classList.remove('current'));
        this.parentElement.classList.add('current');

        // Show target content
        contents.forEach(content => {
          if ('#' + content.id === targetId) {
            content.style.display = 'block';
          } else {
            content.style.display = 'none';
          }
        });
      });
    });

    // Hide all tab contents initially except the first one
    contents.forEach((content, index) => {
      if (index === 0) {
        content.style.display = 'block';
      } else {
        content.style.display = 'none';
      }
    });
  });

  // Main image switcher logic
  function changeMainImage(src, thumbElement) {
    const mainImg = document.querySelector('#main-tour-hero-img img');
    if (mainImg) {
      mainImg.src = src;
    }

    // Highlight active thumbnail
    document.querySelectorAll('.gallery-thumb-item').forEach(item => {
      item.style.borderColor = 'transparent';
      item.classList.remove('active');
    });
    thumbElement.style.borderColor = '#00656c';
    thumbElement.classList.add('active');
  }

  // Select trip type helper
  let selectedType = 'family';

  function selectTripType(element, type) {
    document.querySelectorAll('.trip-option-card').forEach(card => {
      card.classList.remove('active');
    });
    element.classList.add('active');
    selectedType = type;

    const ctaBtn = document.getElementById('popup-cta-btn');
    if (ctaBtn) {
      const baseUrl = "{{ url('contact?tour=' . urlencode($tour->slug)) }}";
      ctaBtn.href = `${baseUrl}&trip_type=${selectedType}`;
    }
  }

  function closeTripPlannerPopup() {
    const popup = document.getElementById('trip-planner-popup');
    if (popup) {
      popup.classList.remove('active');
    }
  }

  // Auto-reveal popup logic
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      const popup = document.getElementById('trip-planner-popup');
      if (popup) {
        popup.classList.add('active');
      }
    }, 1500); // 1.5s delay

    // Overlay close trigger
    const overlay = document.getElementById('trip-planner-popup');
    if (overlay) {
      overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
          closeTripPlannerPopup();
        }
      });
    }

    // Itinerary Expand All / Collapse All Toggle
    const expandAllBtn = document.getElementById('itinerary-expand-all');
    if (expandAllBtn) {
      expandAllBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const accordionButtons = document.querySelectorAll('#tourItineraryAccordion .accordion-button');
        const accordionCollapses = document.querySelectorAll('#tourItineraryAccordion .accordion-collapse');

        const isExpandAll = this.textContent === 'Expand All';

        accordionButtons.forEach(btn => {
          if (isExpandAll) {
            btn.classList.remove('collapsed');
            btn.setAttribute('aria-expanded', 'true');
          } else {
            btn.classList.add('collapsed');
            btn.setAttribute('aria-expanded', 'false');
          }
        });

        accordionCollapses.forEach(collapse => {
          if (isExpandAll) {
            collapse.classList.add('show');
          } else {
            collapse.classList.remove('show');
          }
        });

        this.textContent = isExpandAll ? 'Collapse All' : 'Expand All';
      });
    }
  });
</script>
@endsection