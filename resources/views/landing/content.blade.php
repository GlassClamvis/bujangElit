@extends('landing.layout')
@section('content')
    <div class="binduz-er-breadcrumb-area">

        <div class=" container">
            <div class="row">
                <div class=" col-lg-12">
                    <div class="binduz-er-breadcrumb-box">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">{{ $data['getMenuDetail']->Menu->title }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $data['getMenuDetail']->title }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--====== BINDUZ HEADER PART ENDS ======-->
    <section class="binduz-er-author-item-area pb-20">
        <div class=" container">
            <div class="row">
                <div class=" col-lg-9">
                    <div class="binduz-er-author-item mb-40">
                        <div class="binduz-er-thumb">
                            {{--  <img src="https://fakeimg.pl/1004x517/cccccc/0f0e0e?text=BujangElit&font=robot"
                                alt=""> --}}
                            {{--  <img src="{{ asset('assets/data/cover/' . @$content->cover) }}"
                                style="height:517px; width:1004px;"> --}}
                        </div>
                        {{--   <div class="binduz-er-content">
                            <div class="binduz-er-meta-item">

                                <div class="binduz-er-meta-date">
                                    <span><i class="fal fa-calendar-alt"></i>{{ $content->createdDate }} </span>
                                </div>
                            </div>
                            <h3 class="binduz-er-title">{{ @$content->judul }} </h3>
                            <div class="binduz-er-meta-author">
                                <div class="binduz-er-author">
                                    <img src="assets/images/user-2.jpg" alt="">
                                    <span>Oleh <span>{{ @$content->user->name }} </span></span>
                                </div>
                                <div class="binduz-er-meta-list">
                                    <ul>
                                        <li><i class="fal fa-eye"></i> {{ @$content->viewer }} </li>
                                        <li><i class="fal fa-hourglass"></i> {{ @$content->read_time }} Menit</li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                        <div class="binduz-er-blog-details-box">
                            <div class="binduz-er-text">
                                {!! @$content->content !!}
                            </div>


                            {{-- <div
                                class="binduz-er-social-share-tag d-block d-sm-flex justify-content-between align-items-center">
                                <div class="binduz-er-tag">
                                    <ul>
                                        <li><a href="#">Popular</a></li>
                                        <li><a href="#">Desgin</a></li>
                                        <li><a href="#">UX</a></li>
                                    </ul>
                                </div>
                                <div class="binduz-er-social">
                                    <ul>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-typo3"></i></a></li>
                                        <li><a href="#"><i class="fab fa-staylinked"></i></a></li>
                                        <li><a href="#"><i class="fab fa-tumblr"></i></a></li>
                                    </ul>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
                <div class=" col-lg-3">
                    <div class="binduz-er-populer-news-sidebar">
                        {{--     
                        <div class="binduz-er-archived-sidebar-about" style="background: #fff;">
                            <div class="binduz-er-user">
                                <img src="{{ asset($data['imgUser']) }}" alt="" style="width:140px; height:140px;">
                                <div class="binduz-er-icon">
                                    <i class="fal fa-newspaper"></i>
                                </div>

                            </div>
                            <span>Reporter</span>
                            <h4 class="binduz-er-title">{{ @$content->user->name }}</h4>
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
 --}}

                        <div class="binduz-er-populer-news-sidebar-post pt-40">
                            <div class="binduz-er-popular-news-title">
                                <ul class="nav nav-pills mb-3" id="pills-tab-2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            href="#pills-home" role="tab" aria-controls="pills-home"
                                            aria-selected="true">Most Popular</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent-2">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <div class="binduz-er-sidebar-latest-post-box">

                                        @foreach ($data['topnews'] as $t)
                                            <div class="binduz-er-sidebar-latest-post-item">
                                                <div class="binduz-er-thumb">
                                                    <img src="{{ asset('assets/data/cover/' . $t->cover) }}" alt=""
                                                        width="160px" height="160px" style="object-fit: cover;">

                                                </div>
                                                <div class="binduz-er-content">
                                                    <span>
                                                        <i class="fal fa-calendar-alt"></i>
                                                        {{ $t->createdDate }}
                                                    </span>
                                                    <h4 class="binduz-er-title">
                                                        <a href="{{ url('news/' . $t->url) }}">
                                                            {{ Illuminate\Support\Str::limit($t->judul, 55) }}
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
