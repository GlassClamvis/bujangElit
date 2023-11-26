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

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3683e5 !important;
        }
    </style>

    <div class="row animate__animated animate__backInLeft">
        <form action="{{ route('buku.update', $idEncrypt) }}" id="frmStaff" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-lg-12" data-aos="fade-up" data-aos-duration="3000">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="header-title mb-0 flex-grow-1">Halaman Untuk Mengubah Data Buku</h4>
                        <div class="flex-shrink-0">
                            {{--  Left Content --}}
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">
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
                                        <label for="judul" class="col-sm-3 form-label float-end">Judul <span
                                                style="color: red">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="judul" name="judul" placeholder="Masukan Judul Buku" required=""
                                                rows="5">{{ old('judul') ? old('judul') : $buku->judul }}</textarea>
                                            @error('judul')
                                                <small style="color: red;">Judul Tidak Boleh Kosong</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <label for="deskripsi" class="col-sm-3 form-label float-end">Deskripsi Buku</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi') ? old('deskripsi') : $buku->deskripsi }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control autocompl-penerbit" id="penerbit"
                                                    name="penerbit" placeholder="Masukkan Penerbit"
                                                    value="{{ old('penerbit') ? old('penerbit') : @$buku->penerbitData->label }}">
                                                <label for="floatingInput">Penerbit</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-floating ">
                                                <input type="text" class="form-control" id="tahun" name="tahun"
                                                    placeholder="Masukkan Tahun Terbit"
                                                    value="{{ old('tahun') ? old('tahun') : $buku->TahunBuku }}">
                                                <label for="floatingInput">Tahun Terbit</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <label for="isbn" class="col-sm-3 form-label float-end">ISBN</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="isbn" name="isbn"
                                                placeholder="Masukan ISBN"
                                                value="{{ old('isbn') ? old('isbn') : $buku->isbn }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="issn_daring"
                                                    name="issn_daring" placeholder="Masukkan ISSN Daring"
                                                    value="{{ old('issn_daring') ? old('issn_daring') : $buku->issn_daring }}">
                                                <label for="floatingInput">ISSN Daring</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="issn_cetak"
                                                    name="issn_cetak" placeholder="Masukkan ISSN Cetak"
                                                    value="{{ old('issn_cetak') ? old('issn_cetak') : $buku->issn_cetak }}">
                                                <label for="floatingInput">ISSN Cetak</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <div class="col-6">
                                            <label for="isbn" class="form-label ">ISBN</label>
                                            <input class="form-control" type="text" id="isbn" name="isbn"
                                                placeholder="Masukan ISBN"
                                                value="{{ old('isbn') ? old('isbn') : $buku->isbn }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="kategori" class="form-label ">Kategori Buku</label>
                                            <select class="form-control" style="font-size: 15px;" name="kategori"
                                                id="kategori">
                                                <option></option>
                                                @foreach ($kategori as $v)
                                                    <option value="{{ $v->id }}"
                                                        {{ $v->id == $buku->kategori_id ? 'selected' : '' }}>
                                                        {{ $v->label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{--   <div class="col-6">
                                            <label for="tag" class="col-sm-3 form-label">Tag Buku</label>
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
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-year/yearpicker.js') }}"></script>

    <script src="{{ asset('assets/js/pages/buku.js') }}"></script>

    <script type="text/javascript">
        var fileBook = "{{ asset($fileBuku) }}";
        var fileCover = "{{ asset($fileCover) }}";
        var getPenerbit = "{{ url('getPenerbitAutoCompl') }}";
        var yearDefault = "{{ $buku->TahunBuku }}";
        const arrTag = <?php echo json_encode($arrTag); ?>;
        initEdit();
    </script>
@endsection
