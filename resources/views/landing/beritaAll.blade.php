@extends('landing.layout')
@section('content')
    <section class="binduz-er-trending-area">
        <div class=" container">
            <div class="row">
                <div class=" col-lg-9">
                    <div class="binduz-er-top-news-title">
                        <h3 class="binduz-er-title">Latest News</h3>
                    </div>
                    @forelse ($news as $n)
                        <div class="binduz-er-latest-news-item">
                            <div class="binduz-er-thumb">
                                <img src="{{ asset('assets/data/cover/' . $n->cover) }}" alt=""
                                    style="object-fit: cover; width:240px; height:150px;">
                            </div>
                            <div class="binduz-er-content">
                                <div class="binduz-er-meta-categories">
                                    <a href="#">{{ @$n->kategoriData->label }} </a>
                                </div>
                                <h5 class="binduz-er-title"><a href="{{ url('news/' . $n->url) }}">{{ $n->judul }} </a>
                                </h5>
                                <div class="binduz-er-meta-item">
                                    <div class="binduz-er-meta-author">
                                        <span>Oleh <span>{{ $n->user->name }} </span></span>
                                    </div>
                                    <div class="binduz-er-meta-date">
                                        <span><i class="fal fa-calendar-alt"></i>{{ $n->createdDate }} </span>
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
                    {!! $news->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
                <div class=" col-lg-3">
                    <div class="binduz-er-top-news-title">
                        <h4 class="binduz-er-title">Pencarian Berita</h4>
                    </div>

                    <div class="binduz-er-author-sidebar-search-bar" style="margin-bottom: 33px;">
                        <form action="{{ url('news-find') }}">
                            <div class="binduz-er-input-box">
                                <input type="text" placeholder="Search from here..." name="question">
                                <button type="submit"><i class="fal fa-search"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="binduz-er-sidebar-categories">
                        <div class="binduz-er-sidebar-title">
                            <h4 class="binduz-er-title">Kategori Berita</h4>
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
@endsection
