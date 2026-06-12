@extends('layouts.app')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ asset('images/bg_1.jpg') }});">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
      <div class="col-md-9 ftco-animate pb-5 text-center">
         <p class="breadcrumbs"><span class="me-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span> <span>Tour List <i class="fa fa-chevron-right"></i></span></p>
         <h1 class="mb-0 bread">Tours List</h1>
     </div>
 </div>
</div>
</section>

<section class="ftco-section ftco-no-pb">
   <div class="container">
      <div class="row">
       <div class="col-md-12">
          <div class="search-wrap-1 ftco-animate">
             <form action="{{ url('destination') }}" method="GET" class="search-property-1">
                <div class="row no-gutters">
                   <div class="col-lg d-flex">
                      <div class="form-group p-4 border-0">
                         <label for="destination_id">Destination</label>
                         <div class="form-field">
                           <div class="select-wrap">
                            <div class="icon"><span class="fa fa-chevron-down"></span></div>
                            <select name="destination_id" id="destination_id" class="form-control">
                              <option value="">All Destinations</option>
                              @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>{{ $dest->name }}</option>
                              @endforeach
                            </select>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-flex">
                   <div class="form-group p-4">
                      <label for="category_id">Category</label>
                      <div class="form-field">
                        <div class="select-wrap">
                          <div class="icon"><span class="fa fa-chevron-down"></span></div>
                          <select name="category_id" id="category_id" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                              <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg d-flex">
               <div class="form-group p-4">
                  <label for="price">Price Limit</label>
                  <div class="form-field">
                    <div class="select-wrap">
                     <div class="icon"><span class="fa fa-chevron-down"></span></div>
                     <select name="price" id="price" class="form-control">
                       <option value="">No Limit</option>
                       <option value="500" {{ request('price') == '500' ? 'selected' : '' }}>Up to $500</option>
                       <option value="1000" {{ request('price') == '1000' ? 'selected' : '' }}>Up to $1,000</option>
                       <option value="2000" {{ request('price') == '2000' ? 'selected' : '' }}>Up to $2,000</option>
                       <option value="5000" {{ request('price') == '5000' ? 'selected' : '' }}>Up to $5,000</option>
                       <option value="10000" {{ request('price') == '10000' ? 'selected' : '' }}>Up to $10,000</option>
                     </select>
                    </div>
                  </div>
               </div>
            </div>
            <div class="col-lg d-flex">
              <div class="form-group d-flex w-100 border-0">
                 <div class="form-field w-100 align-items-center d-flex">
                    <input type="submit" value="Search" class="align-self-stretch form-control btn btn-primary">
                 </div>
              </div>
            </div>
         </div>
         </form>
         </div>
      </div>
      </div>
   </div>
</section>

<section class="ftco-section">
   <div class="container">
     <div class="row">
        @if($tours->count() > 0)
          @foreach($tours as $tour)
            <div class="col-md-4 ftco-animate">
              <div class="project-wrap">
                <a href="{{ url('tour/' . $tour->slug) }}" class="img" style="background-image: url('{{ $tour->images->count() > 0 ? asset($tour->images->first()->image_path) : asset('images/destination-1.jpg') }}');">
                  @if($tour->discount_price)
                    <span class="price"><del>${{ number_format($tour->original_price, 0) }}</del> ${{ number_format($tour->discount_price, 0) }}/{{ $tour->price_type == 'per_person' ? 'person' : ($tour->price_type == 'per_vehicle' ? 'vehicle' : 'group') }}</span>
                  @else
                    <span class="price">${{ number_format($tour->original_price, 0) }}/{{ $tour->price_type == 'per_person' ? 'person' : ($tour->price_type == 'per_vehicle' ? 'vehicle' : 'group') }}</span>
                  @endif
                </a>
                <div class="text p-4">
                  @if($tour->duration_days > 0 || $tour->duration_nights > 0)
                    <span class="days">
                      @if($tour->duration_days > 0)
                        {{ $tour->duration_days }} {{ \Illuminate\Support\Str::plural('Day', $tour->duration_days) }}
                      @endif
                      @if($tour->duration_nights > 0)
                        {{ $tour->duration_days > 0 ? '/' : '' }} {{ $tour->duration_nights }} {{ \Illuminate\Support\Str::plural('Night', $tour->duration_nights) }}
                      @endif
                      Tour
                    </span>
                  @else
                    <span class="days">Tour</span>
                  @endif
                  
                  <h3 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; margin-bottom: 8px;">
                    <a href="{{ url('tour/' . $tour->slug) }}" title="{{ $tour->name }}">{{ $tour->name }}</a>
                  </h3>
                  
                  <p class="location"><span class="fa fa-map-marker"></span> {{ $tour->destination->name }}</p>
                  <ul>
                    @if($tour->min_guests || $tour->max_guests)
                      <li><span class="fa fa-users"></span> 
                        @if($tour->min_guests && $tour->max_guests)
                          {{ $tour->min_guests }}-{{ $tour->max_guests }} Guests
                        @elseif($tour->min_guests)
                          Min {{ $tour->min_guests }} Guests
                        @else
                          Max {{ $tour->max_guests }} Guests
                        @endif
                      </li>
                    @endif
                    @php
                      $cardInclusions = $tour->additional_inclusions_models->take(3);
                    @endphp
                    @if($cardInclusions->count() > 0)
                      @foreach($cardInclusions as $inclusion)
                        <li title="{{ $inclusion->name }}"><span class="{{ $inclusion->icon }}"></span></li>
                      @endforeach
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="col-md-12 text-center py-5 px-3" style="background: rgba(255,255,255,0.8); border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.05); margin-top: 30px;">
            <div class="py-4">
              <span class="fa-solid fa-magnifying-glass text-muted mb-3" style="font-size: 48px; color: #f15d30 !important;"></span>
              <h3 class="mb-2" style="font-weight: 700; color: #111827;">No Tours Found</h3>
              <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto; font-size: 16px;">We couldn't find any tours matching your filter criteria. Try adjusting your destination, category, or price limit selection to explore other options.</p>
              <a href="{{ url('destination') }}" class="btn btn-primary px-4 py-2" style="border-radius: 30px; font-weight: 600;">Clear Filters</a>
            </div>
          </div>
        @endif
     </div>
     @if ($tours->hasPages())
     <div class="row mt-5">
       <div class="col text-center">
         <div class="block-27">
           <ul>
             {{-- Previous Page Link --}}
             @if ($tours->onFirstPage())
               <li class="disabled"><span>&lt;</span></li>
             @else
               <li><a href="{{ $tours->previousPageUrl() }}">&lt;</a></li>
             @endif

             {{-- Pagination Elements --}}
             @for ($i = 1; $i <= $tours->lastPage(); $i++)
               @if ($i == $tours->currentPage())
                 <li class="active"><span>{{ $i }}</span></li>
               @else
                 <li><a href="{{ $tours->url($i) }}">{{ $i }}</a></li>
               @endif
             @endfor

             {{-- Next Page Link --}}
             @if ($tours->hasMorePages())
               <li><a href="{{ $tours->nextPageUrl() }}">&gt;</a></li>
             @else
               <li class="disabled"><span>&gt;</span></li>
             @endif
           </ul>
         </div>
       </div>
     </div>
     @endif
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
