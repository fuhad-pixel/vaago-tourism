<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Notification</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #f15d30 0%, #d94014 100%); color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .body { padding: 30px; color: #333333; line-height: 1.6; }
        .body h2 { font-size: 20px; color: #111827; margin-top: 0; }
        .detail-row { margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: bold; color: #64748b; font-size: 13px; text-transform: uppercase; display: block; margin-bottom: 5px; }
        .detail-value { font-size: 16px; color: #1e293b; }
        .message-box { background-color: #f8fafc; padding: 20px; border-radius: 6px; border-left: 4px solid #f15d30; margin-top: 20px; }
        .footer { background-color: #1e293b; color: #94a3b8; text-align: center; padding: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ $type === 'admin' ? 'New Holiday Enquiry' : 'We received your enquiry!' }}</h1>
        </div>
        <div class="body">
            @if($type === 'admin')
                <h2>A new enquiry has been submitted:</h2>
            @else
                <h2>Hello {{ $enquiry->first_name }},</h2>
                <p>Thank you for reaching out! We have successfully received your holiday enquiry. Our team is reviewing your details and will get back to you with a tailored plan shortly. Here is a copy of your submission:</p>
            @endif

            <div class="detail-row">
                <span class="detail-label">Name</span>
                <span class="detail-value">{{ $enquiry->first_name }} {{ $enquiry->last_name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Contact</span>
                <span class="detail-value">{{ $enquiry->email }} | Phone: {{ $enquiry->phone }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Trip Details</span>
                <span class="detail-value">
                    @if($enquiry->arrival_date) Arrival: {{ \Carbon\Carbon::parse($enquiry->arrival_date)->format('M d, Y') }}<br>@endif
                    Nights: {{ $enquiry->nights }}<br>
                    @if($enquiry->accommodation_type) Accommodation: {{ $enquiry->accommodation_type }}<br>@endif
                    @if($enquiry->honeymoon) Trip Type: {{ $enquiry->honeymoon }}<br>@endif
                </span>
            </div>

            <div class="message-box">
                <span class="detail-label">Message / Preferences</span>
                <span class="detail-value">{!! nl2br(e($enquiry->message)) !!}</span>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
