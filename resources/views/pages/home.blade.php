@extends('layouts.app')

@section('content')
<style>
	.home-slider .hero-wrap {
		background-attachment: scroll !important;
	}
	.home-slider .owl-nav {
		position: absolute;
		top: 50%;
		width: 100%;
		transform: translateY(-50%);
		z-index: 10;
		display: flex;
		justify-content: space-between;
		padding: 0 30px;
		pointer-events: none;
	}
	.home-slider .owl-nav button.owl-prev,
	.home-slider .owl-nav button.owl-next {
		background: rgba(255, 255, 255, 0.1) !important;
		border: 1px solid rgba(255, 255, 255, 0.2) !important;
		color: #fff !important;
		width: 50px;
		height: 50px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 18px;
		transition: all 0.3s ease;
		pointer-events: auto;
	}
	.home-slider .owl-nav button.owl-prev:hover,
	.home-slider .owl-nav button.owl-next:hover {
		background: #f15d30 !important;
		border-color: #f15d30 !important;
		color: #fff !important;
	}
	.home-slider .owl-dots {
		position: absolute;
		bottom: 30px;
		left: 50%;
		transform: translateX(-50%);
		z-index: 10;
	}
	.home-slider .owl-dots .owl-dot span {
		width: 12px;
		height: 12px;
		margin: 5px 7px;
		background: rgba(255, 255, 255, 0.5);
		display: block;
		transition: opacity .2s ease;
		border-radius: 30px;
	}
	.home-slider .owl-dots .owl-dot.active span {
		background: #f15d30;
	}
	.ftco-search {
		z-index: 99 !important;
	}
</style>

@if(isset($sliders) && $sliders->count() > 0)
	<div class="home-slider owl-carousel js-fullheight">
		@foreach($sliders as $slider)
			<div class="slider-item">
				<div class="hero-wrap js-fullheight" style="background-image: url({{ asset($slider->image_path) }}); background-position: center center;">
					<div class="overlay"></div>
					<div class="container">
						<div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
							<div class="col-md-7 ftco-animate">
								@if($slider->subtitle)
									<span class="subheading">{{ $slider->subtitle }}</span>
								@endif
								<h1 class="mb-4">{{ $slider->title }}</h1>
								@if($slider->description)
									<p class="caps">{{ $slider->description }}</p>
								@endif
							</div>
							@if($slider->video_url)
								<a href="{{ $slider->video_url }}" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
									<span class="fa fa-play"></span>
								</a>
							@endif
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@else
	<div class="hero-wrap js-fullheight" style="background-image: url({{ asset('images/bg_5.jpg') }});">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
				<div class="col-md-7 ftco-animate">
					<span class="subheading">Welcome to Pacific</span>
					<h1 class="mb-4">Discover Your Favorite Place with Us</h1>
					<p class="caps">Travel to the any corner of the world, without going around in circles</p>
				</div>
				<a href="https://vimeo.com/45830194" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
					<span class="fa fa-play"></span>
				</a>
			</div>
		</div>
	</div>
