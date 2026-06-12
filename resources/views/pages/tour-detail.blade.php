@extends('layouts.app')

@section('content')
<style>
    /* Premium Page Styles */
    .tour-hero {
        position: relative;
        height: 60vh;
        min-height: 400px;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: flex-end;
        color: #fff;
    }
    .tour-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 100%);
        z-index: 1;
    }
    .tour-hero-content {
        position: relative;
        z-index: 2;
        padding-bottom: 50px;
        width: 100%;
    }
    .tour-badge {
        background: #f15d30;
        color: #fff;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 15px;
    }
    .tour-title {
        color: #f15d30;
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 10px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    @media (max-width: 768px) {
        .tour-title { font-size: 2rem; }
    }
    .tour-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 20px;
        margin-top: 10px;
    }
    .tour-meta-item {
        display: inline-flex;
        align-items: center;
        font-size: 1.05rem;
        opacity: 0.95;
        color: #ffffff;
    }
    .tour-meta-item i {
        margin-right: 8px;
        color: #f15d30;
    }

    /* Details Layout */
    .tour-detail-container {
        padding-top: 60px;
        padding-bottom: 100px;
    }

    .tour-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        padding: 30px;
        margin-bottom: 30px;
    }
    .tour-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tour-card-title i {
        color: #f15d30;
    }

    /* Price Panel */
    .price-panel {
        background: linear-gradient(135deg, #f15d30 0%, #ff8e53 100%);
        color: #fff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 15px 35px rgba(241,93,48,0.25);
        margin-bottom: 30px;
    }
    .price-amount {
        font-size: 2.5rem;
        font-weight: 800;
        display: flex;
        align-items: baseline;
    }
    .price-amount del {
        font-size: 1.3rem;
        opacity: 0.7;
        margin-right: 15px;
    }
    .price-amount span {
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
        margin-left: 5px;
    }

    /* Inclusions / Exclusions */
    .inc-exc-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
    @media (max-width: 768px) {
        .inc-exc-grid { grid-template-columns: 1fr; }
    }
    .inc-list, .exc-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .inc-list ul, .exc-list ul, .inc-list ol, .exc-list ol {
        list-style: none !important;
        list-style-type: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .inc-list li, .exc-list li {
        list-style: none !important;
        list-style-type: none !important;
        position: relative;
        padding-left: 25px !important;
        margin-bottom: 12px;
        font-size: 1rem;
        color: #4b5563;
        line-height: 1.5;
    }
    .inc-list li::before {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free', 'FontAwesome';
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 2px;
        color: #10B981;
        font-size: 1rem;
    }
    .exc-list li::before {
        content: '\f00d';
        font-family: 'Font Awesome 6 Free', 'FontAwesome';
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 2px;
        color: #EF4444;
        font-size: 1rem;
    }

    /* Vertical Timeline Itinerary */
    .timeline {
        position: relative;
        padding-left: 30px;
        border-left: 3px solid #f3f4f6;
        margin-left: 10px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 40px;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-badge {
        position: absolute;
        left: -47px;
        top: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f15d30;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(241,93,48,0.3);
    }
    .timeline-content h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
    }
    .timeline-content p {
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
    }

    /* Thumbnail Gallery */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }
    .gallery-thumb {
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s;
    }
    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .gallery-thumb:hover, .gallery-thumb.active {
        border-color: #f15d30;
        transform: scale(1.05);
    }

    /* Contact Details Grid */
    .contact-card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    @media (max-width: 576px) {
        .contact-card-grid { grid-template-columns: 1fr; }
    }
    .contact-grid-item {
        background: #f9fafb;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #f3f4f6;
    }
    .contact-grid-item i {
        font-size: 1.5rem;
        color: #f15d30;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .contact-grid-item h5 {
        font-size: 0.8rem;
        color: #6b7280;
        text-transform: uppercase;
        margin: 0 0 3px 0;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .contact-grid-item p {
        font-size: 0.95rem;
        color: #111827;
        margin: 0;
        font-weight: 500;
    }

    /* Sticky Bottom Bar */
    .sticky-bottom-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-top: 1px solid rgba(229, 231, 235, 0.5);
        box-shadow: 0 -8px 30px rgba(0,0,0,0.08);
        z-index: 1000;
        padding: 15px 0;
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
    }
    .bottom-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 15px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none !important;
        border: none;
    }
    .bottom-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .btn-call {
        background: #F15A29;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(241,90,41,0.3);
    }
    .btn-enquire {
        background: #111827;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(17,24,39,0.3);
    }
    .btn-whatsapp {
        background: #25D366;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(37,211,102,0.3);
    }
    
    /* Extra padding for content spacing */
    body {
        padding-bottom: 80px;
        overflow-x: hidden;
    }

    /* Responsive overrides for smaller screens */
    @media (max-width: 768px) {
        .tour-card {
            padding: 20px !important;
            margin-bottom: 20px !important;
            border-radius: 12px !important;
        }
        .tour-card-title {
            font-size: 1.25rem !important;
            margin-bottom: 15px !important;
            padding-bottom: 8px !important;
        }
        .timeline {
            padding-left: 20px !important;
        }
        .timeline-badge {
            left: -33px !important;
            width: 26px !important;
            height: 26px !important;
            font-size: 0.8rem !important;
        }
        .timeline-content h4 {
            font-size: 1.1rem !important;
            margin-bottom: 6px !important;
        }
        .timeline-content p, .timeline-content div {
            font-size: 0.9rem !important;
            line-height: 1.5 !important;
        }
        /* Decrease description and general text sizes inside card */
        .tour-card p, .tour-card li, .tour-card div, .tour-card span {
            font-size: 0.9rem !important;
            line-height: 1.6 !important;
        }
        .inc-exc-grid h4 {
            font-size: 1.05rem !important;
            margin-bottom: 10px !important;
        }
    }

    @media (max-width: 480px) {
        .tour-card {
            padding: 15px !important;
        }
        .bottom-btn-group {
            gap: 6px !important;
            padding: 0 10px !important;
        }
        .bottom-btn {
            font-size: 0.75rem !important;
            padding: 8px 10px !important;
            gap: 4px !important;
            white-space: nowrap !important;
        }
        .bottom-btn i {
            font-size: 0.85rem !important;
        }
    }

    /* Trip Planner Popup Styles */
    .trip-planner-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
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
        font-size: 1.25rem;
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
        font-size: 1.35rem;
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
        background: #fff8f7;
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
        background: #fff3f1;
        border-color: #f15d30;
        box-shadow: 0 4px 15px rgba(241, 93, 48, 0.12);
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
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
    }
    #popup-cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(241,93,48,0.4);
    }

    /* Additional Inclusions Styles */
    .additional-inclusions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    .inclusion-item-box {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: #fff8f5; /* Subtle orange tint */
        border: 1px solid rgba(241, 93, 48, 0.1);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .inclusion-item-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(241, 93, 48, 0.08);
        border-color: rgba(241, 93, 48, 0.3);
    }
    .inclusion-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: #f15d30;
        color: #fff;
        border-radius: 8px;
        font-size: 1.1rem;
        box-shadow: 0 4px 10px rgba(241, 93, 48, 0.2);
    }
    .inclusion-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: #374151;
    }
