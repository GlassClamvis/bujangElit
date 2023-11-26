@extends('landing.layout')
@section('content')
    <section class="binduz-er-trending-area">
        <div class=" container">
            <div class="row">
                <div class=" col-lg-9">
                    <div class="binduz-er-top-news-title">
                        <h3 class="binduz-er-title">Bookmark Buku dan Jurnal</h3>
                    </div>
                    @forelse ($media as $m)
                        <div class="binduz-er-latest-news-item">
                            <div class="binduz-er-thumb">
                                <img src="{{ asset('assets/data/cover/' . $m->media->cover) }}" alt=""
                                    style="object-fit: cover; width:240px; height:150px;">
                            </div>
                            <div class="binduz-er-content">
                                <div class="binduz-er-meta-categories">
                                    <a href="#">{{ $m->media->kategori->label }} </a>
                                </div>

                                <h5 class="binduz-er-title">
                                    @if ($m->media->jenis_media_id == 1)
                                        <a href="{{ url('buku-detail/' . $m->media->url) }}">
                                            {{ Illuminate\Support\Str::limit($m->media->judul, 55) }}
                                        </a>
                                    @elseif ($m->media->jenis_media_id == 2)
                                        <a href="{{ url('jurnal-detail/' . $m->media->url) }}">
                                            {{ Illuminate\Support\Str::limit($m->media->judul, 55) }}
                                        </a>
                                    @endif
                                </h5>
                                <div class="binduz-er-meta-item">
                                    @if (isset($m->media->pengarangData[0]->nama))
                                        <div class="binduz-er-meta-author">
                                            <span>Pengarang <span>{{ @$m->media->pengarangData[0]->nama }} </span></span>
                                        </div>
                                    @endif
                                    @if (isset($m->media->tahunTerbitMedia))
                                        <div class="binduz-er-meta-date">
                                            <span><i class="fal fa-calendar-alt"></i>{{ @$m->media->tahunTerbitMedia }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="binduz-er-author-box">
                                    <div class="binduz-er-author-contact d-flex align-content-center">
                                        <ul>
                                            <li>
                                                @if (auth()->check() &&
                                                        auth()->user()->bookmark->contains('media_id', $m->media->id))
                                                    <a href="#" id="icon-download" data-val="1"
                                                        data-id="{{ encrypt($m->media->id) }}">
                                                        <i class="fa fa-regular fa-heart" style="color:deeppink;"></i>
                                                    </a>
                                                @else
                                                    <a href="#" id="icon-download" data-val="0"
                                                        data-id="{{ encrypt($m->media->id) }}">
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
                    @empty
                        <div class="binduz-er-blog-details-box">
                            <div class="binduz-er-quote-text">
                                <p>Data Tidak Ditemukan</p>
                                <span>By <span>BujangElit</span></span>
                            </div>
                        </div>
                    @endforelse
                    {!! $media->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
                <div class=" col-lg-3">
                    <div class="binduz-er-top-news-title">
                        <h4 class="binduz-er-title">Pencarian Bookmark</h4>
                    </div>

                    <div class="binduz-er-author-sidebar-search-bar" style="margin-bottom: 33px;">
                        <form action="{{ url('bookmark-find') }}">
                            <div class="binduz-er-input-box">
                                <input type="text" placeholder="Search from here..." name="question">
                                <button type="submit"><i class="fal fa-search"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="binduz-er-sidebar-categories">
                        <div class="binduz-er-sidebar-title">
                            <h4 class="binduz-er-title">Kategori Bookmark</h4>
                        </div>
                        <div class="binduz-er-categories-list">
                            @foreach ($data['kategori'] as $v)
                                <div class="binduz-er-item">
                                    <a href="#">
                                        <span>{{ $v->label }}</span>
                                        <span class="binduz-er-number">{{ $v->berita_count }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/js/pages/landing.js') }}"></script>
    <script>
        var bookmark = "{{ url('bookmarkUpdate') }}";
        var csrf = "{{ csrf_token() }}";
        initBookmark();
    </script>
@endsection
