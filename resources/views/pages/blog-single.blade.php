@extends('layouts.app')

@section('content')
<section class="hero-wrap hero-wrap-2" style="position: relative; height: 60vh; min-height: 400px; background-image: url('{{ $blog->images->count() > 0 ? asset($blog->images->first()->image_path) : asset('images/bg_1.jpg') }}');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-center" style="height: 60vh; min-height: 400px;">
      <div class="col-md-9 ftco-animate pb-5 text-center">
       <p class="breadcrumbs"><span class="me-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span> <span class="me-2"><a href="{{ url('/') }}">Blog <i class="fa fa-chevron-right"></i></a></span> <span>Blog Single <i class="fa fa-chevron-right"></i></span></p>
       <h1 class="mb-0 bread" style="color: #f15d30 !important;">{{ $blog->title }}</h1>
     </div>
   </div>
 </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb">
  <div class="container">
      <div class="row">
        <div class="col-lg-12 ftco-animate pt-4 pt-md-5 mt-md-5 pb-md-0">
          <h2 class="mb-3">{{ $blog->title }}</h2>
          <div class="blog-content">
            {!! $blog->description !!}
          </div>
          
          @if($blog->images->count() > 1)
            <div class="row mt-4 mb-4">
              @foreach($blog->images->skip(1) as $image)
                <div class="col-md-6 mb-3">
                  <img src="{{ asset($image->image_path) }}" alt="{{ $blog->title }}" class="img-fluid rounded">
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
      
      <!-- Recent Blogs Section Below the Content -->
      <div class="row mt-4">
        <div class="col-md-12">
          <h3 class="mb-4" style="font-weight: 700; color: #111827; border-left: 4px solid #f15d30; padding-left: 12px; font-size: 22px;">Recent Blog Posts</h3>
          <div class="row">
            @foreach($recentBlogs as $recent)
            <div class="col-md-4 d-flex ftco-animate">
              <div class="blog-entry d-flex flex-column justify-content-end" style="width: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-radius: 12px; overflow: hidden; background: #fff; border: 1px solid rgba(0,0,0,0.05); margin-bottom: 30px; transition: transform 0.3s ease;">
                <a href="{{ url('blog-single/' . $recent->slug) }}" class="block-20" style="background-image: url('{{ $recent->images->count() > 0 ? asset($recent->images->first()->image_path) : asset('images/image_1.jpg') }}'); height: 200px; background-size: cover; background-position: center; display: block; flex-shrink: 0;"></a>
                <div class="text p-4 d-flex flex-column" style="flex-grow: 1;">
                  <div class="d-flex align-items-center mb-3" style="font-size: 13px; color: #6b7280; gap: 15px;">
                    <div><span class="fa fa-calendar" style="color: #f15d30; margin-right: 5px;"></span> {{ $recent->created_at->format('M d, Y') }}</div>
                    <div><span class="fa fa-user" style="color: #f15d30; margin-right: 5px;"></span> Admin</div>
                  </div>
                  <h3 class="heading mb-3" style="font-size: 16px; font-weight: 600; line-height: 1.4; height: 2.8em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    <a href="{{ url('blog-single/' . $recent->slug) }}" style="color: #1f2937; text-decoration: none;">{{ $recent->title }}</a>
                  </h3>
                  <p class="mt-auto mb-0"><a href="{{ url('blog-single/' . $recent->slug) }}" class="btn btn-primary px-3 py-2" style="border-radius: 20px; font-size: 13px; font-weight: 600;">Read More</a></p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
  </div>
</section> <!-- .section -->	

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
