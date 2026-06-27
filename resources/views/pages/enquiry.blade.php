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
                <h1 class="breadcrumb-title">Plan Your Dream Trip</h1>
                <p class="breadcrumb-text" style="color: rgba(255, 255, 255, 0.9); font-size: 16px; margin-top: 10px; max-width: 600px; margin-left: auto; margin-right: auto; font-weight: 500;">
                  Tell us your preferences and get a customized travel plan for free!
                </p>
              </div>
              <div class="breadcrumb-menu">
                <ul class="custom-ul">
                  <li>
                    <a href="{{ url('/') }}">Home</a>
                  </li>
                  <li>Plan Your Trip</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Enquiry Area Start =================-->
      <section class="vs-contact space" style="padding-top: 60px !important;">
        <div class="container">
          <div class="row g-4 gx-xl-5 overflow-hidden align-items-start">
            <!-- Modern & Professional Contents (Left Side) -->
            <div class="col-lg-5">
              <div class="title-area text-start mb-4">
                <span class="sec-subtitle style-2">expert holiday planners</span>
                <h2 class="sec-title" style="font-size: 32px; font-weight: 800; line-height: 1.2;">Why Plan Your Trip With Us?</h2>
              </div>
              
              <!-- Core Features List -->
              <div class="enquiry-features-list mb-5">
                <div class="d-flex align-items-start mb-4">
                  <div class="d-flex align-items-center justify-content-center text-white bg-theme-color rounded-3 me-3" style="width: 50px; height: 50px; min-width: 50px; font-size: 20px; box-shadow: 0 4px 10px rgba(0, 101, 108, 0.2);">
                    <i class="fa-solid fa-map-location-dot"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold mb-1" style="font-size: 16px; color: #1e293b;">100% Customized Itineraries</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.5;">Every aspect of your trip is tailormade to fit your choice, pace, and interests perfectly.</p>
                  </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                  <div class="d-flex align-items-center justify-content-center text-white bg-theme-color rounded-3 me-3" style="width: 50px; height: 50px; min-width: 50px; font-size: 20px; box-shadow: 0 4px 10px rgba(0, 101, 108, 0.2);">
                    <i class="fa-solid fa-hotel"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold mb-1" style="font-size: 16px; color: #1e293b;">Handpicked Stays & Transports</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.5;">Verified cozy homestays, premium resorts, and safe drivers for a hassle-free journey.</p>
                  </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                  <div class="d-flex align-items-center justify-content-center text-white bg-theme-color rounded-3 me-3" style="width: 50px; height: 50px; min-width: 50px; font-size: 20px; box-shadow: 0 4px 10px rgba(0, 101, 108, 0.2);">
                    <i class="fa-solid fa-tags"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold mb-1" style="font-size: 16px; color: #1e293b;">Zero Hidden Charges</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.5;">Get clear transparent pricing breakdowns. What you see is exactly what you pay.</p>
                  </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                  <div class="d-flex align-items-center justify-content-center text-white bg-theme-color rounded-3 me-3" style="width: 50px; height: 50px; min-width: 50px; font-size: 20px; box-shadow: 0 4px 10px rgba(0, 101, 108, 0.2);">
                    <i class="fa-solid fa-headset"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold mb-1" style="font-size: 16px; color: #1e293b;">24/7 On-Trip Assistance</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.5;">Our operations team is just a call away to assist you instantly throughout the road.</p>
                  </div>
                </div>
              </div>

              <!-- How it works Timeline -->
              <div class="how-it-works-panel p-4 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                <h5 class="fw-bold mb-3" style="font-size: 18px; color: #0f172a;"><i class="fa-solid fa-wand-magic-sparkles text-theme-color me-2"></i> How It Works</h5>
                
                <div class="timeline-container ps-3" style="border-left: 2px dashed #cbd5e1; position: relative; margin-left: 10px;">
                  <div class="mb-3 position-relative">
                    <span class="position-absolute rounded-circle bg-theme-color" style="width: 10px; height: 10px; left: -16px; top: 6px;"></span>
                    <span class="text-xs text-theme-color fw-bold uppercase" style="font-size: 10px; letter-spacing: 0.5px; display: block;">Step 01</span>
                    <strong style="font-size: 13.5px; color: #1e293b;">Submit Preferences</strong>
                    <p class="text-muted mb-0" style="font-size: 12px;">Fill out the request form with dates, nights, and stay choices.</p>
                  </div>

                  <div class="mb-3 position-relative">
                    <span class="position-absolute rounded-circle bg-theme-color" style="width: 10px; height: 10px; left: -16px; top: 6px;"></span>
                    <span class="text-xs text-theme-color fw-bold uppercase" style="font-size: 10px; letter-spacing: 0.5px; display: block;">Step 02</span>
                    <strong style="font-size: 13.5px; color: #1e293b;">Get Plan & Drafts</strong>
                    <p class="text-muted mb-0" style="font-size: 12px;">Our destination specialist emails a custom itinerary copy.</p>
                  </div>

                  <div class="position-relative">
                    <span class="position-absolute rounded-circle bg-theme-color" style="width: 10px; height: 10px; left: -16px; top: 6px;"></span>
                    <span class="text-xs text-theme-color fw-bold uppercase" style="font-size: 10px; letter-spacing: 0.5px; display: block;">Step 03</span>
                    <strong style="font-size: 13.5px; color: #1e293b;">Customize & Book</strong>
                    <p class="text-muted mb-0" style="font-size: 12px;">Tailor the plan until you're completely satisfied and book.</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Enquiry Form (Right Side) -->
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
      <!--================= Enquiry Area end =================-->

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
