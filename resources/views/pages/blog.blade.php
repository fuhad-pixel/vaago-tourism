@extends('layouts.app')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ asset('images/bg_1.jpg') }});">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
      <div class="col-md-9 ftco-animate pb-5 text-center">
       <p class="breadcrumbs"><span class="me-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span> <span>Blog <i class="fa fa-chevron-right"></i></span></p>
       <h1 class="mb-0 bread">Blog</h1>
     </div>
   </div>
 </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row d-flex">
      @if($blogs->count() > 0)
        @foreach($blogs as $blog)
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
                <h3 class="heading" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 4.2em; line-height: 1.4; text-overflow: ellipsis;">
                  <a href="{{ url('blog-single/' . $blog->slug) }}">{{ $blog->title }}</a>
                </h3>
                <p style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; height: 6em; line-height: 1.5; text-overflow: ellipsis; margin-bottom: 20px;">
                  {{ strip_tags($blog->description) }}
                </p>
                <p class="mt-auto mb-0"><a href="{{ url('blog-single/' . $blog->slug) }}" class="btn btn-primary">Read more</a></p>
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-md-12 text-center py-5">
          <h3 class="text-muted">No blog posts found.</h3>
        </div>
      @endif
    </div>

    @if ($blogs->hasPages())
    <div class="row mt-5">
      <div class="col text-center">
        <div class="block-27">
          <ul>
            {{-- Previous Page Link --}}
            @if ($blogs->onFirstPage())
              <li class="disabled"><span>&lt;</span></li>
            @else
              <li><a href="{{ $blogs->previousPageUrl() }}">&lt;</a></li>
            @endif

            {{-- Pagination Elements --}}
            @for ($i = 1; $i <= $blogs->lastPage(); $i++)
              @if ($i == $blogs->currentPage())
                <li class="active"><span>{{ $i }}</span></li>
              @else
                <li><a href="{{ $blogs->url($i) }}">{{ $i }}</a></li>
              @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($blogs->hasMorePages())
              <li><a href="{{ $blogs->nextPageUrl() }}">&gt;</a></li>
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
