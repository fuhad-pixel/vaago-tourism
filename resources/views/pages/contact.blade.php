@extends('layouts.app')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ asset('images/bg_1.jpg') }});">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
      <div class="col-md-9 ftco-animate pb-5 text-center">
       <p class="breadcrumbs"><span class="me-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span> <span>Contact us <i class="fa fa-chevron-right"></i></span></p>
       <h1 class="mb-0 bread">Contact us</h1>
     </div>
   </div>
 </div>
</section>

<section class="ftco-section ftco-no-pb contact-section mb-4">
  <div class="container">
    <div class="row d-flex contact-info">
      <div class="col-md-3 d-flex">
       <div class="align-self-stretch box p-4 text-center" style="width: 100%; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <div class="icon d-flex align-items-center justify-content-center">
         <span class="fa fa-map-marker"></span>
       </div>
       <h3 class="mb-2">Address</h3>
       <p>{{ $company_setting->address ?? '198 West 21th Street, Suite 721 New York NY 10016' }}</p>
     </div>
    </div>
    <div class="col-md-3 d-flex">
      <div class="align-self-stretch box p-4 text-center" style="width: 100%; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
       <div class="icon d-flex align-items-center justify-content-center">
        <span class="fa fa-phone"></span>
      </div>
      <h3 class="mb-2">Contact Number</h3>
      <p>
        @if(isset($company_setting) && $company_setting->phone)
          <a href="tel:{{ $company_setting->phone }}">{{ $company_setting->phone }}</a>
        @else
          <a href="tel://1234567920">+ 1235 2355 98</a>
        @endif
      </p>
    </div>
  </div>
  <div class="col-md-3 d-flex">
    <div class="align-self-stretch box p-4 text-center" style="width: 100%; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
     <div class="icon d-flex align-items-center justify-content-center">
      <span class="fa fa-paper-plane"></span>
    </div>
    <h3 class="mb-2">Email Address</h3>
    <p>
      @if(isset($company_setting) && $company_setting->company_email)
        <a href="mailto:{{ $company_setting->company_email }}">{{ $company_setting->company_email }}</a>
      @else
        <a href="mailto:info@yoursite.com">info@yoursite.com</a>
      @endif
    </p>
  </div>
 </div>
 <div class="col-md-3 d-flex">
  <div class="align-self-stretch box p-4 text-center" style="width: 100%; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
   <div class="icon d-flex align-items-center justify-content-center">
    <span class="fa fa-globe"></span>
  </div>
  <h3 class="mb-2">Website</h3>
  <p><a href="{{ url('/') }}">{{ request()->getHost() }}</a></p>
 </div>
 </div>
 </div>
 </div>
 </section>

<section class="ftco-section contact-section ftco-no-pt">
  <div class="container">
    <div class="row block-9 justify-content-center">
      <div class="col-md-10 d-flex">
        <form action="#" class="bg-light p-5 contact-form" style="width: 100%; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
          <h2 class="mb-2" style="font-weight: 700; color: #000;">Get a FREE Holiday Plan</h2>
          <p class="mb-4 text-muted" style="font-size: 14px;">We will provide you a FREE Holiday Itinerary & plan based on the details you share with us in the below form</p>

          <!-- Name Field -->
          <div class="row mb-3">
            <div class="col-md-12">
              <div class="form-group">
                <label for="first_name" style="font-weight: 600; color: #333; margin-bottom: 8px; display: block; white-space: nowrap;">Name</label>
                <div class="row">
                  <div class="col-sm-6 mb-2">
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" style="height: 52px; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;">
                    <small class="text-muted" style="font-size: 11px;">First</small>
                  </div>
                  <div class="col-sm-6 mb-2">
                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" style="height: 52px; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;">
                    <small class="text-muted" style="font-size: 11px;">Last</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Email & Phone Fields -->
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="form-group">
                <label for="email" style="font-weight: 600; color: #333; margin-bottom: 8px; display: block; white-space: nowrap;">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" required style="height: 52px; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone" style="font-weight: 600; color: #333; margin-bottom: 8px; display: block; white-space: nowrap;">Phone (with country codes) <span class="text-danger">*</span></label>
                <input type="text" name="phone" id="phone" class="form-control" required style="height: 52px; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;">
              </div>
            </div>
          </div>

          <!-- Arrival Date & Nights Fields -->
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="form-group">
                <label for="arrival_date" style="font-weight: 600; color: #333; margin-bottom: 8px; display: block; white-space: nowrap;">Tentative Date of Arrival</label>
                <input type="date" name="arrival_date" id="arrival_date" class="form-control" style="height: 52px; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nights" style="font-weight: 600; color: #333; margin-bottom: 8px; display: block; white-space: nowrap;">No. of Nights <span class="text-danger">*</span></label>
                <input type="number" name="nights" id="nights" class="form-control" min="1" max="99" required style="height: 52px; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;">
                <small class="text-muted" style="font-size: 11px;">Maximum of 2 digits.</small>
              </div>
            </div>
          </div>

          <!-- Accommodation & Honeymoon Fields -->
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="form-group">
                <label for="accommodation_type" style="font-weight: 600; color: #333; margin-bottom: 8px; display: block; white-space: nowrap;">Select Accommodation Type</label>
                <select name="accommodation_type" id="accommodation_type" class="form-control" style="height: 52px !important; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;">
                  <option value="">Select Type of Stay</option>
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
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="honeymoon" style="font-weight: 600; color: #333; margin-bottom: 8px; display: block; white-space: nowrap;">Are you looking for a Honeymoon?</label>
                <select name="honeymoon" id="honeymoon" class="form-control" style="height: 52px !important; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px;">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                  <option value="Not Sure">Not Sure</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Comments/Questions/Queries Field -->
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="form-group">
                <label for="message" style="font-weight: 600; color: #333; margin-bottom: 8px; display: block;">Comments/ Questions/ Queries <span class="text-danger">*</span></label>
                <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Indicate the number of people travelling with you and submit more details about your request including destinations and activities you may want in your holiday" required style="height: auto !important; min-height: 120px; background: #fff; border: 1px solid rgba(0,0,0,0.1); border-radius: 6px; padding: 12px;">{{ old('message', isset($tour) ? "Hi, I would like to get a FREE holiday plan and enquire about the tour: " . $tour->name . " (Code: " . $tour->tour_code . "). Please share the itinerary and booking details." : '') }}</textarea>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary py-3 px-5" style="border-radius: 30px; font-weight: 600; padding: 12px 48px !important;">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<section class="ftco-intro ftco-section ftco-no-pt">
 <div class="container">
  <div class="row justify-content-center">
   <div class="col-md-12 text-center">
    <div class="img"  style="background-image: url({{ asset('images/bg_2.jpg') }});">
     <div class="overlay"></div>
     <h2>We Are Pacific A Travel Agency</h2>
     <p>We can manage your dream building A small river named Duden flows by their place</p>
     <p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Ask For A Quote</a></p>
   </div>
 </div>
</div>
</div>
</section>
@endsection
