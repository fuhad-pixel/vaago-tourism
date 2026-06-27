    <!-- Sticky Navbar -->
    <div id="navbars" class="header-sticky navbars">
      <div class="container custom-container">
        <div class="row justify-content-between align-items-center">
          <div class="col-auto col-lg-2">
            <button class="vs-menu-toggle d-inline-block d-lg-none">
              <i class="fal fa-bars"></i>
            </button>
            <div class="logo d-none d-lg-block">
              <a href="{{ url('/') }}">
                @if(isset($company_setting) && $company_setting->logo_path)
                  <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'logo' }}" style="height: 50px; max-height: 50px; width: auto; object-fit: contain;" />
                @else
                  <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="logo" />
                @endif
              </a>
            </div>
          </div>
          <div class="col-xl-auto col-lg-auto col-sm-3 d-none d-sm-block">
            <nav class="main-menu d-none d-lg-block">
              <ul>
                <li class="{{ Request::is('/') ? 'active' : '' }}">
                  <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="{{ Request::is('about') ? 'active' : '' }}">
                  <a href="{{ url('/about') }}">About Us</a>
                </li>
                <li class="{{ Request::is('destination') ? 'active' : '' }}">
                  <a href="{{ url('/destination') }}">Destinations</a>
                </li>
                <li class="{{ Request::is('tours') ? 'active' : '' }}">
                  <a href="{{ url('/tours') }}">Tours</a>
                </li>
                <li class="{{ Request::is('blog') || Request::is('blog-single/*') ? 'active' : '' }}">
                  <a href="{{ url('/blog') }}">Blog</a>
                </li>
                <li class="{{ Request::is('contact') ? 'active' : '' }}">
                  <a href="{{ url('/contact') }}">Contact</a>
                </li>
              </ul>
            </nav>
            <div class="logo d-lg-none">
              <a href="{{ url('/') }}">
                @if(isset($company_setting) && $company_setting->logo_path)
                  <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'logo' }}" style="height: 40px; max-height: 40px; width: auto; object-fit: contain;" />
                @else
                  <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="logo" />
                @endif
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-md-auto col-auto">
            <div class="header-wc style2">
              <button class="wc-link2 searchBoxTggler">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="21"
                  height="20"
                  viewBox="0 0 21 20"
                  fill="none"
                >
                  <path
                    d="M20.4174 16.6954L17.2213 13.4773C19.3155 10.0703 18.8936 5.54217 15.9593 2.58766C12.5328 -0.862552 6.9769 -0.862552 3.55037 2.58766C0.123835 6.03787 0.123835 11.6322 3.55037 15.0824C6.5354 18.088 11.1341 18.4736 14.5333 16.2469L17.7019 19.4335C18.4521 20.1888 19.6711 20.1888 20.4213 19.4335C21.1675 18.6781 21.1675 17.4507 20.4174 16.6954ZM5.711 12.9029C3.48395 10.6604 3.48395 7.00959 5.711 4.76715C7.93805 2.52471 11.5638 2.52471 13.7909 4.76715C16.018 7.00959 16.018 10.6604 13.7909 12.9029C11.5638 15.1453 7.93805 15.1453 5.711 12.9029Z"
                    fill="#F6F5F5"
                  ></path>
                </svg>
              </button>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="6"
                height="39"
                viewBox="0 0 6 39"
                fill="none"
              >
                <rect
                  x="5"
                  width="1"
                  height="39"
                  fill="#D9D9D9"
                  fill-opacity="0.7"
                ></rect>
                <rect
                  y="9"
                  width="1"
                  height="20"
                  fill="#D9D9D9"
                  fill-opacity="0.7"
                ></rect>
              </svg>
              <div class="logo d-none d-sm-block">
                <a href="{{ url('/enquiry') }}" class="vs-btn style10">
                  <span>let’s plan</span>
                </a>
              </div>
              <div class="logo d-sm-none">
                <a href="{{ url('/') }}">
                  @if(isset($company_setting) && $company_setting->logo_path)
                    <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'logo' }}" style="height: 40px; max-height: 40px; width: auto; object-fit: contain;" />
                  @else
                    <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="logo" />
                  @endif
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Header Area -->
    <header class="vs-header layout1">
      <div class="sticky-wrapper position-relative">
        <div class="header-top-wrap">
          <div class="container custom-container">
            <div class="row">
              <div class="col-lg-12">
                <div class="header-top">
                  <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-md-6 d-none d-md-block">
                      <div class="contact-info">
                        <ul class="custom-ul">
                          @if(isset($company_setting) && $company_setting->phone)
                            <li>
                              <i class="fa-solid fa-phone-volume"></i>
                              <a href="tel:{{ $company_setting->phone }}">{{ $company_setting->phone }}</a>
                            </li>
                          @endif
                          @if(isset($company_setting) && ($company_setting->phone && $company_setting->company_email))
                            <li>
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="4"
                                height="22"
                                viewBox="0 0 4 22"
                                fill="none"
                              >
                                <line
                                  x1="0.75"
                                  y1="2.774e-08"
                                  x2="0.749999"
                                  y2="21.6114"
                                  stroke="white"
                                  stroke-opacity="0.3"
                                  stroke-width="1.5"
                                />
                                <line
                                  x1="3.5"
                                  y1="3.92926"
                                  x2="3.5"
                                  y2="17.682"
                                  stroke="white"
                                  stroke-opacity="0.3"
                                />
                              </svg>
                            </li>
                          @endif
                          @if(isset($company_setting) && $company_setting->company_email)
                            <li>
                              <i class="fa-solid fa-envelope"></i>
                              <a href="mailto:{{ $company_setting->company_email }}">
                                {{ $company_setting->company_email }}
                              </a>
                            </li>
                          @endif
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="social-share">
                        <span class="info-share">Follow on:</span>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="4"
                          height="22"
                          viewBox="0 0 4 22"
                          fill="none"
                        >
                          <line
                            x1="0.75"
                            y1="2.774e-08"
                            x2="0.749999"
                            y2="21.6114"
                            stroke="white"
                            stroke-opacity="0.3"
                            stroke-width="1.5"
                          />
                          <line
                            x1="3.5"
                            y1="3.92941"
                            x2="3.5"
                            y2="17.6821"
                            stroke="white"
                            stroke-opacity="0.3"
                          />
                        </svg>
                        <ul class="custom-ul">
                          @if(isset($company_setting) && $company_setting->twitter)
                            <li>
                              <a href="{{ $company_setting->twitter }}" target="_blank">
                                <i class="fa-brands fa-x-twitter"></i>
                              </a>
                            </li>
                          @endif
                          @if(isset($company_setting) && $company_setting->facebook)
                            <li>
                              <a href="{{ $company_setting->facebook }}" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                              </a>
                            </li>
                          @endif
                          @if(isset($company_setting) && $company_setting->linkedin)
                            <li>
                              <a href="{{ $company_setting->linkedin }}" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                              </a>
                            </li>
                          @endif
                          @if(isset($company_setting) && $company_setting->instagram)
                            <li>
                              <a href="{{ $company_setting->instagram }}" target="_blank">
                                <i class="fab fa-instagram"></i>
                              </a>
                            </li>
                          @endif
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container custom-container">
          <div class="row justify-content-between align-items-center">
            <div class="col-xl-3 col-lg-auto">
              <div class="header-logo d-flex justify-content-between align-items-center">
                <a href="{{ url('/') }}">
                  @if(isset($company_setting) && $company_setting->logo_path)
                    <img src="{{ asset($company_setting->logo_path) }}" alt="{{ $company_setting->company_name ?? 'logo' }}" style="height: 50px; max-height: 50px; width: auto; object-fit: contain;" />
                  @else
                    <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" class="logo" />
                  @endif
                </a>
                <div class="d-flex align-items-center gap-3">
                  <button class="wc-link2 searchBoxTggler d-lg-none">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="21"
                      height="20"
                      viewBox="0 0 21 20"
                      fill="none"
                    >
                      <path
                        d="M20.4174 16.6954L17.2213 13.4773C19.3155 10.0703 18.8936 5.54217 15.9593 2.58766C12.5328 -0.862552 6.9769 -0.862552 3.55037 2.58766C0.123835 6.03787 0.123835 11.6322 3.55037 15.0824C6.5354 18.088 11.1341 18.4736 14.5333 16.2469L17.7019 19.4335C18.4521 20.1888 19.6711 20.1888 20.4213 19.4335C21.1675 18.6781 21.1675 17.4507 20.4174 16.6954ZM5.711 12.9029C3.48395 10.6604 3.48395 7.00959 5.711 4.76715C7.93805 2.52471 11.5638 2.52471 13.7909 4.76715C16.018 7.00959 16.018 10.6604 13.7909 12.9029C11.5638 15.1453 7.93805 15.1453 5.711 12.9029Z"
                        fill="#F6F5F5"
                      ></path>
                    </svg>
                  </button>
                  <button class="vs-menu-toggle d-inline-block d-lg-none">
                    <i class="fal fa-bars"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-xl-9 col-lg-auto d-none d-lg-flex justify-content-end gap-md-4 gap-xl-5">
              <nav class="main-menu menu-style1 d-none d-lg-block">
                <ul class="d-flex justify-content-center align-items-center">
                  <li class="{{ Request::is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}">Home</a>
                  </li>
                  <li class="{{ Request::is('about') ? 'active' : '' }}">
                    <a href="{{ url('/about') }}">About Us</a>
                  </li>
                  <li class="{{ Request::is('destination') ? 'active' : '' }}">
                    <a href="{{ url('/destination') }}">Destinations</a>
                  </li>
                  <li class="{{ Request::is('tours') ? 'active' : '' }}">
                    <a href="{{ url('/tours') }}">Tours</a>
                  </li>
                  <li class="{{ Request::is('blog') || Request::is('blog-single/*') ? 'active' : '' }}">
                    <a href="{{ url('/blog') }}">Blog</a>
                  </li>
                  <li class="{{ Request::is('contact') ? 'active' : '' }}">
                    <a href="{{ url('/contact') }}">Contact</a>
                  </li>
                </ul>
              </nav>
              <div class="header-wc style2">
                <button class="wc-link2 searchBoxTggler">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="21"
                    height="20"
                    viewBox="0 0 21 20"
                    fill="none"
                  >
                    <path
                      d="M20.4174 16.6954L17.2213 13.4773C19.3155 10.0703 18.8936 5.54217 15.9593 2.58766C12.5328 -0.862552 6.9769 -0.862552 3.55037 2.58766C0.123835 6.03787 0.123835 11.6322 3.55037 15.0824C6.5354 18.088 11.1341 18.4736 14.5333 16.2469L17.7019 19.4335C18.4521 20.1888 19.6711 20.1888 20.4213 19.4335C21.1675 18.6781 21.1675 17.4507 20.4174 16.6954ZM5.711 12.9029C3.48395 10.6604 3.48395 7.00959 5.711 4.76715C7.93805 2.52471 11.5638 2.52471 13.7909 4.76715C16.018 7.00959 16.018 10.6604 13.7909 12.9029C11.5638 15.1453 7.93805 15.1453 5.711 12.9029Z"
                      fill="#F6F5F5"
                    />
                  </svg>
                </button>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="6"
                  height="39"
                  viewBox="0 0 6 39"
                  fill="none"
                >
                  <rect
                    x="5"
                    width="1"
                    height="39"
                    fill="#D9D9D9"
                    fill-opacity="0.7"
                  />
                  <rect
                    y="9"
                    width="1"
                    height="20"
                    fill="#D9D9D9"
                    fill-opacity="0.7"
                  />
                </svg>
                <a href="{{ url('/enquiry') }}" class="vs-btn style8">
                  <span>let’s plan</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
