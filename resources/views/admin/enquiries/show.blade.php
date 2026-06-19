@extends('admin.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/pages.css') }}">
<style>
    .enquiry-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
    }
    .enquiry-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid #E2E8F0;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }
    .enquiry-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }
    .enquiry-date {
        color: #64748B;
        font-size: 0.9rem;
    }
    .enquiry-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .meta-item {
        background: #F8FAFC;
        padding: 15px 20px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
    }
    .meta-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #94A3B8;
        margin-bottom: 5px;
    }
    .meta-value {
        font-size: 1rem;
        font-weight: 600;
        color: #334155;
    }
    .enquiry-message-box {
        background: #FFFBEB;
        border-left: 4px solid #F59E0B;
        padding: 20px;
        border-radius: 4px 8px 8px 4px;
        color: #451A03;
        font-size: 1.05rem;
        line-height: 1.6;
        white-space: pre-wrap;
    }
</style>
@endsection

@section('content')
<div class="admin-page-panel">
    <div class="page-panel-header">
        <div class="panel-header-action-container">
            <h3><i class="fa-solid fa-envelope-open-text"></i> Enquiry Details</h3>
            <a href="{{ url('/admin/enquiries') }}" class="btn-cancel" style="background: #F1F5F9; color: #475569; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                <i class="fa-solid fa-arrow-left"></i> Back to Enquiries
            </a>
        </div>
    </div>
    
    <div class="page-panel-body">
        <div class="enquiry-card">
            <div class="enquiry-header">
                <div>
                    <h2 class="enquiry-title">Enquiry from {{ $enquiry->first_name }} {{ $enquiry->last_name }}</h2>
                    <p class="enquiry-date"><i class="fa-regular fa-clock"></i> Submitted on {{ $enquiry->created_at->format('l, F j, Y \a\t g:i A') }}</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="mailto:{{ $enquiry->email }}" class="modern-btn" style="background: #0284C7; text-decoration: none;">
                        <i class="fa-solid fa-reply"></i> Reply via Email
                    </a>
                </div>
            </div>

            <div class="enquiry-meta">
                <div class="meta-item">
                    <div class="meta-label">Email Address</div>
                    <div class="meta-value"><a href="mailto:{{ $enquiry->email }}" style="color: #0284C7; text-decoration: none;">{{ $enquiry->email }}</a></div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Phone Number</div>
                    <div class="meta-value"><a href="tel:{{ $enquiry->phone }}" style="color: #0284C7; text-decoration: none;">{{ $enquiry->phone }}</a></div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Arrival Date</div>
                    <div class="meta-value">{{ $enquiry->arrival_date ? \Carbon\Carbon::parse($enquiry->arrival_date)->format('F j, Y') : 'Not Specified' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Number of Nights</div>
                    <div class="meta-value">{{ $enquiry->nights }} {{ \Illuminate\Support\Str::plural('Night', $enquiry->nights) }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Accommodation Type</div>
                    <div class="meta-value">{{ $enquiry->accommodation_type ?: 'Not Specified' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Trip Type / Honeymoon</div>
                    <div class="meta-value">
                        @if($enquiry->honeymoon === 'Yes')
                            <span style="color: #E11D48;"><i class="fa-solid fa-heart"></i> Honeymoon</span>
                        @else
                            {{ $enquiry->honeymoon ?: 'Not Specified' }}
                        @endif
                    </div>
                </div>
            </div>

            <h4 style="margin-bottom: 15px; color: #475569; font-weight: 700; font-size: 1.1rem;">Message / Preferences</h4>
            <div class="enquiry-message-box">{{ $enquiry->message }}</div>
            
        </div>
    </div>
</div>
@endsection
