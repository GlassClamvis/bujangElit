@extends('layouts._main')
@section('content')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

    <!-- Bootstrap File Input -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap-fileinput-master/css/fileinput.css') }}" />
    <script src="{{ asset('assets/libs/bootstrap-fileinput-master/js/fileinput.js') }}"></script>

    <!-- Animate V4 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

    <!-- Year Select -->
    <link rel="stylesheet" href="{{ asset('assets/libs/jquery-year/yearpicker.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3683e5 !important;
        }
    </style>

    <div class="row animate__animated animate__backInLeft">
        <form action="{{ route('contentMenu.store') }}" id="frmCM" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="header-title mb-0 flex-grow-1">Halaman Untuk Membuat Content Sub Menu
                            {{ $data['sm']->title }} </h4>
                        <div class="flex-shrink-0">
                            {{--  Left Content --}}
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body live-preview row">

                        <div class="col-12 col-sm-12 col-xs-12 mb-3">
                            <label for="content" class="form-label "></label>
                            <textarea class="form-control" id="berita" name="content" rows="7"></textarea>
                        </div>
                        <input type="hidden" name="subMenuId" value="{{ $id }}">

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" id="btnSubmit" class="btn btn-primary col-md-12">
                                    Simpan Berita
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>

    <!-- Sweet alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Select 2 -->
    <script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>

    <script src="{{ asset('assets/libs/jquery-year/yearpicker.js') }}"></script>

    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/cm.js') }}"></script>

    <script type="text/javascript">
        var fileCover = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=Cover+Berita&font=bebas";
        var NusantaraSelect = "{{ route('NusantaraSelect') }}";
        var getPenerbit = "{{ url('getPenerbitAutoCompl') }}";
        var quill = "";
        var uploadImage = "{{ route('upload-image') }}";
        initAdd();
    </script>
@endsection
