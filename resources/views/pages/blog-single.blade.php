@extends('layouts.app')

@section('content')
<style>
    .blog-rich-content p {
        margin-bottom: 20px;
        line-height: 1.8;
        color: #535b5f;
        font-size: 15px;
    }
    .blog-rich-content h2, .blog-rich-content h3, .blog-rich-content h4 {
        color: #141414;
        font-weight: 700;
        margin-top: 30px;
        margin-bottom: 15px;
    }
</style>

      <!--================= Breadcrumb Area start =================-->
      <section
        class="vs-breadcrumb"
        data-bg-src="{{ $blog->images->count() > 0 ? asset($blog->images->first()->image_path) : asset('assets/img/bg/breadcrumb-bg.png') }}"
        style="background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;"
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
                <h1 class="breadcrumb-title">News Details</h1>
              </div>
              <div class="breadcrumb-menu">
                <ul class="custom-ul">
                  <li>
                    <a href="{{ url('/') }}">Home</a>
                  </li>
                  <li>
                    <a href="{{ url('/blog') }}">Our Blog</a>
                  </li>
                  <li>News Details</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Blog Single Details Area Start =================-->
      <section class="space">
        <div class="container">
          <div class="row gx-3 g-4 gx-xl-5">
            <!-- Left Column: Blog Content -->
            <div class="col-lg-8">
              <div class="vs-blog vs-blog-box3 blog-single">
                <div class="blog-img rounded-bottom-0">
                  <img
                    class="img w-100"
                    src="{{ $blog->images->count() > 0 ? asset($blog->images->first()->image_path) : asset('assets/img/blog/blog-big-1-1.png') }}"
                    alt="{{ $blog->title }}"
                    style="max-height: 480px; object-fit: cover;"
                  />
                </div>
                <div class="blog-content">
                  <div class="blog-meta">
                    <span class="blog-author">Written by: <a href="javascript:void(0)">Admin</a></span>
                    <span class="blog-date">
                      <i class="fa-regular fa-calendar-days"></i>
                      {{ $blog->created_at->format('F d, Y') }}
                    </span>
                  </div>
                  <h2 class="blog-title" style="font-size: 28px; line-height: 1.3; margin-bottom: 20px; font-weight: 700;">
                    {{ $blog->title }}
                  </h2>
                  <div class="blog-rich-content">
                    {!! $blog->description !!}
                  </div>

                  <!-- Blog Additional Gallery -->
                  @if($blog->images->count() > 1)
                    <div class="row pt-30">
                      @foreach($blog->images->skip(1) as $image)
                        <div class="col-sm-6 mb-30">
                          <div class="blog-img rounded-15 overflow-hidden">
                            <img
                              class="img w-100"
                              src="{{ asset($image->image_path) }}"
                              alt="{{ $blog->title }}"
                              style="height: 240px; object-fit: cover;"
                            />
                          </div>
                        </div>
                      @endforeach
                    </div>
                  @endif

                  <div class="blog-footer flex-wrap">
                    <div class="block-tag-cloud">
                      <span class="title">Tags:</span>
                      <a href="javascript:void(0)" class="tag-cloud-link">Adventure,</a>
                      <a href="javascript:void(0)" class="tag-cloud-link">Hiking,</a>
                      <a href="javascript:void(0)" class="tag-cloud-link">Trekking</a>
                    </div>
                    <div class="share-box">
                      <span>
                        share
                        <i class="fa-solid fa-share-nodes"></i>
                      </span>
                      <ul class="custom-ul">
                        <li>
                          <a href="https://www.facebook.com/" target="_blank">
                            <i class="fa-brands fa-facebook-f"></i>
                          </a>
                        </li>
                        <li>
                          <a href="https://x.com/" target="_blank">
                            <i class="fa-brands fa-x-twitter"></i>
                          </a>
                        </li>
                        <li>
                          <a href="https://www.instagram.com/" target="_blank">
                            <i class="fa-brands fa-instagram"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="col-lg-4">
              <div class="sidebar-area">
                <!-- Search Widget -->
                <div class="widget widget_search">
                  <h5 class="widget_title title-shep">Search</h5>
                  <form class="search-form" action="{{ url('blog') }}" method="GET">
                    <input type="text" name="search" placeholder="Search here..." />
                    <button type="submit"><i class="far fa-search"></i></button>
                  </form>
                </div>

                <!-- Recent Posts Widget -->
                @if($recentBlogs->count() > 0)
                  <div class="widget widget_recent-posts">
                    <h5 class="widget_title title-shep">Recent Posts</h5>
                    <div class="recent-post-wrap">
                      @foreach($recentBlogs as $recent)
                        <div class="recent-post">
                          <div class="media-img">
                            <a href="{{ url('blog-single/' . $recent->slug) }}">
                              <img
                                src="{{ $recent->images->count() > 0 ? asset($recent->images->first()->image_path) : asset('assets/img/blog/recent-post-1-1.png') }}"
                                alt="Blog Image"
                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;"
                              />
                            </a>
                          </div>
                          <div class="media-body">
                            <div class="recent-post-meta">
                              <a href="javascript:void(0)">
                                <i class="fa-solid fa-calendar"></i>
                                {{ $recent->created_at->format('M d, Y') }}
                              </a>
                            </div>
                            <h6 class="post-title">
                              <a class="text-inherit" href="{{ url('blog-single/' . $recent->slug) }}">
                                {{ $recent->title }}
                              </a>
                            </h6>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                @endif

                <!-- Categories Widget -->
                @php
                  $categories = \App\Models\Category::withCount('tours')->orderBy('name')->get();
                @endphp
                @if($categories->count() > 0)
                  <div class="widget widget_categories">
                    <h5 class="widget_title title-shep">Categories</h5>
                    <ul class="custom-ul">
                      @foreach($categories as $cat)
                        <li>
                          <a href="{{ url('destination?category_id=' . $cat->id) }}">{{ $cat->name }}</a>
                          <span>{{ $cat->tours_count }}</span>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <!-- Follow widget -->
                <div class="widget">
                  <h5 class="widget_title title-shep">Follow Us</h5>
                  <div class="sidebar-social">
                    <ul class="custom-ul">
                      @if(isset($company_setting) && $company_setting->facebook)
                        <li>
                          <a href="{{ $company_setting->facebook }}" target="_blank" class="social-icon-btn" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                          </a>
                        </li>
                      @endif
                      @if(isset($company_setting) && $company_setting->twitter)
                        <li>
                          <a href="{{ $company_setting->twitter }}" target="_blank" class="social-icon-btn" title="Twitter/X">
                            <i class="fa-brands fa-x-twitter"></i>
                          </a>
                        </li>
                      @endif
                      @if(isset($company_setting) && $company_setting->instagram)
                        <li>
                          <a href="{{ $company_setting->instagram }}" target="_blank" class="social-icon-btn" title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                          </a>
                        </li>
                      @endif
                      @if(isset($company_setting) && $company_setting->linkedin)
                        <li>
                          <a href="{{ $company_setting->linkedin }}" target="_blank" class="social-icon-btn" title="LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
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
      </section>
      <!--================= Blog Single Details Area End =================-->
@endsection
