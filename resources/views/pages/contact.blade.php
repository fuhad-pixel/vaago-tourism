@extends('layouts.app')

@section('content')
      <!--================= Breadcrumb Area start =================-->
      <section
        class="vs-breadcrumb"
        data-bg-src="{{ isset($hero_setting) && $hero_setting->image_path ? asset($hero_setting->image_path) : asset('assets/img/bg/breadcrumb-bg.png') }}"
        style="background-image: url('{{ isset($hero_setting) && $hero_setting->image_path ? asset($hero_setting->image_path) : asset('assets/img/bg/breadcrumb-bg.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;"
      >
        <!-- Overlay for better text readability -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.45); z-index: 1;"></div>

        <img
          src="{{ asset('assets/img/icons/cloud.png') }}"
          alt="vs-breadcrumb-icon"
          class="vs-breadcrumb-icon-1 animate-parachute"
          style="z-index: 2;"
        />
        <img
          src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
          alt="vs-breadcrumb-icon"
          class="vs-breadcrumb-icon-2 animate-parachute"
          style="z-index: 2;"
        />
        <div class="container" style="position: relative; z-index: 2;">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">{{ isset($hero_setting) && $hero_setting->title ? $hero_setting->title : 'Contact Us' }}</h1>
                @if(isset($hero_setting) && $hero_setting->description)
                  <p class="breadcrumb-text" style="color: rgba(255, 255, 255, 0.9); font-size: 16px; margin-top: 10px; max-width: 600px; margin-left: auto; margin-right: auto; font-weight: 500;">
                    {{ $hero_setting->description }}
                  </p>
                @endif
              </div>
              <div class="breadcrumb-menu">
                <ul class="custom-ul">
                  <li>
                    <a href="{{ url('/') }}">Home</a>
                  </li>
                  <li>Contact Us</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Contact Area Start =================-->
      <section class="vs-contact space">
        <div class="container">
          <div class="row g-4 gx-xl-5 overflow-hidden">
            <!-- Contact Info -->
            <div class="col-lg-5">
              <div class="title-area text-start mb-2">
                <span class="sec-subtitle style-2">contact us</span>
                <h2 class="sec-title">Get in touch with us</h2>
              </div>
              <div class="vs-contact-info mt-3 mb-2">
                @if($company_setting->address)
                  <p>
                    <span class="text-theme-color fw-bold">Address:</span> {{ $company_setting->address }}
                  </p>
                @endif
                <div class="vs-contact-list">
                  @if($company_setting->phone)
                    <div class="contact-item">
                      <span class="icon">
                        <i class="fa-solid fa-phone-volume"></i>
                      </span>
                      <div class="info">
                        <h6 class="info-title">Phone Number :</h6>
                        <p>
                          <a href="tel:{{ $company_setting->phone }}">{{ $company_setting->phone }}</a>
                        </p>
                      </div>
                    </div>
                  @endif

                  @if($company_setting->whatsapp)
                    <div class="contact-item">
                      <span class="icon" style="color: #25D366; background: rgba(37, 211, 102, 0.1);">
                        <i class="fa-brands fa-whatsapp"></i>
                      </span>
                      <div class="info">
                        <h6 class="info-title">WhatsApp :</h6>
                        <p>
                          <a href="https://wa.me/{{ $company_setting->whatsapp }}" target="_blank">{{ $company_setting->whatsapp }}</a>
                        </p>
                      </div>
                    </div>
                  @endif

                  @if($company_setting->company_email)
                    <div class="contact-item">
                      <span class="icon">
                        <i class="fa-regular fa-envelope"></i>
                      </span>
                      <div class="info">
                        <h6 class="info-title">Email Address :</h6>
                        <p>
                          <a href="mailto:{{ $company_setting->company_email }}">{{ $company_setting->company_email }}</a>
                        </p>
                      </div>
                    </div>
                  @endif
                </div>

                <div class="social-follow">
                  <span>Follow Us :</span>
                  <ul class="custom-ul">
                    @if($company_setting->facebook)
                      <li>
                        <a href="{{ $company_setting->facebook }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                      </li>
                    @endif
                    @if($company_setting->twitter)
                      <li>
                        <a href="{{ $company_setting->twitter }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                      </li>
                    @endif
                    @if($company_setting->instagram)
                      <li>
                        <a href="{{ $company_setting->instagram }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                      </li>
                    @endif
                    @if($company_setting->youtube)
                      <li>
                        <a href="{{ $company_setting->youtube }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                      </li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>

            <!-- Contact/Enquiry Form -->
            <div class="col-lg-7">
              <form
                id="contact-enquiry-form"
                action="{{ url('/enquiry/submit') }}"
                method="POST"
                class="form-style1"
                style="background: #fff; box-shadow: 0 15px 40px rgba(0,0,0,0.05); border-radius: 20px; padding: 40px;"
              >
                @csrf
                <h3 class="mb-2" style="font-weight: 700; color: #141414;">Get a FREE Holiday Plan</h3>
                <p class="mb-4 text-muted" style="font-size: 14px;">We will provide you a FREE Holiday Itinerary & plan based on the details you share with us in the below form.</p>

                <div class="row">
                  <!-- Name fields -->
                  <div class="col-md-6 form-group">
                    <input
                      name="first_name"
                      type="text"
                      class="form-control"
                      placeholder="First Name"
                      required
                    />
                  </div>
                  <div class="col-md-6 form-group">
                    <input
                      name="last_name"
                      type="text"
                      class="form-control"
                      placeholder="Last Name"
                      required
                    />
                  </div>

                  <!-- Email & Phone fields -->
                  <div class="col-md-6 form-group">
                    <input
                      name="email"
                      type="email"
                      class="form-control"
                      placeholder="Email Address *"
                      required
                    />
                  </div>
                  <div class="col-md-6 form-group">
                    <input
                      name="phone"
                      type="tel"
                      class="form-control"
                      placeholder="Phone (with Country Code) *"
                      required
                    />
                  </div>

                  <!-- Arrival Date & Nights fields -->
                  <div class="col-md-6 form-group">
                    <label class="form-label text-title-color fw-semibold" style="font-size: 13px; margin-bottom: 5px;">Tentative Date of Arrival</label>
                    <input
                      name="arrival_date"
                      type="date"
                      class="form-control"
                    />
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="form-label text-title-color fw-semibold" style="font-size: 13px; margin-bottom: 5px;">Number of Nights *</label>
                    <input
                      name="nights"
                      type="number"
                      class="form-control"
                      placeholder="e.g. 5"
                      min="1"
                      max="99"
                      required
                    />
                  </div>

                  <!-- Accommodation & Honeymoon selects -->
                  <div class="col-md-6 form-group">
                    <label class="form-label text-title-color fw-semibold" style="font-size: 13px; margin-bottom: 5px;">Accommodation Type</label>
                    <select name="accommodation_type" class="form-select" style="height: 52px !important; border: 1px solid #f0f0f0; padding-left: 20px; font-size: 14px; font-weight: 500; color: #535b5f;">
                      <option value="">Select Stay Type</option>
                      <option value="Not Yet Decided">Not Yet Decided</option>
                      <option value="Only Homestays/ Bed & Breakfast">Only Homestays/ Bed & Breakfast</option>
                      <option value="Budget Hotels">Budget Hotels</option>
                      <option value="3 Star Hotels/ Houseboat">3 Star Hotels/ Houseboat</option>
                      <option value="4 Star Resorts / Houseboat">4 Star Resorts / Houseboat</option>
                      <option value="Luxury 5 Star Resorts / Houseboat">Luxury 5 Star Resorts / Houseboat</option>
                      <option value="Houseboat Day Cruise">Houseboat Day Cruise</option>
                      <option value="Houseboat OverNight Stay & Cruise">Houseboat OverNight Stay & Cruise</option>
                    </select>
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="form-label text-title-color fw-semibold" style="font-size: 13px; margin-bottom: 5px;">Trip Type / Honeymoon?</label>
                    <select name="honeymoon" class="form-select" style="height: 52px !important; border: 1px solid #f0f0f0; padding-left: 20px; font-size: 14px; font-weight: 500; color: #535b5f;">
                      <option value="No" {{ request('trip_type') != 'honeymoon' ? 'selected' : '' }}>Standard Trip</option>
                      <option value="Yes" {{ request('trip_type') == 'honeymoon' ? 'selected' : '' }}>Honeymoon Trip</option>
                      <option value="Family" {{ request('trip_type') == 'family' ? 'selected' : '' }}>Family Trip</option>
                      <option value="Friends" {{ request('trip_type') == 'friends' ? 'selected' : '' }}>Friends Trip</option>
                      <option value="Group" {{ request('trip_type') == 'group' ? 'selected' : '' }}>Group Trip</option>
                      <option value="Solo" {{ request('trip_type') == 'solo' ? 'selected' : '' }}>Solo Trip</option>
                    </select>
                  </div>

                  <!-- Comments / message -->
                  <div class="col-12 form-group">
                    <label class="form-label text-title-color fw-semibold" style="font-size: 13px; margin-bottom: 5px;">Comments / Details *</label>
                    <textarea
                      name="message"
                      class="form-control"
                      placeholder="Indicate number of guests and other preferences..."
                      required
                      style="min-height: 120px;"
                    >{{ old('message', isset($tour) ? "Hi, I would like to get a FREE holiday plan and enquire about the tour: " . $tour->name . " (Code: " . $tour->tour_code . "). Please share the itinerary and booking details." : '') }}</textarea>
                  </div>

                  <!-- Submit button -->
                  <div class="col-12 form-group mt-2 mb-0">
                    <button class="vs-btn style4 w-100" type="submit">Send Enquiry Request</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
      <!--================= Contact Area end =================-->

      <!--================= Map Area start =================-->
      @if($company_setting->address)
        <div class="map-layout1">
          <iframe
            src="https://maps.google.com/maps?q={{ urlencode($company_setting->address) }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
            height="450"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      @endif
      <!--================= Map Area end =================-->

