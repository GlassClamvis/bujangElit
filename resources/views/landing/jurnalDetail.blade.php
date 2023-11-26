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
                                <li class="breadcrumb-item"><a href="#">Jurnal</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Jurnal Details</li>
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
                            <div class="binduz-er-meta-item">
                                <div class="binduz-er-meta-categories">
                                    <a href="#">{{ $jurnal->kategori->label }}</a>
                                </div>
                                <div class="binduz-er-meta-date">
                                    <span><i class="fal fa-calendar-alt"></i>{{ $jurnal->createdDate }} </span>
                                </div>
                                <div class="binduz-er-meta-date" style="margin-left: 25px;">
                                    <span><i class="fal fa-eye"></i>{{ $jurnal->viewer }} </span>
                                </div>
                            </div>
                            <h3 class="binduz-er-title">{{ $jurnal->judul }} </h3>
                        </div>
                        <div class="binduz-er-blog-details-box">
                            <div class="binduz-er-text">
                                {!! $jurnal->deskripsi !!}
                            </div>
                            @isset($jurnal->file_media)
                                {{-- <div class="container">
                                    <iframe id="jurnalFrame" src="{{ route('pdf.view', ['filename' => $jurnal->file_media]) }}"
                                        sandbox="allow-same-origin allow-scripts" width="100%"height="500px">
                                    </iframe>
                                </div> --}}
                            @endisset
                            
                            <div class="binduz-er-author-item mb-40">
                                <div class="binduz-er-content" style="padding-top: -40px;">
                                <h5>File Jurnal</h5>       
                                @forelse ($jurnal->MediaData as $ind =>$jmd ) 
                                <div class="binduz-er-meta-author">
                                    <div class="binduz-er-author">
                                        <img src="assets/images/user-2.jpg" alt="">
                                        <span>{{ $ind + 1 }}. {{$jmd->JenisMediaProperti->title}}</span>
                                    </div>
                                    <div class="binduz-er-meta-list">
                                        <ul>
                                            <li> <a href="#" class="btnDownload" data-fileid="{{$jmd->id}}"><i class="fal fa-download"></i></a> {{$jmd->download}}</li>
                                        </ul>
                                    </div>
                                </div>
                                @empty
                                    
                                @endforelse
                                   
                                  
                                </div>
                            </div>
                            <div class="binduz-er-author-box">
                                <div class="binduz-er-author-contact d-flex align-content-center">
                                    <ul>
                                        <li>
                                            @if (auth()->check() &&
                                                    auth()->user()->bookmark->contains('media_id', $jurnal->id))
                                                <a href="#" id="icon-download" data-val="1"
                                                    data-id="{{ encrypt($jurnal->id) }}">
                                                    <i class="fa fa-regular fa-heart" style="color:deeppink;"></i>
                                                </a>
                                            @else
                                                <a href="#" id="icon-download" data-val="0"
                                                    data-id="{{ encrypt($jurnal->id) }}">
                                                    <i class="fa fa-regular fa-heart"></i>
                                                </a>
                                            @endif
                                        </li>
                                      {{--   <li><a href="#"><i class="fa fa-download">
                                                </i></a></li>
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li> --}}
                                    </ul>
                                </div>
                            </div>
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
                                                    <img src="{{ asset('assets/data/cover/' . $t->cover) }}" alt=""
                                                        width="160px" height="160px" style="object-fit: cover;">

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

    <!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Evaluasi Unduhan
  </button> --}}
  
  <!-- Modal -->
  <div class="modal fade" id="mdlEvaluated" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Evaluasi Unduhan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="formEvaluation">
                @csrf

                <div class="mb-3">
                    <label for="respondenName" class="col-form-label text-dark">Nama Responden:</label>
                    <input type="text" class="form-control" id="respondenName" name="respondenName" value="{{@Auth::user()->penggunaData->nama }}" required>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="dinasInstansi" class="col-form-label text-dark">Dinas Instansi:</label>
                            <input type="text" class="form-control" id="dinasInstansi" name="dinasInstansi" value="{{@$uhp->UnitData->title}}" required>
                          </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="bidang" class="col-form-label text-dark">Bidang:</label>
                            <input type="text" class="form-control" id="bidang" name="bidang" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="fileid" id="fileid">
             
                
                @foreach ($evaluasi as $key=>$v)
                <div class="mb-3">
                    <label for="bidang" class="col-form-label text-dark">{{$key+1}}. {{$v->label}}</label>
                    @if ($v->is_text)
                        <textarea class="form-control" id="tidak" name="pertanyaan{{$v->id}}" ></textarea>
                    @else
                        @foreach($v->hasJawabanData as $hjd)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pertanyaan{{$v->id}}" id="ex{{$v->id.$hjd->id}}" value="{{$hjd->id}}">
                                <label class="form-check-label" for="ex{{$v->id.$hjd->id}}">
                                {{$hjd->JawabanData->label}}
                                </label>
                            </div>
                        @endforeach
                    @endif
                    
                </div>
                @endforeach
                

                
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="submitEvaluation">Unduh File</button>
        </div>
      </div>
    </div>
  </div>

    <script src="{{ asset('assets/js/pages/landing.js') }}"></script>

    <script>
        if ($('#jurnalFrame').length) {
            var iframe = document.getElementById('jurnalFrame');
            iframe.contentWindow.document.oncontextmenu = function() {
                return false;
            };
        }
        var bookmark = "{{ url('bookmarkUpdate') }}";
        var evaluationDownload = "{{ url('evaluationDownload') }}";
        var csrf = "{{ csrf_token() }}";
        initJurnalDetail();
    </script>
@endsection
