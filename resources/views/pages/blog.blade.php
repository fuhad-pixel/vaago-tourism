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
                <h1 class="breadcrumb-title">{{ isset($hero_setting) && $hero_setting->title ? $hero_setting->title : 'Latest News' }}</h1>
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
                  <li>Our Blog</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Blog List Area Start =================-->
      <section class="vs-blog-wrapper space">
        <div class="container">
          <div class="row gx-3 g-5">
            <!-- Blog Posts -->
            <div class="col-lg-8">
              <div class="row g-4 gy-4 gy-sm-5">
                @if($blogs->count() > 0)
                  @foreach($blogs as $blog)
                    <div class="col-12">
                      <div class="vs-blog vs-blog-box3">
                        <div class="blog-img">
                          <a href="{{ url('blog-single/' . $blog->slug) }}">
                            <img
                              class="img w-100"
                              src="{{ $blog->images->count() > 0 ? asset($blog->images->first()->image_path) : asset('assets/img/blog/blog-3-1.png') }}"
                              alt="{{ $blog->title }}"
                              style="height: 380px; object-fit: cover;"
                            />
                          </a>
                        </div>
                        <div class="blog-content">
                          <div class="blog-meta">
                            <span class="blog-author">Written by: <a href="javascript:void(0)">Admin</a></span>
                            <span class="blog-date">
                              <i class="fa-regular fa-calendar-days"></i>
                              {{ $blog->created_at->format('F d, Y') }}
                            </span>
                          </div>
                          <h3 class="blog-title">
                            <a href="{{ url('blog-single/' . $blog->slug) }}">
                              {{ $blog->title }}
                            </a>
                          </h3>
                          <p class="blog-text">
                            {{ Str::limit(strip_tags($blog->description), 220) }}
                          </p>
                          <div class="blog-footer">
                            <a href="{{ url('blog-single/' . $blog->slug) }}" class="blog-link">
                              read more
                              <i class="fa-sharp fa-regular fa-angles-right"></i>
                            </a>
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
                  @endforeach
                @else
                  <div class="col-12 text-center py-5">
                    <h3 class="text-muted">No blog posts found.</h3>
                  </div>
                @endif
              </div>

              <!-- Laravel Pagination -->
              @if ($blogs->hasPages())
                <div class="row">
                  <div class="col-12 d-flex justify-content-center mt-5">
                    <div class="vs-pagination">
                      <ul>
                        {{-- Previous Page Link --}}
                        @if ($blogs->onFirstPage())
                          <li class="disabled"><span><i class="fa-solid fa-angles-left"></i></span></li>
                        @else
                          <li><a href="{{ $blogs->previousPageUrl() }}"><i class="fa-solid fa-angles-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @for ($i = 1; $i <= $blogs->lastPage(); $i++)
                          @if ($i == $blogs->currentPage())
                            <li><span class="active">{{ $i }}</span></li>
                          @else
                            <li><a href="{{ $blogs->url($i) }}">{{ $i }}</a></li>
                          @endif
                        @endfor

                        {{-- Next Page Link --}}
                        @if ($blogs->hasMorePages())
                          <li><a href="{{ $blogs->nextPageUrl() }}"><i class="fa-solid fa-angles-right"></i></a></li>
                        @else
                          <li class="disabled"><span><i class="fa-solid fa-angles-right"></i></span></li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>
              @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
              <div class="sidebar-area">
                <!-- Search Widget -->
                <div class="widget widget_search">
                  <h5 class="widget_title title-shep">Search</h5>
                  <form class="search-form" action="{{ url('blog') }}" method="GET">
                    <input type="text" name="search" placeholder="Search here..." value="{{ request('search') }}" />
                    <button type="submit"><i class="far fa-search"></i></button>
                  </form>
                </div>

                <!-- Recent Posts Widget -->
                @php
                  $recentBlogs = \App\Models\Blog::with('images')->latest()->take(3)->get();
                @endphp
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
      <!--================= Blog List Area End =================-->
@endsection
