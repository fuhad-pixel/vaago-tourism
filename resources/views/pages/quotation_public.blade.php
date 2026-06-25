<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quotation->title ?? 'Travel Itinerary' }} - {{ $quotation->quotation_code }}</title>
    
    @if(isset($company_setting) && $company_setting->favicon_path)
        <link rel="icon" href="{{ asset($company_setting->favicon_path) }}" type="image/x-icon">
    @endif

    <!-- FontAwesome & Google Fonts (Outfit) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Standalone Modern & Professional Style System */
        :root {
            --primary: #005a60;
            --primary-dark: #003e43;
            --primary-light: rgba(0, 90, 96, 0.05);
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-secondary: #475569;
            --text-light: #94a3b8;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --font-outfit: 'Outfit', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-outfit);
            background-color: var(--bg-page);
            color: var(--text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Top Clean Header */
        .q-top-header {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .q-brand-logo {
            height: 40px;
            display: flex;
            align-items: center;
        }

        .q-brand-logo img {
            height: 100%;
            object-fit: contain;
        }

        .q-brand-fallback {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 1px;
        }

        .q-header-meta {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 600;
            background: var(--primary-light);
            color: var(--primary);
            padding: 6px 14px;
            border-radius: 6px;
        }

        /* Container wrapper */
        .q-view-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Hero Banner */
        .q-hero-section {
            position: relative;
            height: 380px;
            border-radius: 16px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            margin-bottom: 30px;
        }

        .q-hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.4) 60%, rgba(0,0,0,0.1) 100%);
            z-index: 1;
        }

        .q-hero-text {
            position: relative;
            z-index: 2;
            padding: 40px;
            color: #ffffff;
            width: 100%;
        }

        .q-hero-badge {
            background: var(--primary);
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .q-hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .q-hero-subtitle {
            font-size: 1.1rem;
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .q-hero-stats {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .q-stat-pill {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Route Chain */
        .q-route-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 30px;
        }

        .q-route-lbl {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-light);
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .q-route-nodes {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .q-route-item {
            background: #f1f5f9;
            padding: 5px 12px;
            border-radius: 6px;
        }

        .q-route-sep {
            color: var(--text-light);
            font-size: 0.8rem;
        }

        /* Sticky Timeline Nav */
        .q-timeline-nav {
            position: sticky;
            top: 71px; /* offset of top header */
            z-index: 999;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 0px; /* NO border radius on the wrapper */
            padding: 12px 0;
            margin-bottom: 30px;
            width: 100%;
        }

        .q-timeline-inner {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            scrollbar-width: none;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .q-timeline-inner {
                justify-content: flex-start;
            }
        }

        .q-timeline-inner::-webkit-scrollbar {
            display: none;
        }

        .q-timeline-btn {
            flex: 0 0 auto;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 0px; /* NO border radius on the button */
            padding: 6px 14px;
            text-decoration: none;
            color: var(--text-secondary);
            text-align: center;
            min-width: 70px;
            transition: all 0.25s ease;
        }

        .q-timeline-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .q-timeline-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
        }

        .q-timeline-btn .nav-mon {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            display: block;
            opacity: 0.8;
        }

        .q-timeline-btn .nav-num {
            font-size: 1.1rem;
            font-weight: 700;
            display: block;
            line-height: 1.1;
        }

        .q-timeline-btn .nav-day {
            font-size: 0.6rem;
            font-weight: 500;
            display: block;
            opacity: 0.7;
        }

        /* Day Cards */
        .q-day-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            margin-bottom: 40px;
            scroll-margin-top: 150px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.25fr 0.75fr;
        }

        @media (max-width: 992px) {
            .q-day-card {
                grid-template-columns: 1fr;
            }
        }

        /* Left Side: Text Details */
        .q-day-details {
            padding: 35px;
            border-right: 1px solid #f1f5f9;
        }

        @media (max-width: 992px) {
            .q-day-details {
                border-right: none;
                border-bottom: 1px solid #f1f5f9;
            }
        }

        .q-day-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .q-day-number {
            background: var(--primary);
            color: #ffffff;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .q-day-route {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .q-day-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 15px;
        }

        .q-specs-container {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 25px;
            padding: 10px 0;
        }

        .q-spec-block {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .q-spec-circle-icon {
            background: #e6f0f1;
            color: var(--primary);
            width: 42px;
            height: 42px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .q-spec-text-group {
            display: flex;
            flex-direction: column;
        }

        .q-spec-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-light);
            letter-spacing: 1px;
        }

        .q-spec-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .q-spec-divider {
            width: 1px;
            height: 35px;
            background-color: var(--border-color);
        }

        /* Accommodation Refined block */
        .q-hotel-card-refined {
            background: #fafaf9;
            border: 1px solid #e7e5e4;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .q-hotel-icon-circle {
            background: #e6f0f1;
            color: var(--primary);
            width: 48px;
            height: 48px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .q-hotel-text-info {
            flex-grow: 1;
        }

        .q-hotel-name-stars {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .q-hotel-name-lbl {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .q-hotel-stars-display {
            color: #eab308;
            font-size: 0.75rem;
        }

        .q-hotel-room-meals {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-top: 2px;
        }

        .q-hotel-btn-wrapper {
            flex-shrink: 0;
        }

        .q-hotel-btn {
            display: inline-block;
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .q-hotel-btn:hover {
            background: var(--primary);
            color: #ffffff;
        }

        /* Features block */
        .q-features-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .q-feature-col {
            display: flex;
            flex-direction: column;
        }

        .q-feature-lbl {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-light);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .q-feature-lbl i {
            color: var(--primary);
        }

        .q-pills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .q-pill {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .q-pill-highlight {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .q-pill-activity {
            background: #f0f9ff;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .q-pill-meal {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* Right Side: Media Gallery */
        .q-day-media {
            background: #f8fafc;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .q-media-hero {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 4/3;
            cursor: pointer;
            background: #e2e8f0;
            border: 1px solid var(--border-color);
        }

        .q-media-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .q-media-hero:hover img {
            transform: scale(1.04);
        }

        .q-media-zoom {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(0,0,0,0.6);
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            transition: all 0.3s;
        }

        .q-media-hero:hover .q-media-zoom {
            background: var(--primary);
        }

        .q-media-grid {
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .q-media-thumb {
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 1px solid var(--border-color);
            position: relative;
            background: #e2e8f0;
        }

        .q-media-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .q-media-thumb-more {
            position: absolute;
            inset: 0;
            background: rgba(0, 90, 96, 0.85);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }

        .q-media-note {
            font-size: 0.75rem;
            color: var(--text-light);
            text-align: center;
            margin-top: 10px;
            font-weight: 500;
        }

        /* Vehicle Showcase */
        .q-section-header {
            text-align: center;
            margin: 50px 0 25px;
        }

        .q-section-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .q-section-desc {
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .q-vehicles-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 380px));
            gap: 25px;
            justify-content: center;
        }

        .q-vehicle-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
        }

        .q-vehicle-img {
            height: 180px;
            background: #f1f5f9;
            position: relative;
        }

        .q-vehicle-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .q-vehicle-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--primary);
            color: #ffffff;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .q-vehicle-body {
            padding: 20px;
        }

        .q-vehicle-name {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .q-vehicle-meta {
            display: flex;
            gap: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 15px;
        }

        .q-driver-box {
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .q-driver-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .q-driver-initial {
            background: var(--primary-light);
            color: var(--primary);
            width: 36px;
            height: 36px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .q-driver-name {
            font-size: 0.9rem;
            font-weight: 700;
        }

        .q-driver-title {
            font-size: 0.7rem;
            color: var(--text-light);
            text-transform: uppercase;
            font-weight: 600;
        }

        .q-driver-wa {
            background: #f1f5f9;
            color: var(--text-secondary);
            width: 32px;
            height: 32px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
        }

        .q-driver-wa:hover {
            background: #25d366;
            color: #ffffff;
        }

        /* Inclusions & Exclusions Card */
        .q-inc-exc-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 35px;
            margin-top: 40px;
        }

        .q-inc-exc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .q-inc-exc-grid {
                grid-template-columns: 1fr;
            }
        }

        .q-inc-exc-panel {
            background: #fafaf9;
            border: 1px solid #e7e5e4;
            border-radius: 8px;
            padding: 20px;
        }

        .q-panel-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .q-inc-exc-panel.inc-panel .q-panel-title { color: #16a34a; }
        .q-inc-exc-panel.exc-panel .q-panel-title { color: #dc2626; }

        .q-list-items {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .q-list-row {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .q-list-row i {
            margin-top: 4px;
            font-size: 0.85rem;
        }

        .inc-panel .q-list-row i { color: #22c55e; }
        .exc-panel .q-list-row i { color: #ef4444; }

        /* 2-Column Billing & Summary Grid */
        .q-billing-summary-grid {
            display: grid;
            grid-template-columns: 1.25fr 0.75fr;
            gap: 30px;
            margin-top: 40px;
            width: 100%;
        }

        @media (max-width: 992px) {
            .q-billing-summary-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        /* Pricing Card Left */
        .q-pricing-details-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        .q-pricing-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .q-pricing-card-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .q-pricing-code-badge {
            background: #f1f5f9;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .q-billing-rows {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .q-billing-row {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            padding: 12px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
        }

        .q-billing-row:hover {
            border-color: var(--border-color);
            background: #f8fafc;
        }

        .q-billing-row-left {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .q-billing-row-left i {
            color: var(--primary);
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .q-billing-row-right {
            font-weight: 700;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .q-billing-row.discount-item {
            background: #fff5f5;
            border-color: #ffe3e3;
        }
        
        .q-billing-row.discount-item .q-billing-row-left i,
        .q-billing-row.discount-item .q-billing-row-right {
            color: #c53030;
        }

        .q-billing-grand-total-block {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .q-grand-total-info {
            display: flex;
            flex-direction: column;
        }

        .q-grand-total-lbl {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .q-grand-total-subtext {
            font-size: 0.7rem;
            color: var(--text-light);
            font-weight: 600;
            margin-top: 1px;
        }

        .q-grand-total-amount-green {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.5px;
        }

        .q-book-now-btn-full {
            background: var(--primary);
            color: #ffffff;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.05rem;
            width: 100%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 90, 96, 0.1);
        }

        .q-book-now-btn-full:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 90, 96, 0.15);
        }

        .q-pricing-footer-hint {
            font-size: 0.75rem;
            color: var(--text-light);
            text-align: center;
            margin-top: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Summary Card Right */
        .q-trip-summary-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .q-summary-card-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-main);
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .q-trip-visual-banner {
            height: 110px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .q-trip-visual-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.25);
            z-index: 1;
        }

        .q-trip-summary-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .q-summary-item {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.2s ease;
        }

        .q-summary-item:hover {
            border-color: var(--border-color);
            background: #f8fafc;
        }

        .q-summary-item-icon-circle {
            background: #e6f0f1;
            color: var(--primary);
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .q-summary-item-text-group {
            display: flex;
            flex-direction: column;
        }

        .q-summary-item-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .q-summary-item-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
        }

        /* Why Book Box */
        .q-why-book-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 15px 20px;
        }

        .q-why-book-title {
            font-size: 0.9rem;
            font-weight: 800;
            color: #166534;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .q-why-book-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .q-why-book-point {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #1b5e20;
        }

        .q-why-book-point i {
            color: #22c55e;
            font-size: 0.85rem;
        }

        /* Custom Lightbox Modal */
        .q-lightbox-modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.96);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }

        .q-lightbox-content {
            position: relative;
            max-width: 90vw;
            max-height: 85vh;
        }

        .q-lightbox-img {
            max-width: 100%;
            max-height: 85vh;
            object-fit: contain;
            border-radius: 8px;
        }

        .q-lightbox-close {
            position: absolute;
            top: -45px;
            right: 0;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 2.2rem;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .q-lightbox-close:hover {
            opacity: 1;
        }

        .q-lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            width: 44px;
            height: 44px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            z-index: 10;
        }

        .q-lightbox-nav:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .q-lightbox-prev { left: -60px; }
        .q-lightbox-next { right: -60px; }

        @media (max-width: 768px) {
            .q-lightbox-prev { left: 10px; }
            .q-lightbox-next { right: 10px; }
            .q-lightbox-close {
                top: 10px;
                right: 20px;
                background: rgba(0,0,0,0.5);
                width: 40px;
                height: 40px;
                border-radius: 100px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        .q-lightbox-cnt {
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Footer */
        .q-footer {
            text-align: center;
            padding: 40px 20px;
            font-size: 0.85rem;
            color: var(--text-light);
            border-top: 1px solid var(--border-color);
            background: #ffffff;
            margin-top: 60px;
        }

        /* Terms and Conditions card */
        .q-terms-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 35px;
            margin-top: 40px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02), 0 4px 6px -2px rgba(0,0,0,0.02);
        }
        .q-terms-card h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }
        .q-terms-content {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.8;
        }
        .q-terms-content ul, .q-terms-content ol {
            margin-left: 24px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .q-terms-content li {
            margin-bottom: 8px;
        }
        .q-terms-content p {
            margin-bottom: 12px;
        }
        .q-terms-content h1, .q-terms-content h2, .q-terms-content h3, .q-terms-content h4, .q-terms-content h5, .q-terms-content h6 {
            color: var(--text-main);
            font-weight: 700;
            margin-top: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Header bar -->
    <header class="q-top-header">
        <div class="q-brand-logo">
            @if(isset($company_setting) && $company_setting->logo_path)
                <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name }}">
            @else
                <span class="q-brand-fallback">{{ $company_setting->company_name ?? 'VAAGO' }}</span>
            @endif
        </div>
        <div class="q-header-meta">
            <i class="fa-solid fa-file-invoice-dollar"></i> Quotation Details
        </div>
    </header>

    <div class="q-view-container">

        <!-- Banner Hero Card -->
        @php
            $bannerUrl = $quotation->banner_image ? asset($quotation->banner_image) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80';
            $paxCount = ($quotation->adults ?? 0) + ($quotation->children ?? 0) + ($quotation->infants ?? 0);
        @endphp
        <div class="q-hero-section" style="background-image: url('{{ $bannerUrl }}');">
            <div class="q-hero-text">
                <span class="q-hero-badge">Verified Itinerary</span>
                <h1 class="q-hero-title">{{ $quotation->title ?? (count($quotation->days) - 1) . ' Nights Customized Holiday Package' }}</h1>
                <p class="q-hero-subtitle">Prepared for {{ $quotation->lead->name ?? 'Guest' }} ({{ count($quotation->days) - 1 }} Nights / {{ count($quotation->days) }} Days)</p>
                
                <div class="q-hero-stats">
                    <div class="q-stat-pill">
                        <i class="fa-regular fa-clock"></i>
                        <span>{{ count($quotation->days) }} Days</span>
                    </div>
                    <div class="q-stat-pill">
                        <i class="fa-solid fa-users"></i>
                        <span>{{ $paxCount }} Travelers</span>
                    </div>
                    @if($quotation->quotation_code)
                        <div class="q-stat-pill">
                            <i class="fa-solid fa-hashtag"></i>
                            <span>{{ $quotation->quotation_code }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Route Summary Chain -->
        @php
            $routeSummary = [];
            $currentDest = null;
            $nightsCount = 0;
            foreach ($quotation->days as $day) {
                $dest = $day->end_point ?: ($day->hotel_name ? strtok($day->hotel_name, ' -') : null);
                if (!$dest) continue;
                
                if ($currentDest === null) {
                    $currentDest = $dest;
                    $nightsCount = 1;
                } elseif ($currentDest === $dest) {
                    $nightsCount++;
                } else {
                    $routeSummary[] = "{$currentDest} ({$nightsCount} N)";
                    $currentDest = $dest;
                    $nightsCount = 1;
                }
            }
            if ($currentDest !== null) {
                $routeSummary[] = "{$currentDest} ({$nightsCount} N)";
            }
            
            $vehiclesList = $vehicles->pluck('vehicle_name')->filter()->unique();
        @endphp
        @if(count($routeSummary) > 0)
            <div class="q-route-card">
                <div class="q-route-lbl">Planned Route Chain</div>
                <div class="q-route-nodes">
                    @foreach($routeSummary as $idx => $node)
                        <span class="q-route-item">{{ $node }}</span>
                        @if($idx < count($routeSummary) - 1)
                            <span class="q-route-sep"><i class="fa-solid fa-arrow-right"></i></span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Sticky Date Pills Timeline -->
        <div class="q-timeline-nav">
            <div class="q-timeline-inner">
                @foreach($quotation->days as $idx => $day)
                    @php
                        $dayDate = $day->date;
                        $month = $dayDate ? $dayDate->format('M') : 'DAY';
                        $dayNum = $dayDate ? $dayDate->format('d') : $day->day_number;
                        $dayName = $dayDate ? $dayDate->format('D') : '';
                    @endphp
                    <a href="#day-{{ $day->day_number }}" class="q-timeline-btn {{ $idx === 0 ? 'active' : '' }}" data-day="{{ $day->day_number }}">
                        <span class="nav-mon">{{ $month }}</span>
                        <span class="nav-num">{{ $dayNum }}</span>
                        @if($dayName)
                            <span class="nav-day">{{ $dayName }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Itinerary Days -->
        <div class="q-days-container">
            @foreach($quotation->days as $day)
                @php
                    // Collect day photos
                    $allImages = [];
                    if (is_array($day->images)) {
                        foreach ($day->images as $urls) {
                            if (is_array($urls)) {
                                foreach ($urls as $url) {
                                    if (!empty($url)) {
                                        $allImages[] = $url;
                                    }
                                }
                            }
                        }
                    }
                    
                    $hotel = isset($hotelsMap[$day->hotel_id]) ? $hotelsMap[$day->hotel_id] : null;
                    if ($hotel && $hotel->image) {
                        $allImages[] = $hotel->image;
                    }
                    
                    $allImages = array_values(array_unique($allImages));
                    
                    // Fallback cover image
                    $hasDayImages = count($allImages) > 0;
                    $mainImgUrl = 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80';
                    
                    if ($hasDayImages) {
                        $mainImgUrl = asset($allImages[0]);
                    }
                @endphp
                <div class="q-day-section" id="day-{{ $day->day_number }}">
                    <div class="q-day-card">
                        
                        <!-- Left Panel Details -->
                        <div class="q-day-details">
                            <div class="q-day-meta">
                                <span class="q-day-number">Day {{ $day->day_number }}</span>
                                @if($day->start_point || $day->end_point)
                                    <span class="q-day-route">
                                        {{ $day->start_point ?? 'Arrival' }} &rarr; {{ $day->end_point ?? 'Destination' }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="q-day-title">{{ $day->title ?? 'Itinerary Day details' }}</h2>

                            @if($day->distance > 0 || $day->travel_time)
                                <div class="q-specs-container">
                                    @if($day->distance > 0)
                                        <div class="q-spec-block">
                                            <div class="q-spec-circle-icon"><i class="fa-solid fa-map-pin"></i></div>
                                            <div class="q-spec-text-group">
                                                <div class="q-spec-label">DISTANCE</div>
                                                <div class="q-spec-value">{{ $day->distance }} KM</div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($day->distance > 0 && $day->travel_time)
                                        <div class="q-spec-divider"></div>
                                    @endif

                                    @if($day->travel_time)
                                        <div class="q-spec-block">
                                            <div class="q-spec-circle-icon"><i class="fa-regular fa-clock"></i></div>
                                            <div class="q-spec-text-group">
                                                <div class="q-spec-label">TRAVEL TIME</div>
                                                <div class="q-spec-value">{{ $day->travel_time }} Hours</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- CK Content Description -->
                            <div class="q-day-desc" style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.7; margin-bottom: 25px;">
                                {!! $day->description !!}
                            </div>

                            <!-- Hotel block -->
                            @if($day->hotel_name)
                                <div class="q-hotel-card-refined">
                                    <div class="q-hotel-icon-circle"><i class="fa-solid fa-hotel"></i></div>
                                    <div class="q-hotel-text-info">
                                        <div class="q-hotel-name-stars">
                                            <span class="q-hotel-name-lbl">{{ $day->hotel_name }}</span>
                                            @if($hotel && $hotel->star_rating)
                                                <span class="q-hotel-stars-display">
                                                    @for($i = 0; $i < $hotel->star_rating; $i++)
                                                        <i class="fa-solid fa-star"></i>
                                                    @endfor
                                                </span>
                                            @endif
                                        </div>
                                        <div class="q-hotel-room-meals">
                                            <i class="fa-solid fa-bed"></i> {{ $day->room_type_name ?: 'Standard Room' }}
                                            @if($day->meals && count($day->meals) > 0)
                                                <span>({{ implode(', ', $day->meals) }})</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="q-hotel-btn-wrapper">
                                        @if($hotel && $hotel->contact_person)
                                            <span class="q-hotel-btn" title="Coordinator: {{ $hotel->contact_person }}">View Details</span>
                                        @else
                                            <span class="q-hotel-btn">View Details</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Features checklist row -->
                            <div class="q-features-row">
                                <!-- Highlights -->
                                @if(is_array($day->highlights) && count($day->highlights) > 0)
                                    <div class="q-feature-col">
                                        <div class="q-feature-lbl"><i class="fa-solid fa-circle-check"></i> Highlights</div>
                                        <div class="q-pills-list">
                                            @foreach($day->highlights as $hl)
                                                <span class="q-pill q-pill-highlight"><i class="fa-solid fa-check"></i> {{ $hl }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Activities -->
                                @if(is_array($day->activities) && count($day->activities) > 0)
                                    <div class="q-feature-col">
                                        <div class="q-feature-lbl"><i class="fa-solid fa-person-running"></i> Activities</div>
                                        <div class="q-pills-list">
                                            @foreach($day->activities as $act)
                                                @php
                                                    $actName = is_array($act) ? ($act['name'] ?? 'Activity') : $act;
                                                @endphp
                                                <span class="q-pill q-pill-activity"><i class="fa-solid fa-compass"></i> {{ $actName }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Meals -->
                                @if(is_array($day->meals) && count($day->meals) > 0)
                                    <div class="q-feature-col">
                                        <div class="q-feature-lbl"><i class="fa-solid fa-utensils"></i> Meals</div>
                                        <div class="q-pills-list">
                                            @foreach($day->meals as $meal)
                                                <span class="q-pill q-pill-meal"><i class="fa-solid fa-cookie-bite"></i> {{ $meal }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right Panel: Image Gallery -->
                        <div class="q-day-media">
                            <div class="q-media-hero trigger-lightbox" data-day="{{ $day->day_number }}" data-idx="0" data-src="{{ $mainImgUrl }}">
                                <img src="{{ $mainImgUrl }}" alt="Day {{ $day->day_number }}">
                                <div class="q-media-zoom"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                            </div>
                            
                            @if(count($allImages) > 1)
                                <div class="q-media-grid">
                                    @foreach($allImages as $idx => $url)
                                        @php if($idx === 0) continue; @endphp
                                        @if($idx < 4)
                                            <div class="q-media-thumb trigger-lightbox" data-day="{{ $day->day_number }}" data-idx="{{ $idx }}" data-src="{{ asset($url) }}">
                                                <img src="{{ asset($url) }}" alt="Day Thumbnail">
                                                @if($idx === 3 && count($allImages) > 4)
                                                    <div class="q-media-thumb-more">+{{ count($allImages) - 4 }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <!-- Hidden triggers for lightbox flow -->
                                            <div class="trigger-lightbox" style="display:none;" data-day="{{ $day->day_number }}" data-idx="{{ $idx }}" data-src="{{ asset($url) }}"></div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="q-media-note">
                                    <i class="fa-regular fa-images"></i> Click thumbnails to view full {{ count($allImages) }} photos
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>



        <!-- General Inclusions/Exclusions Card -->
        <div class="q-inc-exc-card">
            <div class="q-inc-exc-grid">
                
                <div class="q-inc-exc-panel inc-panel">
                    <div class="q-panel-title"><i class="fa-solid fa-square-check"></i> General Inclusions</div>
                    <div class="q-list-items">
                        @if(is_array($quotation->inclusions) && count($quotation->inclusions) > 0)
                            @foreach($quotation->inclusions as $inc)
                                <div class="q-list-row">
                                    <i class="fa-solid fa-check"></i>
                                    <span>{{ $inc }}</span>
                                </div>
                            @endforeach
                        @else
                            <div style="font-size: 0.85rem; color: var(--text-light);">Standard inclusions apply.</div>
                        @endif
                    </div>
                </div>

                <div class="q-inc-exc-panel exc-panel">
                    <div class="q-panel-title"><i class="fa-solid fa-square-xmark"></i> General Exclusions</div>
                    <div class="q-list-items">
                        @if(is_array($quotation->exclusions) && count($quotation->exclusions) > 0)
                            @foreach($quotation->exclusions as $exc)
                                <div class="q-list-row">
                                    <i class="fa-solid fa-xmark"></i>
                                    <span>{{ $exc }}</span>
                                </div>
                            @endforeach
                        @else
                            <div style="font-size: 0.85rem; color: var(--text-light);">Standard exclusions apply.</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- Pricing & Trip Summary side-by-side Section -->
        @php
            $firstDay = $quotation->days->first();
            $travelDate = $firstDay && $firstDay->date ? $firstDay->date->format('d M Y (D)') : 'Not Specified';
        @endphp
        <div class="q-billing-summary-grid">
            
            <!-- Left Card: Pricing & Booking Details -->
            <div class="q-pricing-details-card">
                <div class="q-pricing-card-header">
                    <span class="q-pricing-card-title">Pricing & Booking Details</span>
                    <span class="q-pricing-code-badge">
                        <i class="fa-solid fa-ticket"></i> {{ $quotation->quotation_code }}
                    </span>
                </div>
                
                <div class="q-billing-rows">
                    <div class="q-billing-row">
                        <div class="q-billing-row-left">
                            <i class="fa-solid fa-user-group"></i>
                            <span>Passenger Details</span>
                        </div>
                        <div class="q-billing-row-right">
                            {{ $quotation->adults ?? 0 }} Adults / {{ $quotation->children ?? 0 }} Children @if($quotation->infants > 0) / {{ $quotation->infants }} Infants @endif
                        </div>
                    </div>

                    <div class="q-billing-row">
                        <div class="q-billing-row-left">
                            <i class="fa-solid fa-bed"></i>
                            <span>Accommodation Charges</span>
                        </div>
                        <div class="q-billing-row-right">
                            {{ $quotation->currency == 'USD' ? '$' : '₹' }}{{ number_format($quotation->total_hotel_cost, 2) }}
                        </div>
                    </div>

                    <div class="q-billing-row">
                        <div class="q-billing-row-left">
                            <i class="fa-solid fa-car-side"></i>
                            <span>Transport & Transfer Cost</span>
                        </div>
                        <div class="q-billing-row-right">
                            {{ $quotation->currency == 'USD' ? '$' : '₹' }}{{ number_format($quotation->total_vehicle_cost, 2) }}
                        </div>
                    </div>

                    @if($quotation->total_activity_cost > 0)
                        <div class="q-billing-row">
                            <div class="q-billing-row-left">
                                <i class="fa-solid fa-camera"></i>
                                <span>Activities & Sightseeing</span>
                            </div>
                            <div class="q-billing-row-right">
                                {{ $quotation->currency == 'USD' ? '$' : '₹' }}{{ number_format($quotation->total_activity_cost, 2) }}
                            </div>
                        </div>
                    @endif

                    @if($quotation->extra_charges > 0)
                        <div class="q-billing-row">
                            <div class="q-billing-row-left">
                                <i class="fa-solid fa-receipt"></i>
                                <span>Extra Charges / Fees</span>
                            </div>
                            <div class="q-billing-row-right">
                                {{ $quotation->currency == 'USD' ? '$' : '₹' }}{{ number_format($quotation->extra_charges, 2) }}
                            </div>
                        </div>
                    @endif

                    @if($quotation->discount > 0)
                        <div class="q-billing-row discount-item">
                            <div class="q-billing-row-left">
                                <i class="fa-solid fa-tag"></i>
                                <span>Promo Discount</span>
                            </div>
                            <div class="q-billing-row-right">
                                -{{ $quotation->currency == 'USD' ? '$' : '₹' }}{{ number_format($quotation->discount, 2) }}
                            </div>
                        </div>
                    @endif

                    <div class="q-billing-row" style="border-top: 1px dashed var(--border-color); padding-top: 12px; margin-top: 4px;">
                        <div class="q-billing-row-left">
                            <i class="fa-solid fa-calculator"></i>
                            <span>Subtotal</span>
                        </div>
                        <div class="q-billing-row-right">
                            {{ $quotation->sub_total > 0 ? ($quotation->currency == 'USD' ? '$' : '₹') . number_format($quotation->sub_total, 2) : '—' }}
                        </div>
                    </div>

                    <div class="q-billing-row">
                        <div class="q-billing-row-left">
                            <i class="fa-solid fa-percent"></i>
                            <span>GST Tax Amount ({{ $quotation->gst_percentage ?? 5 }}%)</span>
                        </div>
                        <div class="q-billing-row-right">
                            {{ $quotation->currency == 'USD' ? '$' : '₹' }}{{ number_format($quotation->gst_amount, 2) }}
                        </div>
                    </div>
                </div>

                <div class="q-billing-grand-total-block">
                    <div class="q-grand-total-info">
                        <span class="q-grand-total-lbl">Grand Total</span>
                        <span class="q-grand-total-subtext">All taxes included</span>
                    </div>
                    <div class="q-grand-total-amount-green">
                        {{ $quotation->currency == 'USD' ? '$' : '₹' }}{{ number_format($quotation->grand_total, 2) }}
                    </div>
                </div>

                @php
                    $leadContact = $quotation->lead ? $quotation->lead->phone : '';
                    $contactLink = !empty($leadContact) ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $leadContact) : 'mailto:' . ($quotation->lead->email ?? '');
                @endphp
                <a href="{{ $contactLink }}" class="q-book-now-btn-full" target="_blank">
                    <i class="fa-solid fa-circle-check"></i> Book / Accept Package
                </a>
                
                <div class="q-pricing-footer-hint">
                    <i class="fa-solid fa-info-circle"></i> Prices are subject to availability at the time of final booking confirmation.
                </div>
            </div>

            <!-- Right Card: Trip Summary -->
            <div class="q-trip-summary-card">
                <span class="q-summary-card-title">Trip Summary</span>
                
                <div class="q-trip-visual-banner" style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=600&q=80');">
                </div>

                <div class="q-trip-summary-list">
                    <div class="q-summary-item">
                        <div class="q-summary-item-icon-circle">
                            <i class="fa-regular fa-calendar-days"></i>
                        </div>
                        <div class="q-summary-item-text-group">
                            <span class="q-summary-item-label">Travel Date</span>
                            <span class="q-summary-item-value">{{ $travelDate }}</span>
                        </div>
                    </div>

                    <div class="q-summary-item">
                        <div class="q-summary-item-icon-circle">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="q-summary-item-text-group">
                            <span class="q-summary-item-label">Passengers</span>
                            <span class="q-summary-item-value">{{ $quotation->adults ?? 0 }} Adults / {{ $quotation->children ?? 0 }} Children</span>
                        </div>
                    </div>

                    <div class="q-summary-item">
                        <div class="q-summary-item-icon-circle">
                            <i class="fa-solid fa-ticket"></i>
                        </div>
                        <div class="q-summary-item-text-group">
                            <span class="q-summary-item-label">Booking Reference</span>
                            <span class="q-summary-item-value">{{ $quotation->quotation_code }}</span>
                        </div>
                    </div>
                </div>

                <div class="q-why-book-box">
                    <span class="q-why-book-title">
                        <i class="fa-solid fa-shield-halved"></i> Why book with us?
                    </span>
                    <div class="q-why-book-list">
                        <div class="q-why-book-point">
                            <i class="fa-solid fa-check"></i>
                            <span>Best Price Guarantee</span>
                        </div>
                        <div class="q-why-book-point">
                            <i class="fa-solid fa-check"></i>
                            <span>Secure & Easy Booking</span>
                        </div>
                        <div class="q-why-book-point">
                            <i class="fa-solid fa-check"></i>
                            <span>24/7 Customer Support</span>
                        </div>
                </div>
            </div>

        </div>

    </div>

        @if(!empty($quotation->terms_and_conditions))
            <!-- Terms & Conditions Section -->
            <div class="q-terms-card">
                <h3>
                    <i class="fa-solid fa-file-contract"></i> Terms & Conditions
                </h3>
                <div class="q-terms-content">
                    {!! $quotation->terms_and_conditions !!}
                </div>
            </div>
        @endif

    </div>

    <!-- Standalone Footer -->
    <footer class="q-footer">
        <p>&copy; {{ date('Y') }} {{ $company_setting->company_name ?? 'VAAGO' }}. All rights reserved.</p>
        <p style="font-size:0.75rem; margin-top:5px; opacity:0.7;">This quotation is dynamically generated and remains valid for 7 days.</p>
    </footer>

    <!-- Custom Lightbox Modal -->
    <div class="q-lightbox-modal" id="q-custom-lightbox">
        <div class="q-lightbox-content">
            <button class="q-lightbox-close" id="lightbox-close-btn">&times;</button>
            <button class="q-lightbox-nav q-lightbox-prev" id="lightbox-prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
            <img src="" class="q-lightbox-img" id="lightbox-img-el" alt="Lightbox Preview">
            <button class="q-lightbox-nav q-lightbox-next" id="lightbox-next-btn"><i class="fa-solid fa-chevron-right"></i></button>
            <div class="q-lightbox-cnt" id="lightbox-counter-el">1 / 1</div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // --- 1. Sticky Nav Day Highlight ScrollSpy (Fix Top Scroll Bug) ---
            const timelineButtons = document.querySelectorAll(".q-timeline-btn");
            const daySections = document.querySelectorAll(".q-day-section");

            const options = {
                root: null,
                rootMargin: "-120px 0px -60% 0px",
                threshold: 0
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute("id");
                        const targetBtn = document.querySelector(`.q-timeline-btn[href="#${id}"]`);
                        
                        if (targetBtn) {
                            timelineButtons.forEach(btn => btn.classList.remove("active"));
                            targetBtn.classList.add("active");
                            
                            // Scroll horizontal container ONLY (prevents window scrolling jump bug)
                            const container = document.querySelector(".q-timeline-inner");
                            if (container) {
                                const leftPos = targetBtn.offsetLeft - container.offsetLeft - (container.clientWidth / 2) + (targetBtn.clientWidth / 2);
                                container.scrollTo({
                                    left: leftPos,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    }
                });
            }, options);

            daySections.forEach(section => observer.observe(section));

            // Smooth scroll for day nav pills
            timelineButtons.forEach(btn => {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute("href");
                    const targetEl = document.querySelector(targetId);
                    
                    if (targetEl) {
                        const offsetTop = targetEl.getBoundingClientRect().top + window.scrollY - 135;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: "smooth"
                        });
                    }
                });
            });

            // --- 2. Custom Photo Gallery Lightbox ---
            const lightbox = document.getElementById("q-custom-lightbox");
            const lightboxImg = document.getElementById("lightbox-img-el");
            const lightboxClose = document.getElementById("lightbox-close-btn");
            const lightboxPrev = document.getElementById("lightbox-prev-btn");
            const lightboxNext = document.getElementById("lightbox-next-btn");
            const lightboxCounter = document.getElementById("lightbox-counter-el");

            let activeDayNum = null;
            let activeImgIdx = 0;
            let dayImagesMap = {};

            document.querySelectorAll(".trigger-lightbox").forEach(trigger => {
                const dayNum = trigger.getAttribute("data-day");
                const src = trigger.getAttribute("data-src");
                
                if (!dayImagesMap[dayNum]) {
                    dayImagesMap[dayNum] = [];
                }
                dayImagesMap[dayNum].push(src);
                
                trigger.addEventListener("click", function() {
                    activeDayNum = this.getAttribute("data-day");
                    activeImgIdx = parseInt(this.getAttribute("data-idx")) || 0;
                    openLightbox();
                });
            });

            function openLightbox() {
                if (!activeDayNum || !dayImagesMap[activeDayNum]) return;
                const images = dayImagesMap[activeDayNum];
                
                lightboxImg.src = images[activeImgIdx];
                lightboxCounter.textContent = `${activeImgIdx + 1} / ${images.length}`;
                lightbox.style.display = "flex";
                document.body.style.overflow = "hidden"; // Disable background scrolling

                if (images.length <= 1) {
                    lightboxPrev.style.display = "none";
                    lightboxNext.style.display = "none";
                } else {
                    lightboxPrev.style.display = "flex";
                    lightboxNext.style.display = "flex";
                }
            }

            function closeLightbox() {
                lightbox.style.display = "none";
                document.body.style.overflow = ""; // Re-enable background scrolling
            }

            function navigateLightbox(dir) {
                if (!activeDayNum || !dayImagesMap[activeDayNum]) return;
                const images = dayImagesMap[activeDayNum];
                
                if (dir === 'next') {
                    activeImgIdx = (activeImgIdx + 1) % images.length;
                } else if (dir === 'prev') {
                    activeImgIdx = (activeImgIdx - 1 + images.length) % images.length;
                }
                lightboxImg.src = images[activeImgIdx];
                lightboxCounter.textContent = `${activeImgIdx + 1} / ${images.length}`;
            }

            lightboxClose.addEventListener("click", closeLightbox);
            lightboxPrev.addEventListener("click", () => navigateLightbox('prev'));
            lightboxNext.addEventListener("click", () => navigateLightbox('next'));

            document.addEventListener("keydown", function(e) {
                if (lightbox.style.display === "flex") {
                    if (e.key === "Escape") closeLightbox();
                    if (e.key === "ArrowLeft") navigateLightbox('prev');
                    if (e.key === "ArrowRight") navigateLightbox('next');
                }
            });

            lightbox.addEventListener("click", function(e) {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });
        });
    </script>
</body>
</html>