@endif

	<section class="ftco-section ftco-no-pb ftco-no-pt">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="ftco-search d-flex justify-content-center">
						<div class="row w-100">
							<div class="col-md-12 tab-wrap">
								<div class="tab-content" id="v-pills-tabContent">
									<div class="tab-pane fade show active" role="tabpanel">
										<form action="{{ url('destination') }}" method="GET" class="search-property-1">
											<div class="row no-gutters">
												<div class="col-md d-flex">
													<div class="form-group p-4 border-0">
														<label for="destination_id">Destination</label>
														<div class="form-field">
															<div class="select-wrap">
																<div class="icon"><span class="fa fa-chevron-down"></span></div>
																<select name="destination_id" id="destination_id" class="form-control">
																	<option value="">All Destinations</option>
																	@foreach($destinations as $dest)
																		<option value="{{ $dest->id }}">{{ $dest->name }}</option>
																	@endforeach
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md d-flex">
													<div class="form-group p-4">
														<label for="category_id">Category</label>
														<div class="form-field">
															<div class="select-wrap">
																<div class="icon"><span class="fa fa-chevron-down"></span></div>
																<select name="category_id" id="category_id" class="form-control">
																	<option value="">All Categories</option>
																	@foreach($categories as $cat)
																		<option value="{{ $cat->id }}">{{ $cat->name }}</option>
																	@endforeach
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md d-flex">
													<div class="form-group p-4">
														<label for="price">Price Limit</label>
														<div class="form-field">
															<div class="select-wrap">
																<div class="icon"><span class="fa fa-chevron-down"></span></div>
																<select name="price" id="price" class="form-control">
																	<option value="">No Limit</option>
																	<option value="500">Up to $500</option>
																	<option value="1000">Up to $1,000</option>
																	<option value="2000">Up to $2,000</option>
																	<option value="5000">Up to $5,000</option>
																	<option value="10000">Up to $10,000</option>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md d-flex">
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
					</div>
				</div>
			</div>
		</div>
	</section>

		<section class="ftco-section services-section">
			<div class="container">
				<div class="row d-flex">
					<div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex align-items-center">
						<div class="w-100">
							<span class="subheading">Welcome to Pacific</span>
							<h2 class="mb-4">It's time to start your adventure</h2>
							<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.
							A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
							<p><a href="#" class="btn btn-primary py-3 px-4">Search Destination</a></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
								<div class="services services-1 color-1 d-block img" style="background-image: url({{ asset('images/services-1.jpg') }});">
									<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-paragliding"></span></div>
									<div class="media-body">
										<h3 class="heading mb-3">Activities</h3>
										<p>A small river named Duden flows by their place and supplies it with the necessary</p>
									</div>
								</div>      
							</div>
							<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
								<div class="services services-1 color-2 d-block img" style="background-image: url({{ asset('images/services-2.jpg') }});">
									<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
									<div class="media-body">
										<h3 class="heading mb-3">Travel Arrangements</h3>
										<p>A small river named Duden flows by their place and supplies it with the necessary</p>
									</div>
								</div>    
							</div>
							<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
								<div class="services services-1 color-3 d-block img" style="background-image: url({{ asset('images/services-3.jpg') }});">
									<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-tour-guide"></span></div>
									<div class="media-body">
										<h3 class="heading mb-3">Private Guide</h3>
										<p>A small river named Duden flows by their place and supplies it with the necessary</p>
									</div>
								</div>      
							</div>
							<div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
								<div class="services services-1 color-4 d-block img" style="background-image: url({{ asset('images/services-4.jpg') }});">
									<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-map"></span></div>
									<div class="media-body">
										<h3 class="heading mb-3">Location Manager</h3>
										<p>A small river named Duden flows by their place and supplies it with the necessary</p>
									</div>
								</div>      
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section img ftco-select-destination" style="background-image: url({{ asset('images/bg_3.jpg') }});">
			<div class="container">
				<div class="row justify-content-center pb-4">
					<div class="col-md-12 heading-section text-center ftco-animate">
						<span class="subheading">Pacific Provide Places</span>
						<h2 class="mb-4">Select Your Destination</h2>
					</div>
				</div>
			</div>
			<div class="container container-2">
				<div class="row">
					<div class="col-md-12">
						@if($destinations->count() > 0)
						<div class="carousel-destination owl-carousel ftco-animate">
							@foreach($destinations as $destination)
							<div class="item">
								<div class="project-destination">
									<a href="#" class="img" style="background-image: url('{{ asset($destination->image) }}');">
										<div class="text">
											<h3>{{ $destination->name }}</h3>
											<span>{{ $destination->tours_count }} {{ \Illuminate\Support\Str::plural('Tour', $destination->tours_count) }}</span>
										</div>
									</a>
								</div>
							</div>
							@endforeach
						</div>
						@else
						<div class="text-center py-5" style="background: rgba(255,255,255,0.8); border-radius: 10px;">
							<h4 class="text-muted mb-0" style="font-weight: 500;"><i class="fa-solid fa-map-location-dot"></i> Destinations will be added soon.</h4>
						</div>
						@endif
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center pb-4">
					<div class="col-md-12 heading-section text-center ftco-animate">
						<span class="subheading">Destination</span>
						<h2 class="mb-4">Tour Destination</h2>
					</div>
				</div>
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
						<div class="col-md-12 text-center py-5">
							<h4 class="text-muted">No tours available at the moment.</h4>
						</div>
					@endif
				</div>
			</div>
		</section>
		
		<section class="ftco-section ftco-about img"style="background-image: url({{ asset('images/bg_4.jpg') }});">
			<div class="overlay"></div>
			<div class="container py-md-5">
				<div class="row py-md-5">
					<div class="col-md d-flex align-items-center justify-content-center">
						<a href="https://vimeo.com/45830194" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
							<span class="fa fa-play"></span>
						</a>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section ftco-about ftco-no-pt img">
			<div class="container">
				<div class="row d-flex">
					<div class="col-md-12 about-intro">
						<div class="row">
							<div class="col-md-6 d-flex align-items-stretch">
								<div class="img d-flex w-100 align-items-center justify-content-center" style="background-image:url({{ asset('images/about-1.jpg') }});">
								</div>
							</div>
							<div class="col-md-6 pl-md-5 py-5">
								<div class="row justify-content-start pb-3">
									<div class="col-md-12 heading-section ftco-animate">
										<span class="subheading">About Us</span>
										<h2 class="mb-4">Make Your Tour Memorable and Safe With Us</h2>
										<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
										<p><a href="#" class="btn btn-primary">Book Your Destination</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section testimony-section bg-bottom" style="background-image: url({{ asset('images/bg_1.jpg') }});">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center pb-4">
					<div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
						<span class="subheading">Testimonial</span>
						<h2 class="mb-4">Tourist Feedback</h2>
					</div>
				</div>
				<div class="row ftco-animate">
					<div class="col-md-12">
						@if($testimonials->count() > 0)
						<div class="carousel-testimony owl-carousel">
							@foreach($testimonials as $testimony)
							<div class="item" style="cursor: pointer;" onclick="openTestimonialModal({{ $testimony->id }})">
								<div class="testimony-wrap py-4" style="transition: transform 0.3s; border-radius: 10px;">
									<div class="text">
										<p class="star" style="color: #f15d30;">
											@for($i=1; $i<=5; $i++)
											<span class="fa fa-star {{ $i <= $testimony->rating ? '' : 'text-muted' }}"></span>
											@endfor
										</p>
										<p class="mb-4" style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; height: 96px; text-overflow: ellipsis;">{{ $testimony->review }}</p>
										<div class="d-flex align-items-center">
											<div class="user-img flex-shrink-0" style="background-image: url('{{ $testimony->client_dp ? asset($testimony->client_dp) : 'https://ui-avatars.com/api/?name='.urlencode($testimony->client_name).'&background=random&color=fff' }}'); width: 60px; height: 60px; border-radius: 50%; background-size: cover; background-position: center; margin-right: 15px;"></div>
											<div class="text-content" style="padding-left: 5px;">
												<p class="name" style="margin-bottom: 0;">{{ $testimony->client_name }}</p>
												<span class="position">{{ $testimony->designation }}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
						@else
						<div class="text-center py-5" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
							<h4 class="text-white mb-0" style="font-weight: 500;"><i class="fa-solid fa-comment-slash"></i> Tourist feedback will appear here soon.</h4>
						</div>
						@endif
					</div>
				</div>
			</div>
		</section>


		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center pb-4">
					<div class="col-md-12 heading-section text-center ftco-animate">
						<span class="subheading">Our Blog</span>
						<h2 class="mb-4">Recent Post</h2>
					</div>
				</div>
				<div class="row d-flex">
					@foreach($latestBlogs as $blog)
					<div class="col-md-4 d-flex ftco-animate">
						<div class="blog-entry d-flex flex-column justify-content-end" style="width: 100%;">
							<a href="{{ url('blog-single/' . $blog->slug) }}" class="block-20" style="background-image: url('{{ $blog->images->count() > 0 ? asset($blog->images->first()->image_path) : asset('images/image_1.jpg') }}'); flex-shrink: 0;">
							</a>
							<div class="text d-flex flex-column" style="flex-grow: 1;">
								<div class="d-flex align-items-center mb-4 topp">
									<div class="one">
										<span class="day">{{ $blog->created_at->format('d') }}</span>
									</div>
									<div class="two">
										<span class="yr">{{ $blog->created_at->format('Y') }}</span>
										<span class="mos">{{ $blog->created_at->format('F') }}</span>
									</div>
								</div>
								<h3 class="heading" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 4.2em; line-height: 1.4; text-overflow: ellipsis;"><a href="{{ url('blog-single/' . $blog->slug) }}">{{ $blog->title }}</a></h3>
								<p class="mt-auto mb-0"><a href="{{ url('blog-single/' . $blog->slug) }}" class="btn btn-primary">Read more</a></p>
							</div>
						</div>
					</div>
					@endforeach
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
<!-- Testimonial Modal -->
<div class="modal fade" id="testimonyModal" tabindex="-1" role="dialog" aria-labelledby="testimonyModalLabel" aria-hidden="true" style="z-index: 1050;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
      <div class="modal-header" style="border-bottom: none; padding: 15px 20px 0 20px; z-index: 1;">
        <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 28px; color: #999;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" style="padding: 0 40px 40px 40px; margin-top: -20px;">
        <div class="user-img mx-auto mb-3 shadow-sm" id="testimonyModalImg" style="width: 100px; height: 100px; border-radius: 50%; background-size: cover; background-position: center; border: 4px solid #fff;"></div>
        <h4 class="name mb-1" id="testimonyModalName" style="font-weight: 700; color: #111827; font-size: 22px;"></h4>
        <span class="position d-block mb-3" id="testimonyModalDesig" style="color: #F15A29; font-size: 14px; font-weight: 500;"></span>
        <p class="star mb-4" id="testimonyModalStars" style="font-size: 16px;"></p>
        <div style="position: relative;">
            <i class="fa fa-quote-left" style="color: #f3f4f6; font-size: 40px; position: absolute; top: -15px; left: -10px; z-index: -1;"></i>
            <p class="review-text" id="testimonyModalReview" style="color: #4b5563; line-height: 1.7; font-style: italic; font-size: 16px; margin: 0; position: relative; z-index: 1;"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    const testimonialsData = @json($testimonials);
    function openTestimonialModal(id) {
        const testimony = testimonialsData.find(t => t.id === id);
        if(testimony) {
            document.getElementById('testimonyModalName').textContent = testimony.client_name;
            document.getElementById('testimonyModalDesig').textContent = testimony.designation;
            document.getElementById('testimonyModalReview').textContent = testimony.review;
            
            let imgUrl = testimony.client_dp ? '{{ asset('') }}' + testimony.client_dp : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(testimony.client_name) + '&background=random&color=fff&size=200';
            document.getElementById('testimonyModalImg').style.backgroundImage = "url('" + imgUrl + "')";
            
            let starsHtml = '';
            for(let i=1; i<=5; i++) {
                let colorClass = i <= testimony.rating ? 'color: #f15d30;' : 'color: #d1d5db;';
                starsHtml += `<span class="fa fa-star" style="${colorClass} margin: 0 2px;"></span>`;
            }
            document.getElementById('testimonyModalStars').innerHTML = starsHtml;
            
            // Try BS4 then BS5
            if(typeof $ !== 'undefined' && $.fn.modal) {
                $('#testimonyModal').modal('show');
            } else if (typeof bootstrap !== 'undefined') {
                var myModal = new bootstrap.Modal(document.getElementById('testimonyModal'));
                myModal.show();
            }
        }
    }
</script>
@endsection
