@extends('landing.layout')
@section('content')
    <style>
        @media print {

            /* Hide elements when printing */
            .no-print {
                display: none !important;
            }
        }
    </style>
    <div class="binduz-er-breadcrumb-area">
        <div class=" container">
            <div class="row">
                <div class=" col-lg-12">
                    <div class="binduz-er-breadcrumb-box">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Buku</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Buku Details</li>
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
                        <div class="binduz-er-content">

                            <div class="row">
                                <div class="col-5">
                                    <div class="binduz-er-thumb">
                                        <img src="{{ asset('assets/data/cover/' . $buku->cover) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <h4 class="binduz-er-title">{{ $buku->judul }} </h4>
                                    <div class="binduz-er-meta-item">
                                        <div class="binduz-er-meta-categories">
                                            <a href="#">{{ $buku->kategori->label }}</a>
                                        </div>
                                        <div class="binduz-er-meta-date">
                                            <span><i class="fal fa-calendar-alt"></i>{{ $buku->createdDate }} </span>
                                        </div>
                                        <div class="binduz-er-meta-date" style="margin-left: 25px;">
                                            <span><i class="fal fa-eye"></i>{{ $buku->viewer }} </span>
                                        </div>
                                    </div>
                                    <div class="binduz-er-author-box">
                                        <div class="binduz-er-content" style="padding:0px;">
                                            <div class="binduz-er-text">
                                                {!! $buku->deskripsi !!}
                                            </div>
                                            @if (isset($buku->pengarangData[0]->nama))
                                                <div class="binduz-er-meta-author">
                                                    <span>{{ @$buku->pengarangData[0]->nama }} <span>-
                                                            Pengarang</span></span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="binduz-er-author-contact d-flex align-content-center">
                                            <ul>
                                                <li>
                                                    @if (auth()->check() &&
                                                            auth()->user()->bookmark->contains('media_id', $buku->id))
                                                        <a href="#" id="icon-download" data-val="1"
                                                            data-id="{{ encrypt($buku->id) }}">
                                                            <i class="fa fa-regular fa-heart" style="color:deeppink;"></i>
                                                        </a>
                                                    @else
                                                        <a href="#" id="icon-download" data-val="0"
                                                            data-id="{{ encrypt($buku->id) }}">
                                                            <i class="fa fa-regular fa-heart"></i>
                                                        </a>
                                                    @endif
                                                </li>
                                                <li><a href="#"><i class="fa fa-download">
                                                        </i></a></li>
                                                <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="binduz-er-blog-details-box">
                            @isset($buku->file_media)
                                <div class="container">
                                    <iframe id="bukuFrame" src="{{ route('pdf.view', ['filename' => $buku->file_media]) }}"
                                        sandbox="allow-same-origin allow-scripts" width="100%"height="500px">
                                    </iframe>
                                </div>
                            @endisset


                            {{-- Place Prev Next Here --}}
                            <div class="binduz-er-blog-related-post">
                                <div class="binduz-er-related-post-title">
                                    <h3 class="binduz-er-title">Related Post</h3>
                                </div>
                                <div class="binduz-er-blog-related-post-slide">
                                    @foreach ($data['related'] as $r)
                                        <div class="binduz-er-video-post binduz-er-recently-viewed-item">
                                            <div class="binduz-er-latest-news-item">
                                                <div class="binduz-er-thumb">
                                                    <img src="{{ asset('assets/data/cover/' . $r->cover) }}" alt=""
                                                        width="286px" height="190px">
                                                </div>
                                                <div class="binduz-er-content">
                                                    <div class="binduz-er-meta-item">
                                                        <div class="binduz-er-meta-categories">
                                                            <a href="#">{{ $r->kategori->label }} </a>
                                                        </div>
                                                        <div class="binduz-er-meta-date">
                                                            <span>
                                                                <i class="fal fa-calendar-alt"></i>
                                                                {{ $r->createdDate }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <h5 class="binduz-er-title">
                                                        <a href="#">
                                                            {{ $r->judul }}
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            {{-- Comment Place here --}}
                        </div>
                    </div>
                </div>
                <div class=" col-lg-3">
                    <div class="binduz-er-populer-news-sidebar">
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
                                                    <img src="{{ asset('assets/data/cover/' . $t->cover) }}"
                                                        alt="" width="160px" height="160px"
                                                        style="object-fit: cover;">

                                                </div>
                                                <div class="binduz-er-content">
                                                    <span>
                                                        <i class="fal fa-calendar-alt"></i>
                                                        {{ $t->createdDate }}
                                                    </span>
                                                    <h4 class="binduz-er-title">
                                                        @if ($t->jenis_media_id == 1)
                                                            <a href="{{ url('buku-detail/' . $t->url) }}">
                                                                {{ Illuminate\Support\Str::limit($t->judul, 55) }}
                                                            </a>
                                                        @elseif ($t->jenis_media_id == 2)
                                                            <a href="{{ url('jurnal-detail/' . $t->url) }}">
                                                                {{ Illuminate\Support\Str::limit($t->judul, 55) }}
                                                            </a>
                                                        @endif
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
    <script src="{{ asset('assets/js/pages/landing.js') }}"></script>

    <script>
        if ($('#bukuFrame').length) {
            var iframe = document.getElementById('bukuFrame');
            iframe.contentWindow.document.oncontextmenu = function() {
                return false;
            };
        }
        var bookmark = "{{ url('bookmarkUpdate') }}";
        var csrf = "{{ csrf_token() }}";
        initBukuDetail();
    </script>
@endsection