</style>

@php
    $featuredImage = $tour->images->count() > 0 ? asset($tour->images->first()->image_path) : asset('images/destination-1.jpg');
@endphp

<!-- Hero Section -->
<section class="tour-hero" style="background-image: url('{{ $featuredImage }}');" id="main-tour-hero">
    <div class="overlay"></div>
    <div class="container tour-hero-content">
        <div class="row">
            <div class="col-md-12">
                <span class="tour-badge">{{ $tour->category->name ?? 'Adventure' }}</span>
                <h1 class="tour-title">{{ $tour->name }}</h1>
                <div class="tour-meta">
                    <span class="tour-meta-item"><i class="fa fa-map-marker"></i> {{ $tour->destination->name }}</span>
                    @if($tour->duration_days > 0 || $tour->duration_nights > 0)
                        <span class="tour-meta-item"><i class="fa fa-clock"></i> @if($tour->duration_days > 0){{ $tour->duration_days }} {{ \Illuminate\Support\Str::plural('Day', $tour->duration_days) }}@endif @if($tour->duration_nights > 0){{ $tour->duration_days > 0 ? '/' : '' }} {{ $tour->duration_nights }} {{ \Illuminate\Support\Str::plural('Night', $tour->duration_nights) }}@endif</span>
                    @endif
                    <span class="tour-meta-item"><i class="fa fa-tag"></i> Code: {{ $tour->tour_code }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Grid -->
<div class="container tour-detail-container">
    <div class="row">
        <!-- Left Column: Details -->
        <div class="col-lg-8">
            <!-- Overview -->
            @if($tour->overview)
            <div class="tour-card">
                <h3 class="tour-card-title"><i class="fa fa-file-text"></i> Overview</h3>
                <div style="color: #4b5563; line-height: 1.7;">
                    {!! $tour->overview !!}
                </div>
            </div>
            @endif

            <!-- Additional Inclusions -->
            @if(isset($additionalInclusions) && $additionalInclusions->count() > 0)
            <div class="tour-card">
                <h3 class="tour-card-title"><i class="fa-solid fa-square-plus"></i> Additional Inclusions</h3>
                <div class="additional-inclusions-grid">
                    @foreach($additionalInclusions as $inclusion)
                        <div class="inclusion-item-box">
                            <div class="inclusion-icon-wrapper">
                                <i class="{{ $inclusion->icon }}"></i>
                            </div>
                            <span class="inclusion-name">{{ $inclusion->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Itinerary -->
            @if($tour->itineraries->count() > 0)
            <div class="tour-card">
                <h3 class="tour-card-title"><i class="fa fa-map-signs"></i> Planned Itinerary</h3>
                <div class="timeline">
                    @foreach($tour->itineraries as $index => $itinerary)
                    <div class="timeline-item">
                        <div class="timeline-badge">{{ $index + 1 }}</div>
                        <div class="timeline-content">
                            <h4>{{ $itinerary->title }}</h4>
                            <div style="color: #4b5563;">
                                {!! $itinerary->description !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Inclusions and Exclusions -->
            @if($tour->inclusions || $tour->exclusions)
            <div class="tour-card">
                <h3 class="tour-card-title"><i class="fa fa-exchange"></i> Inclusions & Exclusions</h3>
                <div class="inc-exc-grid">
                    <div>
                        <h4 style="font-size: 1.15rem; font-weight: 700; color: #10B981; margin-bottom: 15px;"><i class="fa fa-check-circle"></i> What's Included</h4>
                        <div class="inc-list">
                            {!! $tour->inclusions ? $tour->inclusions : '<li>Standard services according to itinerary</li>' !!}
                        </div>
                    </div>
                    <div>
                        <h4 style="font-size: 1.15rem; font-weight: 700; color: #EF4444; margin-bottom: 15px;"><i class="fa fa-times-circle"></i> What's Excluded</h4>
                        <div class="exc-list">
                            {!! $tour->exclusions ? $tour->exclusions : '<li>Personal expenditures</li>' !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- FAQs -->
            @if($tour->faqs->count() > 0)
            <div class="tour-card">
                <h3 class="tour-card-title"><i class="fa fa-question-circle"></i> FAQs & Important Information</h3>
                <div class="accordion" id="tourFaqAccordion">
                    @foreach($tour->faqs as $index => $faq)
                    <div class="accordion-item" style="border: none; border-bottom: 1px solid #f3f4f6; padding: 15px 0;">
                        <h4 class="accordion-header" id="heading{{ $faq->id }}" style="margin: 0;">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false" aria-controls="collapse{{ $faq->id }}" style="background: transparent; border: none; width: 100%; text-align: left; padding: 0; font-weight: 700; color: #1f2937; font-size: 1.05rem; display: flex; justify-content: space-between; align-items: center;">
                                {{ $faq->question }}
                            </button>
                        </h4>
                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#tourFaqAccordion">
                            <div class="accordion-body" style="padding: 15px 0 0 0; color: #4b5563; line-height: 1.6; font-size: 0.95rem;">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Sidebar -->
        <div class="col-lg-4">
            <!-- Price Card -->
            <div class="price-panel text-center">
                <span style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; opacity: 0.9;">Tour Cost</span>
                <div class="price-amount justify-content-center">
                    @if($tour->discount_price)
                        <del>${{ number_format($tour->original_price, 0) }}</del>
                        ${{ number_format($tour->discount_price, 0) }}
                    @else
                        ${{ number_format($tour->original_price, 0) }}
                    @endif
                    <span>/ {{ $tour->price_type == 'per_person' ? 'person' : ($tour->price_type == 'per_vehicle' ? 'vehicle' : 'group') }}</span>
                </div>
                
                <hr style="border-top: 1px solid rgba(255,255,255,0.2); margin: 20px 0;">
                
                <div class="row text-start" style="font-size: 0.9rem;">
                    @if($tour->min_guests || $tour->max_guests)
                    <div class="col-6 mb-2">
                        <i class="fa fa-users"></i> Min Guests: <strong>{{ $tour->min_guests ?? 1 }}</strong>
                    </div>
                    <div class="col-6 mb-2">
                        <i class="fa fa-users"></i> Max Guests: <strong>{{ $tour->max_guests ?? 'Unlimited' }}</strong>
                    </div>
                    @endif
                    <div class="col-12">
                        <i class="fa fa-shield"></i> Secure Booking Guaranteed
                    </div>
                </div>
            </div>

            <!-- Tour Images Gallery -->
            @if($tour->images->count() > 1)
            <div class="tour-card">
                <h3 class="tour-card-title"><i class="fa fa-picture-o"></i> Photo Gallery</h3>
                <div class="gallery-grid">
                    @foreach($tour->images as $index => $image)
                    <div class="gallery-thumb {{ $index == 0 ? 'active' : '' }}" onclick="changeHeroImage('{{ asset($image->image_path) }}', this)">
                        <img src="{{ asset($image->image_path) }}" alt="Thumbnail">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Company Contact Grid -->
            <div class="tour-card">
                <h3 class="tour-card-title"><i class="fa fa-building"></i> Company Contacts</h3>
                <div class="contact-card-grid">
                    @if($company_setting->company_name)
                    <div class="contact-grid-item" style="grid-column: span 2;">
                        <i class="fa fa-info"></i>
                        <div>
                            <h5>Agency</h5>
                            <p>{{ $company_setting->company_name }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($company_setting->phone)
                    <div class="contact-grid-item" style="grid-column: span 2;">
                        <i class="fa fa-phone"></i>
                        <div>
                            <h5>Call Us</h5>
                            <p><a href="tel:{{ $company_setting->phone }}" style="color: inherit; text-decoration: none;">{{ $company_setting->phone }}</a></p>
                        </div>
                    </div>
                    @endif
                    
                    @if($company_setting->whatsapp)
                    <div class="contact-grid-item" style="grid-column: span 2;">
                        <i class="fa fa-whatsapp" style="color: #25D366;"></i>
                        <div>
                            <h5>WhatsApp</h5>
                            <p><a href="https://wa.me/{{ $company_setting->whatsapp }}" target="_blank" style="color: inherit; text-decoration: none;">{{ $company_setting->whatsapp }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($company_setting->company_email)
                    <div class="contact-grid-item" style="grid-column: span 2;">
                        <i class="fa fa-envelope"></i>
                        <div>
                            <h5>Email</h5>
                            <p><a href="mailto:{{ $company_setting->company_email }}" style="color: inherit; text-decoration: none;">{{ $company_setting->company_email }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($company_setting->working_days || $company_setting->working_time)
                    <div class="contact-grid-item" style="grid-column: span 2;">
                        <i class="fa fa-calendar"></i>
                        <div>
                            <h5>Office Hours</h5>
                            <p>{{ $company_setting->working_days ?? 'Mon - Sat' }}<br><small class="text-muted">{{ $company_setting->working_time ?? '9:00 AM - 6:00 PM' }}</small></p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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
                <i class="fa fa-whatsapp"></i> WhatsApp
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
                    <circle cx="16" cy="18" r="5" fill="#fbcfe8" stroke="#334155" stroke-width="2"/>
                    <path d="M8 32C8 26.4772 12.4772 24 16 24C19.5228 24 24 26.4772 24 32V38H8V32Z" fill="#38bdf8" stroke="#334155" stroke-width="2"/>
                    <circle cx="32" cy="18" r="5" fill="#fed7aa" stroke="#334155" stroke-width="2"/>
                    <path d="M24 32C24 26.4772 28.4772 24 32 24C35.5228 24 40 26.4772 40 32V38H24V32Z" fill="#f472b6" stroke="#334155" stroke-width="2"/>
                    <circle cx="24" cy="27" r="4" fill="#fde047" stroke="#334155" stroke-width="2"/>
                    <path d="M18 38C18 34 21 32 24 32C27 32 30 34 30 38V41H18V38Z" fill="#4ade80" stroke="#334155" stroke-width="2"/>
                </svg>
                <span>Family Trip</span>
            </div>
            
            <div class="trip-option-card" onclick="selectTripType(this, 'honeymoon')">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24 13.5C24 13.5 22.5 10 20 10C17.5 10 16 11.5 16 13.5C16 16.5 20.5 19 24 21C27.5 19 32 16.5 32 13.5C32 11.5 30.5 10 28 10C25.5 10 24 13.5 24 13.5Z" fill="#ef4444"/>
                    <circle cx="16" cy="24" r="5" fill="#38bdf8" stroke="#334155" stroke-width="2"/>
                    <path d="M8 38C8 32.4772 12.4772 30 16 30C19.5228 30 24 32.4772 24 38V41H8V38Z" fill="#0284c7" stroke="#334155" stroke-width="2"/>
                    <circle cx="32" cy="24" r="5" fill="#fbcfe8" stroke="#334155" stroke-width="2"/>
                    <path d="M24 38C24 32.4772 28.4772 30 32 30C35.5228 30 40 32.4772 40 38V41H24V38Z" fill="#ec4899" stroke="#334155" stroke-width="2"/>
                </svg>
                <span>Honeymoon</span>
            </div>
            
            <div class="trip-option-card" onclick="selectTripType(this, 'friends')">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="17" cy="20" r="6" fill="#fde047" stroke="#334155" stroke-width="2"/>
                    <path d="M8 36C8 30 13 28 17 28C21 28 26 30 26 36V40H8V36Z" fill="#38bdf8" stroke="#334155" stroke-width="2"/>
                    <circle cx="31" cy="20" r="6" fill="#fed7aa" stroke="#334155" stroke-width="2"/>
                    <path d="M22 36C22 30 27 28 31 28C35 28 40 30 40 36V40H22V36Z" fill="#4ade80" stroke="#334155" stroke-width="2"/>
                </svg>
                <span>With Friends</span>
            </div>
            
            <div class="trip-option-card" onclick="selectTripType(this, 'group')">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="24" cy="15" r="4.5" fill="#fed7aa" stroke="#334155" stroke-width="1.5"/>
                    <path d="M17 27C17 22.5 20.5 21 24 21C27.5 21 31 22.5 31 27V30H17V27Z" fill="#818cf8" stroke="#334155" stroke-width="1.5"/>
                    <circle cx="14" cy="23" r="4.5" fill="#fde047" stroke="#334155" stroke-width="1.5"/>
                    <path d="M7 35C7 30.5 10.5 29 14 29C17.5 29 21 30.5 21 35V38H7V35Z" fill="#f472b6" stroke="#334155" stroke-width="1.5"/>
                    <circle cx="34" cy="23" r="4.5" fill="#fbcfe8" stroke="#334155" stroke-width="1.5"/>
                    <path d="M27 35C27 30.5 30.5 29 34 29C37.5 29 41 30.5 41 35V38H27V35Z" fill="#2dd4bf" stroke="#334155" stroke-width="1.5"/>
                    <circle cx="24" cy="26" r="4.5" fill="#fed7aa" stroke="#334155" stroke-width="1.5"/>
                    <path d="M17 38C17 33.5 20.5 32 24 32C27.5 32 31 33.5 31 38V41H17V38Z" fill="#fb7185" stroke="#334155" stroke-width="1.5"/>
                </svg>
                <span>Group Trip</span>
            </div>
            
            <div class="trip-option-card solo-option" onclick="selectTripType(this, 'solo')">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="24" cy="18" r="7" fill="#fed7aa" stroke="#334155" stroke-width="2"/>
                    <path d="M12 36C12 28.5 18 26 24 26C30 26 36 28.5 36 36V40H12V36Z" fill="#38bdf8" stroke="#334155" stroke-width="2"/>
                </svg>
                <span>Solo Trip</span>
            </div>
        </div>
        
        <a href="{{ url('contact?tour=' . urlencode($tour->slug) . '&trip_type=family') }}" id="popup-cta-btn" class="btn w-100 py-3 mt-2" style="background: #f15d30; border-color: #f15d30; font-weight: 700; border-radius: 12px; font-size: 1.05rem; color: #fff; text-decoration: none; display: block; text-align: center; box-shadow: 0 4px 15px rgba(241,93,48,0.3); transition: all 0.3s;">Get a FREE Holiday Plan</a>
    </div>
</div>

<script>
    function changeHeroImage(src, thumbElement) {
        document.getElementById('main-tour-hero').style.backgroundImage = "url('" + src + "')";
        
        // Remove active class from all thumbnails
        document.querySelectorAll('.gallery-thumb').forEach(thumb => {
            thumb.classList.remove('active');
        });
        
        // Add active class to clicked thumbnail
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
        }, 1500); // 1.5s smooth organic delay

        // Overlay close trigger
        const overlay = document.getElementById('trip-planner-popup');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeTripPlannerPopup();
                }
            });
        }
    });
</script>
@endsection
