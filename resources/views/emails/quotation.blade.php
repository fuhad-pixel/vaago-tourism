<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Travel Quotation</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #ffffff;
            padding: 40px 30px 20px 30px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }
        .body {
            padding: 40px 30px;
            color: #334155;
            line-height: 1.6;
        }
        .body h2 {
            font-size: 22px;
            color: #0f172a;
            margin-top: 0;
            font-weight: 700;
        }
        .greeting {
            font-size: 16px;
            color: #334155;
            margin-bottom: 20px;
        }
        .intro-text {
            font-size: 15px;
            color: #475569;
            margin-bottom: 30px;
        }
        .quotation-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 30px;
        }
        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        .detail-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .detail-label {
            display: table-cell;
            font-weight: 600;
            color: #64748b;
            font-size: 13px;
            text-transform: uppercase;
            width: 140px;
        }
        .detail-value {
            display: table-cell;
            font-size: 15px;
            color: #1e293b;
        }
        .highlight-value {
            font-weight: 700;
            color: #f15d30;
        }
        .cta-container {
            text-align: center;
            margin: 35px 0;
        }
        .cta-button {
            background-color: #f15d30;
            color: #ffffff !important;
            padding: 14px 32px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(241, 93, 48, 0.25);
            transition: background-color 0.2s ease;
        }
        .cta-button:hover {
            background-color: #d94014;
        }
        .footer {
            background-color: #0f172a;
            color: #94a3b8;
            padding: 40px 30px;
            font-size: 13px;
            border-top: 1px solid #1e293b;
        }
        .footer-logo {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 15px;
        }
        .footer-info {
            line-height: 1.8;
            margin-bottom: 25px;
        }
        .footer-info a {
            color: #38bdf8;
            text-decoration: none;
        }
        .footer-info strong {
            color: #e2e8f0;
        }
        .social-links {
            margin-bottom: 20px;
        }
        .social-link {
            color: #94a3b8;
            text-decoration: none;
            margin-right: 15px;
            font-weight: 600;
        }
        .social-link:hover {
            color: #ffffff;
        }
        .copyright {
            font-size: 11px;
            color: #64748b;
            border-top: 1px solid #1e293b;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            @if($companySetting && $companySetting->logo_path && file_exists(public_path($companySetting->logo_path)))
                <img src="{{ $message->embed(public_path($companySetting->logo_path)) }}" alt="{{ $companySetting->company_name ?? 'Company Logo' }}" style="max-height: 55px; display: block; margin: 0 auto; object-fit: contain;">
            @elseif($companySetting && $companySetting->logo_path)
                <img src="{{ asset($companySetting->logo_path) }}" alt="{{ $companySetting->company_name ?? 'Company Logo' }}" style="max-height: 55px; display: block; margin: 0 auto; object-fit: contain;">
            @else
                <div style="font-size: 24px; font-weight: 800; color: #f15d30; letter-spacing: 1px; text-transform: uppercase;">
                    {{ $companySetting->company_name ?? 'VAAGO TOURISM' }}
                </div>
            @endif
        </div>

        <!-- Body Content -->
        <div class="body">
            <h2>Hello {{ $quotation->lead->name ?? 'Valued Client' }},</h2>
            
            <p class="greeting">
                We are pleased to send you the customized holiday itinerary and quotation details curated specifically for your upcoming travel.
            </p>
            
            <p class="intro-text">
                Our team has crafted this plan based on your preferences to ensure a memorable travel experience. Please find a summary of your quotation below:
            </p>

            <!-- Quotation Card -->
            <div class="quotation-card">
                <div class="card-title">
                    {{ $quotation->title ?? 'Customized Holiday Itinerary' }}
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Quote Code:</span>
                    <span class="detail-value"><strong>{{ $quotation->quotation_code }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span class="detail-value">{{ $quotation->days->count() }} Days / {{ max(1, $quotation->days->count() - 1) }} Nights</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Pax Details:</span>
                    <span class="detail-value">
                        Adults: {{ $quotation->adults ?? 0 }} 
                        @if(($quotation->children ?? 0) > 0) | Children: {{ $quotation->children }} @endif
                        @if(($quotation->infants ?? 0) > 0) | Infants: {{ $quotation->infants }} @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Total Price:</span>
                    <span class="detail-value highlight-value">
                        @if($quotation->currency == 'USD')
                            ${{ number_format($quotation->grand_total, 2) }}
                        @else
                            ₹{{ number_format($quotation->grand_total, 2) }}
                        @endif
                    </span>
                </div>
            </div>

            <!-- Call to Action -->
            <p style="text-align: center; color: #475569; font-size: 14px; margin-bottom: 5px;">
                Click below to view the detailed day-wise itinerary, inclusions, exclusions, and billing details.
            </p>
            <div class="cta-container">
                <a href="{{ $publicUrl }}" class="cta-button" target="_blank">
                    View Detailed Itinerary & Quote
                </a>
            </div>

            <p style="font-size: 14px; color: #64748b;">
                If you have any changes or queries regarding this itinerary, please do not hesitate to contact our holiday experts. We look forward to host you!
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">
                {{ $companySetting->company_name ?? 'Vaago Tourism' }}
            </div>
            
            <div class="footer-info">
                @if($companySetting->address)
                    <strong>Address:</strong> {{ $companySetting->address }}<br>
                @endif
                @if($companySetting->phone)
                    <strong>Phone:</strong> {{ $companySetting->phone }}<br>
                @endif
                @if($companySetting->company_email)
                    <strong>Email:</strong> <a href="mailto:{{ $companySetting->company_email }}">{{ $companySetting->company_email }}</a><br>
                @endif
                @if($companySetting->whatsapp)
                    <strong>WhatsApp:</strong> {{ $companySetting->whatsapp }}<br>
                @endif
            </div>

            <div class="social-links">
                @if($companySetting->facebook)
                    <a href="{{ $companySetting->facebook }}" class="social-link" target="_blank">Facebook</a>
                @endif
                @if($companySetting->instagram)
                    <a href="{{ $companySetting->instagram }}" class="social-link" target="_blank">Instagram</a>
                @endif
                @if($companySetting->twitter)
                    <a href="{{ $companySetting->twitter }}" class="social-link" target="_blank">Twitter</a>
                @endif
                @if($companySetting->linkedin)
                    <a href="{{ $companySetting->linkedin }}" class="social-link" target="_blank">LinkedIn</a>
                @endif
            </div>

            <div class="copyright">
                &copy; {{ date('Y') }} {{ $companySetting->company_name ?? 'Vaago Tourism' }}. All rights reserved.<br>
                This email was sent regarding your holiday query with us.
            </div>
        </div>
    </div>
</body>
</html>
