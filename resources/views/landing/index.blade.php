@extends('landing.layout')
@section('content')
    <!--====== BINDUZ HEADER PART ENDS ======-->

    <!--====== BINDUZ TRENDING PART START ======-->

    <section class="binduz-er-trending-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="binduz-er-trending-news-topbar d-block d-md-flex justify-content-between align-items-center">
                        <div class="binduz-er-trending-box">
                            <div class="binduz-er-title">
                                <h3 class="binduz-er-title">Berita Terbaru</h3>
                            </div>
                        </div>

                        <div class="binduz-er-news-tab-btn d-flex justify-content-md-end justify-content-start">
                            <ul class="nav nav-pills " id="pills-tab" role="tablist">

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="binduz-er-trending-news-list">
                                <div class="tab-content mt-50" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-1" role="tabpanel"
                                        aria-labelledby="pills-1-tab">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-6">
                                                <div class="binduz-er-trending-box">
                                                    @if (count($highlightNew))
                                                        <div class="binduz-er-trending-news-item">
                                                            <img src="{{ asset('assets/data/cover/' . $highlightNew[0]->cover) }}"
                                                                width="553px" height="450px" alt="">
                                                            <div class="binduz-er-trending-news-overlay">
                                                                <div class="binduz-er-trending-news-meta">
                                                                    <div class="binduz-er-meta-categories">
                                                                        <a href="#">
                                                                            {{ $highlightNew[0]->kategoriData->label }}
                                                                        </a>
                                                                    </div>
                                                                    <div class="binduz-er-meta-date">
                                                                        <span>
                                                                            <i class="fal fa-calendar-alt"></i>
                                                                            {{ $highlightNew[0]->CreatedDate }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="binduz-er-trending-news-title">
                                                                        <h3 class="binduz-er-title">
                                                                            <a
                                                                                href="{{ url('news/' . $highlightNew[0]->url) }}">
                                                                                {{ $highlightNew[0]->judul }}
                                                                            </a>
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                                <div class="binduz-er-news-share">
                                                                    <a href="#"><i class="fal fa-share"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-6">
                                                <div class="binduz-er-trending-news-list-item">

                                                    @forelse ($highlightNews as $v)
                                                        <div class="binduz-er-trending-news-list-box">
                                                            <div class="binduz-er-thumb">
                                                                <img src="{{ asset('assets/data/cover/' . $v->cover) }}"
                                                                    alt="" width="116px" height="110px">
                                                            </div>
                                                            <div class="binduz-er-content">
                                                                <div class="binduz-er-meta-item">
                                                                    <div class="binduz-er-meta-categories">
                                                                        <a href="#">{{ $v->kategoriData->label }}</a>
                                                                    </div>
                                                                    <div class="binduz-er-meta-date">
                                                                        <span>
                                                                            <i class="fal fa-calendar-alt"></i>
                                                                            {{ $v->createdDate }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="binduz-er-trending-news-list-title">
                                                                    <h4 class="binduz-er-title">
                                                                        <a href="{{ url('news/' . $v->url) }}">
                                                                            {{ $v->judul }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-3 col-md-12">
                    <div class="binduz-er-sidebar-categories">
                        <div class="binduz-er-sidebar-title">
                            <h4 class="binduz-er-title">Kategori Berita</h4>
                        </div>
                        <div class="binduz-er-categories-list">
                            @forelse ($data['kategori'] as $v)
                                <div class="binduz-er-item">
                                    <a href="#">
                                        <span>{{ $v->label }}</span>
                                        <span class="binduz-er-number">{{ $v->berita_count }}</span>
                                    </a>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--====== BINDUZ TRENDING PART ENDS ======-->

    <!--====== BINDUZ TRENDING TODAY PART START ======-->

    <section class="binduz-er-trending-today-area">
        <div class="binduz-er-bg-cover"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="binduz-er-trending-today-topbar">
                        <div class="binduz-er-trending-today-title">
                            <h3 class="binduz-er-title">Buku Terbaru</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($books as $b)
                    <div class="col-lg-3 col-md-6">
                        <div class="binduz-er-trending-today-item">
                            <div class="binduz-er-trending-news-list-box">
                                <div class="binduz-er-thumb">
                                    <img src="{{ asset('assets/data/cover/' . $b->cover) }}" alt="" width="230px"
                                        height="200px">
                                </div>
                                <div class="binduz-er-content">
                                    <div class="binduz-er-meta-item">
                                        <div class="binduz-er-meta-categories">
                                            <a href="#">{{ $b->kategori->label }}</a>
                                        </div>
                                        <div class="binduz-er-meta-date">
                                            <span><i class="fal fa-calendar-alt"></i>
                                                {{ $b->createdDate }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="binduz-er-trending-news-list-title">
                                        <h4 class="binduz-er-title"><a href="{{ url('buku-detail/' . $b->url) }}">
                                                {{ $b->judul }}</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>

    <!--====== BINDUZ TRENDING TODAY PART ENDS ======-->

    <!--====== BINDUZ MAIN POSTS PART START ======-->

    <section class="binduz-er-main-posts-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="binduz-er-video-post-topbar">
                        <div class="binduz-er-video-post-title">
                            <h3 class="binduz-er-title">Jurnal Posts</h3>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($jurnal as $j)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="binduz-er-main-posts-item">
                                    <div class="binduz-er-trending-news-list-box">
                                        <div class="binduz-er-thumb">
                                            <img src="{{ asset('assets/data/cover/' . $j->cover) }}" alt=""
                                                width="321px" height="200px">
                                        </div>
                                        <div class="binduz-er-content">
                                            <div class="binduz-er-meta-item">
                                                <div class="binduz-er-meta-categories">
                                                    <a href="#">{{ @$j->kategori->label }}</a>
                                                </div>
                                                <div class="binduz-er-meta-date">
                                                    <span><i class="fal fa-calendar-alt"></i>
                                                        {{ $j->createdDate }}</span>
                                                </div>
                                            </div>
                                            <div class="binduz-er-trending-news-list-title">
                                                <h4 class="binduz-er-title"><a
                                                        href="{{ url('jurnal-detail/' . $j->url) }}">
                                                        {{ $j->judul }}
                                                    </a></h4>
                                                <p>{{ Illuminate\Support\Str::limit($j->deskripsi, 110) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="binduz-er-add pt-10">
                        {{-- <img src="landingAssets/images/space-thumb.jpg" alt=""> --}}
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="binduz-er-sidebar-about">
                        <div class="binduz-er-sidebar-title">
                            <h4 class="binduz-er-title">About Me</h4>
                        </div>
                        <div class="binduz-er-sidebar-about-item">
                            <div class="binduz-er-sidebar-about-user d-flex">
                                <div class="binduz-er-thumb">
                                    <img src="landingAssets/images/user.jpg" alt="">
                                </div>
                                <div class="binduz-er-content">
                                    <h4 class="binduz-er-title">Bujang Elit</h4>
                                    <span>Author</span>
                                    <ul>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="binduz-er-text">
                                <p>The functional aspect comes first in the work process because it’s the core of the
                                    object: What is its purpose? something else?</p>
                                {{-- <a class="binduz-er-main-btn" href="#">Connect With Me</a> --}}
                            </div>
                        </div>
                    </div>
                    {{--  <div class="binduz-er-sidebar-latest-post">
                        <div class="binduz-er-sidebar-title">
                            <h4 class="binduz-er-title">Latest Post</h4>
                        </div>
                        <div class="binduz-er-sidebar-latest-post-box">
                            <div class="binduz-er-sidebar-latest-post-item">
                                <div class="binduz-er-thumb">
                                    <img src="landingAssets/images/latest-post-1.jpg" alt="latest">
                                </div>
                                <div class="binduz-er-content">
                                    <span><i class="fal fa-calendar-alt"></i> 24th February 2020</span>
                                    <h4 class="binduz-er-title"><a href="#">Time flies in Google Earth’s
                                            biggest update in</a></h4>
                                </div>
                            </div>
                            <div class="binduz-er-sidebar-latest-post-item">
                                <div class="binduz-er-thumb">
                                    <img src="landingAssets/images/latest-post-2.jpg" alt="latest">
                                </div>
                                <div class="binduz-er-content">
                                    <span><i class="fal fa-calendar-alt"></i> 24th February 2020</span>
                                    <h4 class="binduz-er-title"><a href="#">3 ways to find and support
                                            eco-friendly </a></h4>
                                </div>
                            </div>
                            <div class="binduz-er-sidebar-latest-post-item">
                                <div class="binduz-er-thumb">
                                    <img src="landingAssets/images/latest-post-3.jpg" alt="latest">
                                </div>
                                <div class="binduz-er-content">
                                    <span><i class="fal fa-calendar-alt"></i> 24th February 2020</span>
                                    <h4 class="binduz-er-title"><a href="#">How we’re minimizing AI’s carbon
                                            footprint</a></h4>
                                </div>
                            </div>
                            <div class="binduz-er-sidebar-latest-post-item">
                                <div class="binduz-er-thumb">
                                    <img src="landingAssets/images/latest-post-4.jpg" alt="latest">
                                </div>
                                <div class="binduz-er-content">
                                    <span><i class="fal fa-calendar-alt"></i> 24th February 2020</span>
                                    <h4 class="binduz-er-title"><a href="#">Your Chromebook gets a little more
                                            helpful</a></h4>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <!--====== BINDUZ MAIN POSTS PART ENDS ======-->
@endsection