<!-- jQuery Validation Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        const $form = $('#contact-enquiry-form');
        
        if ($form.length) {
            $form.validate({
                rules: {
                    first_name: { required: true, minlength: 2 },
                    last_name: { required: true, minlength: 2 },
                    email: { required: true, email: true },
                    phone: { required: true, minlength: 8 },
                    nights: { required: true, number: true, min: 1 },
                    message: { required: true, minlength: 10 }
                },
                messages: {
                    first_name: "Please enter your first name",
                    last_name: "Please enter your last name",
                    email: "Please enter a valid email address",
                    phone: "Please enter a valid phone number",
                    nights: "Please enter a valid number of nights",
                    message: "Please provide some details about your trip"
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback text-danger d-block mt-1' );
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    const $submitBtn = $(form).find('button[type="submit"]');
                    const originalBtnText = $submitBtn.text();
                    
                    $submitBtn.html('<i class="fa-solid fa-circle-notch fa-spin"></i> Sending...').prop('disabled', true);
                    
                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.success) {
                                showToast('success', 'Success', response.message);
                                form.reset();
                            } else {
                                showToast('error', 'Error', 'Something went wrong. Please try again.');
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = 'An error occurred while submitting your enquiry.';
                            if(xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            showToast('error', 'Error', errorMsg);
                        },
                        complete: function() {
                            $submitBtn.html(originalBtnText).prop('disabled', false);
                        }
                    });
                    
                    return false; // Prevent standard form submission
                }
            });
        }
    });
</script>
@endsection
