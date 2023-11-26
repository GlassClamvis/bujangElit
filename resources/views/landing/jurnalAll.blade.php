@extends('landing.layout')
@section('content')
    <!--====== BINDUZ HEADER PART ENDS ======-->

    <section class="binduz-er-main-posts-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="binduz-er-video-post-topbar">
                        <div class="binduz-er-top-news-title">
                            <h3 class="binduz-er-title">{{ $data['header'] }}</h3>
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
                                                <h4 class="binduz-er-title">
                                                    <a href="{{ url('jurnal-detail/' . $j->url) }}">
                                                        {{ $j->judul }}
                                                    </a>
                                                </h4>
                                                <p>{{ Illuminate\Support\Str::limit($j->deskripsi, 110) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="binduz-er-blog-details-box">
                                <div class="binduz-er-quote-text">
                                    <p>Data Tidak Ditemukan</p>
                                    <span>By <span>BujangElit</span></span>
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
                <div class="col-lg-3">
                    <div class="binduz-er-sidebar-about">

                        <div class="binduz-er-sidebar-title">
                            <h4 class="binduz-er-title">Pencarian Berita</h4>
                        </div>
                        <div class="binduz-er-video-post">

                        </div>
                        <div class="binduz-er-author-sidebar-search-bar" style="margin-bottom: 50px;">
                            <form action="{{ url('jurnal-find') }}">
                                <div class="binduz-er-input-box">
                                    <input type="text" placeholder="Search from here..." name="question">
                                    <button type="submit"><i class="fal fa-search"></i></button>
                                </div>
                            </form>
                        </div>


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
                                <a class="binduz-er-main-btn" href="#">Connect With Me</a>
                            </div>
                        </div>
                    </div>

                    <div class="binduz-er-sidebar-latest-post">
                        <div class="col-md-12">
                            <div class="binduz-er-sidebar-categories">
                                <div class="binduz-er-sidebar-title">
                                    <h4 class="binduz-er-title">Kategori jurnal</h4>
                                </div>
                                <div class="binduz-er-categories-list">
                                    @foreach ($data['kategori'] as $v)
                                        <div class="binduz-er-item">
                                            <a href="{{ url('jurnal-kategori/' . $v->label) }}">
                                                <span>{{ $v->label }}</span>
                                                <span class="binduz-er-number">{{ $v->jurnal_count }}</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!--====== BINDUZ MAIN POSTS PART ENDS ======-->
@endsection
