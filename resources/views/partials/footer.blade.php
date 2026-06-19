    <!-- Footer Start -->
    <footer
      class="vs-footer-style1"
      data-bg-src="{{ asset('assets/img/footer/footer-style1-bg.png') }}"
    >
      <div class="footer-top space-top">
        <div class="container">
          <div class="row gx-4">
            <div class="col-12">
              <div
                class="footer-cta bg-third-theme-color"
                data-bg-src="{{ asset('assets/img/footer/footer-cta-bg.png') }}"
              >
                <div class="row g-4 align-items-center">
                  <div class="col-lg-8">
                    <div class="cta-contact-items">
                      @if(isset($company_setting) && $company_setting->address)
                        <div class="contact-item">
                          <span class="icon">
                            <i class="fa-light fa-location-dot"></i>
                          </span>
                          <div class="info">
                            <h5 class="info-title text-white-color">Location</h5>
                            <p>{{ $company_setting->address }}</p>
                          </div>
                        </div>
                      @endif
                      @if(isset($company_setting) && ($company_setting->phone || $company_setting->company_email))
                        <div class="contact-item">
                          <span class="icon">
                            <i class="fa-sharp fa-light fa-phone-rotary"></i>
                          </span>
                          <div class="info">
                            <h5 class="info-title text-white-color">Contact Us</h5>
                            <p>
                              @if($company_setting->company_email)
                                <a href="mailto:{{ $company_setting->company_email }}">{{ $company_setting->company_email }}</a>
                              @endif
                              @if($company_setting->phone)
                                <a href="tel:{{ $company_setting->phone }}">{{ $company_setting->phone }}</a>
                              @endif
                            </p>
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                  <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end btn-trigger btn-bounce">
                    <a href="{{ url('/contact') }}" class="vs-btn style6">
                      <span>book now</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-center space-extra">
        <div class="container">
          <div class="row gx-4 gy-4 gx-xl-2 justify-content-between">
            <div class="col-md-6 col-lg-4 col-xl-4">
              <div class="footer-widgets">
                <a href="{{ url('/') }}" class="logo">
                  @if(isset($company_setting) && $company_setting->logo_path)
                    <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'logo' }}" style="height: 50px; max-height: 50px; width: auto; object-fit: contain;" />
                  @else
                    <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" />
                  @endif
                </a>
                <div class="social-media mt-4">
                  <ul class="custom-ul">
                    @if(isset($company_setting) && $company_setting->facebook)
                      <li>
                        <a href="{{ $company_setting->facebook }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                      </li>
                    @endif
                    @if(isset($company_setting) && $company_setting->twitter)
                      <li>
                        <a href="{{ $company_setting->twitter }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                      </li>
                    @endif
                    @if(isset($company_setting) && $company_setting->instagram)
                      <li>
                        <a href="{{ $company_setting->instagram }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                      </li>
                    @endif
                    @if(isset($company_setting) && $company_setting->linkedin)
                      <li>
                        <a href="{{ $company_setting->linkedin }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                      </li>
                    @endif
                  </ul>
                </div>
                <p class="mt-4 mb-3 text-color-5">
                  Your premium partner in touring and travel memories. Safe, secure, and beautiful vacations.
                </p>
              </div>
            </div>
            
            <div class="col-md-6 col-lg-3 col-xl-3">
              <div class="footer-widgets">
                <h5 class="widgets-title text-white-color text-capitalize">
                  Quick Links
                </h5>
                <div class="footer-links">
                  <ul class="custom-ul">
                    <li><a href="{{ url('/') }}"><i class="fa-solid fa-angles-right"></i>Home</a></li>
                    <li><a href="{{ url('/about') }}"><i class="fa-solid fa-angles-right"></i>About Us</a></li>
                    <li><a href="{{ url('/destination') }}"><i class="fa-solid fa-angles-right"></i>Destinations</a></li>
                    <li><a href="{{ url('/blog') }}"><i class="fa-solid fa-angles-right"></i>Blog</a></li>
                    <li><a href="{{ url('/contact') }}"><i class="fa-solid fa-angles-right"></i>Contact</a></li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3 col-xl-3">
              <div class="footer-widgets">
                <h5 class="widgets-title text-white-color text-capitalize">
                  Legals
                </h5>
                <div class="footer-links">
                  <ul class="custom-ul">
                    <li><a href="javascript:void(0)" onclick="showPolicyModal('Privacy Policy', 'privacy')"><i class="fa-solid fa-angles-right"></i>Privacy Policy</a></li>
                    <li><a href="javascript:void(0)" onclick="showPolicyModal('Return Policy', 'return')"><i class="fa-solid fa-angles-right"></i>Return Policy</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom bg-third-theme-color">
        <div class="container">
          <div class="row">
            <div class="col-md-6 order-2 order-md-1">
              <p class="footer-copyright text-center text-md-start">
                © {{ date('Y') }}
                <a href="{{ url('/') }}" class="text-theme-color">{{ $company_setting->company_name ?? 'Pacific' }}</a>, All Rights Reserved.
              </p>
            </div>
            <div class="col-md-6 order-1 order-md-2">
              <div class="footer-menu">
                <ul class="custom-ul justify-content-center justify-content-md-end">
                  <li><a href="{{ url('/') }}">Home</a></li>
                  <li><a href="{{ url('/about') }}">About</a></li>
                  <li><a href="{{ url('/destination') }}">Tours</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer End -->

    <!-- Modern Policy Modal -->
    <div id="policyModal" class="policy-modal-overlay" onclick="closePolicyModal(event)">
        <div class="policy-modal-box">
            <button type="button" class="policy-modal-close" onclick="closePolicyModalDirect()">&times;</button>
            <h3 id="policyModalTitle" class="policy-modal-title"></h3>
            <div id="policyModalBody" class="policy-modal-body"></div>
        </div>
    </div>

    <style>
        .policy-modal-overlay {
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
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }
        .policy-modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        .policy-modal-box {
            background: #fff;
            border-radius: 20px;
            width: 90%;
            max-width: 700px;
            max-height: 80vh;
            padding: 35px 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            position: relative;
            transform: scale(0.85);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
        }
        .policy-modal-overlay.active .policy-modal-box {
            transform: scale(1);
        }
        .policy-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #f1f5f9;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 1.5rem;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            line-height: 1;
            outline: none;
        }
        .policy-modal-close:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .policy-modal-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
            text-align: left;
        }
        .policy-modal-body {
            font-size: 1rem;
            color: #475569;
            line-height: 1.7;
            overflow-y: auto;
            text-align: left;
            padding-right: 5px;
        }
        .policy-modal-body h1, .policy-modal-body h2, .policy-modal-body h3 {
            color: #1e293b;
            font-weight: 700;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .policy-modal-body ul, .policy-modal-body ol {
            padding-left: 20px;
            margin-bottom: 15px;
        }
        .policy-modal-body p {
            margin-bottom: 15px;
        }
    </style>

    <script>
        const policyData = {
            privacy: {!! json_encode($company_setting->privacy_policy ?? '<p class="text-muted">Privacy Policy has not been updated yet.</p>') !!},
            return: {!! json_encode($company_setting->return_policy ?? '<p class="text-muted">Return Policy has not been updated yet.</p>') !!}
        };

        function showPolicyModal(title, type) {
            document.getElementById('policyModalTitle').textContent = title;
            document.getElementById('policyModalBody').innerHTML = policyData[type];
            document.getElementById('policyModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePolicyModalDirect() {
            document.getElementById('policyModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function closePolicyModal(event) {
            if (event.target.id === 'policyModal') {
                closePolicyModalDirect();
            }
        }
    </script>
