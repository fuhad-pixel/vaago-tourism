<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - {{ $company_setting->company_name ?? 'Vaago Tourism' }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Caveat:wght@600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #043237; /* Dark teal */
            --primary-light: #0d6b75;
            --accent-color: #0ea5e9;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f1f5f9;
            overflow-x: hidden;
            padding: 20px;
        }

        /* Split Layout Card */
        .login-split {
            display: flex;
            width: 100%;
            max-width: 1200px;
            min-height: 600px;
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* Left Side (Image & Brand) */
        .login-left {
            flex: 1.1;
            position: relative;
            background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 40px;
            color: var(--white);
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(4, 50, 55, 0.95) 0%, rgba(4, 50, 55, 0.4) 100%);
            z-index: 1;
        }

        .left-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        .left-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 10px;
        }

        .left-content .cursive-text {
            font-family: 'Caveat', cursive;
            font-size: 3rem;
            color: #0ea5e9;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .left-content p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 50px;
            opacity: 0.9;
            max-width: 450px;
        }

        .features-grid {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            flex-wrap: nowrap;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .feature-text h4 {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0;
            white-space: nowrap;
        }

        /* Right Side (Login Form) */
        .login-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
            background: var(--white);
        }

        /* Abstract mountains at bottom right */
        .bottom-mountains {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23043237' fill-opacity='0.05' d='M0,256L48,250.7C96,245,192,235,288,213.3C384,192,480,160,576,160C672,160,768,192,864,213.3C960,235,1056,245,1152,240C1248,235,1344,213,1392,202.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3Cpath fill='%23043237' fill-opacity='0.08' d='M0,192L60,186.7C120,181,240,171,360,181.3C480,192,600,224,720,240C840,256,960,256,1080,245.3C1200,235,1320,213,1380,202.7L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-position: bottom;
            background-repeat: no-repeat;
            pointer-events: none;
            z-index: 1;
        }

        .login-form-container {
            width: 100%;
            max-width: 440px;
            z-index: 2;
            background: transparent;
            padding: 20px;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 50px;
        }

        .brand-logo img {
            max-height: 70px;
            width: auto;
            object-fit: contain;
        }

        .brand-logo h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.5px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-main);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            color: var(--text-main);
            background: var(--white);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(4, 50, 55, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            margin-top: 10px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        /* Custom Checkbox */
        .checkbox-container input {
            display: none;
        }

        .checkmark {
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-color);
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.2s;
        }

        .checkbox-container input:checked ~ .checkmark {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .checkmark::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: white;
            font-size: 10px;
            display: none;
        }

        .checkbox-container input:checked ~ .checkmark::after {
            display: block;
        }

        .forgot-password {
            color: var(--primary-light);
            font-size: 0.9rem;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 30px 0;
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }

        .divider span {
            padding: 0 15px;
        }

        .footer-text {
            text-align: center;
            margin-top: 10px;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Error messages */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #ef4444;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .login-left {
                display: none; /* Hide left side on smaller screens */
            }
            .login-split {
                min-height: auto;
                max-width: 500px;
            }
            .login-right {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-split">
        <!-- Left Side -->
        <div class="login-left">
            <div class="left-content">
                <h1>Explore<br>The World</h1>
                <div class="cursive-text">We'll Handle The Rest</div>
                <p>Vaago Tourism Admin makes it easy to manage bookings, destinations and unforgettable experiences.</p>
                
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fa-solid fa-suitcase-rolling"></i></div>
                        <div class="feature-text">
                            <h4>Smart Booking</h4>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="feature-text">
                            <h4>Top Destinations</h4>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fa-solid fa-users"></i></div>
                        <div class="feature-text">
                            <h4>Happy Travelers</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="login-right">
            <div class="bottom-mountains"></div>
            
            <div class="login-form-container">
                <div class="brand-logo">
                    @if(isset($company_setting) && $company_setting->logo_path)
                        <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'Vaago Tourism' }}">
                    @else
                        <h2>{{ $company_setting->company_name ?? 'Vaago Tourism' }}</h2>
                    @endif
                </div>

                @if ($errors->any())
                    <div class="alert-error">
                        @foreach ($errors->all() as $error)
                            <div><i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ url('/admin/login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-container">
                            <input type="checkbox" name="remember" id="remember">
                            <span class="checkmark"></span>
                            Remember me
                        </label>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In
                    </button>
                </form>

                <div class="divider">
                    <span>Secure Admin Access</span>
                </div>

                <div class="footer-text">
                    &copy; {{ date('Y') }} {{ $company_setting->company_name ?? 'Vaago Tourism' }}. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
