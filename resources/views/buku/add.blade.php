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

    {{-- <!-- Include the jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3683e5 !important;
        }
    </style>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row animate__animated animate__backInLeft">
        <form action="{{ route('buku.store') }}" id="frmStaff" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="header-title mb-0 flex-grow-1">Halaman Untuk Menambah Data Buku</h4>
                        <div class="flex-shrink-0">
                            {{--  Left Content --}}
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview row g-3">

                            <div class="col-lg-4 mb-4">
                                <div class="col-12 mb-3">
                                    <div>
                                        <input type="file" id="file_cover" name="file_cover">
                                        @error('file_cover')
                                            <span class="help-block">
                                                <small style="color: red;">Hanya boleh menggunggah file foto (jpg, png,
                                                    jpeg, gif, svg) dengan ukuran tidak lebih dari 2 Mb.</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div>
                                        <input type="file" id="file_buku" name="file_buku">
                                        @error('file_buku')
                                            <span class="help-block">
                                                <small style="color: red;">Hanya boleh menggunggah file foto (jpg, png,
                                                    jpeg, gif, svg) dengan ukuran tidak lebih dari 2 Mb.</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 row mt-3">
                                <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show"
                                    role="alert">
                                    <i class="ri-user-smile-line label-icon me-2"></i><strong>Informasi Buku</strong>
                                </div>

                                <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                    <label for="judul" class="col-sm-3 form-label float-end">
                                        Judul <span style="color: red">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" type="text" id="judul" name="judul" placeholder="Masukan Judul Buku" required>{{ old('judul') }}</textarea>
                                        @error('judul')
                                            <small style="color: red;">Judul Tidak Boleh Kosong</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                    <label for="deskripsi" class="col-sm-3 form-label float-end">
                                        Deskripsi Buku <span style="color: red">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi Buku" rows="7"
                                            required>{{ old('deskripsi') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                    <div class="col-sm-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control autocompl-penerbit" id="penerbit"
                                                name="penerbit" placeholder="Masukkan Penerbit">
                                            <label for="floatingInput">Penerbit</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-floating ">
                                            <input type="text" class="form-control" id="tahun" name="tahun"
                                                placeholder="Masukkan Tahun Terbit">
                                            <label for="floatingInput">Tahun Terbit</label>
                                        </div>
                                    </div>
                                </div>

                                {{--   <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                    <label for="isbn" class="col-sm-3 form-label float-end">ISBN</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ old('isbn') }}"
                                            id="isbn" name="isbn" placeholder="Masukan ISBN">
                                    </div>
                                </div> --}}

                                <div class="col-12 col-sm-12 col-xs-12 mb-2 row">
                                    <div class="col-sm-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="issn_daring" name="issn_daring"
                                                placeholder="Masukkan ISSN Daring">
                                            <label for="floatingInput">ISSN Daring</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="issn_cetak" name="issn_cetak"
                                                placeholder="Masukkan ISSN Cetak">
                                            <label for="floatingInput">ISSN Cetak</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                    <div class="col-6">
                                        <label for="isbn" class="form-label ">ISBN</label>
                                        <input id="isbn" class="form-control" type="text"
                                            value="{{ old('isbn') }}" id="isbn" name="isbn"
                                            placeholder="Masukan ISBN">
                                    </div>
                                    <div class="col-6">
                                        <label for="kategori" class="form-label ">Kategori Buku</label>
                                        <select class="form-control" style="font-size: 15px;" name="kategori"
                                            id="kategori">
                                            <option></option>
                                            @foreach ($kategori as $v)
                                                <option value="{{ $v->id }}">{{ $v->label }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    {{--  <div class="col-6">
                                        <label for="tag" class="form-label">Tag Buku</label>
                                        <select class="form-control" style="font-size: 15px;" name="tag[]"
                                            id="tag" multiple="multiple">
                                            <option></option>
                                            @foreach ($tag as $v)
                                                <option value="{{ $v->id }}">{{ $v->label }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                </div>

                            </div>


                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6">
                                    <button type="submit" id="btnSubmit" class="btn btn-primary col-md-12">Simpan
                                        Data Buku</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>

    <!-- Sweet alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Select 2 -->
    <script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>

    <script src="{{ asset('assets/libs/jquery-year/yearpicker.js') }}"></script>

    <script src="{{ asset('assets/js/pages/buku.js') }}"></script>

    <script type="text/javascript">
        var fileBook = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=File+Buku&font=bebas";
        var fileCover = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=File+Cover&font=bebas";
        var yearDefault = 2023;
        var NusantaraSelect = "{{ route('NusantaraSelect') }}";
        var getPenerbit = "{{ url('getPenerbitAutoCompl') }}";
        initAdd();
    </script>
@endsection
