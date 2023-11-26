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
        <form action="{{ route('berita.update', $idEncrypt) }}" id="frmStaff" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-lg-12" data-aos="fade-up" data-aos-duration="3000">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="header-title mb-0 flex-grow-1">Halaman Untuk Mengubah Data Berita</h4>
                        <div class="flex-shrink-0">
                            {{--  Left Content --}}
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body live-preview row g-3">
                        <div class="col-lg-4">
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
                        </div>
                        <div class="col-lg-8 row mt-3">
                            <div class="col-12 col-sm-12 col-xs-12 mb-3">
                                <label for="judul" class="form-label">Judul Berita<span style="color: red">
                                        *</span></label>
                                <textarea class="form-control" type="text" value="{{ old('judul') }}" id="judul" name="judul"
                                    placeholder="Masukan Judul Jurnal" required="" rows="3">{{ $berita->judul }}</textarea>
                                @error('judul')
                                    <small style="color: red;">Judul Tidak Boleh Kosong</small>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <div class="col-6">
                                    <label class="form-label">Status Berita</label>
                                    <div class="col-12 btn-group" role="group"
                                        aria-label="Basic radio toggle button group">

                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif2"
                                            value="1" autocomplete="off" {{ $berita->is_aktif == 1 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning" for="is_aktif2">Draft</label>

                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif1"
                                            value="2" autocomplete="off"
                                            {{ $berita->is_aktif == 2 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success" for="is_aktif1">Publish</label>

                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif3"
                                            value="3" autocomplete="off"
                                            {{ $berita->is_aktif == 3 ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="is_aktif3">Highlight</label>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label class="form-label">Waktu Baca</label>
                                    <input type="number" pattern="\d*" data-toggle="touchspin" class="form-control"
                                        name="read_time" id="readtime" value="{{ $berita->read_time }}" />
                                </div>
                            </div>



                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <div class="col-6">
                                    <label for="kategori" class="form-label ">Kategori Berita</label>
                                    <select class="form-control" style="font-size: 15px;" name="kategori" id="kategori">
                                        <option></option>
                                        @foreach ($kategori as $v)
                                            <option value="{{ $v->id }}"
                                                {{ $v->id == $berita->kategori_id ? 'selected' : '' }}>
                                                {{ $v->label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--   <div class="col-6">
                                    <label for="tag" class="col-sm-3 form-label">Tag Berita</label>
                                    <select class="form-control" style="font-size: 15px;" name="tag[]" id="tag"
                                        multiple="multiple">
                                        <option></option>
                                        @foreach ($tag as $v)
                                            <option value="{{ $v->id }}">{{ $v->label }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-xs-12 mb-3">
                            <label for="berita" class="form-label ">Berita</label>
                            <textarea class="form-control" id="berita" name="berita" rows="7">{{ $berita->content }}</textarea>
                        </div>

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
    </form>
    </div>

    <!-- Sweet alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Select 2 -->
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>

    <script src="{{ asset('assets/libs/jquery-year/yearpicker.js') }}"></script>

    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/berita.js') }}"></script>

    <script type="text/javascript">
        var fileCover = "{{ asset($fileCover) }}";
        const arrTag = <?php echo json_encode($arrTag); ?>;
        initEdit();
    </script>
@endsection
