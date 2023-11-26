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

    <!-- Flat Picker -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3683e5 !important;
        }
    </style>

    <div class="row animate__animated animate__backInLeft">
        <form action="{{ route('jurnal.update', $idEncrypt) }}" id="frmStaff" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-lg-12" data-aos="fade-up" data-aos-duration="3000">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="header-title mb-0 flex-grow-1">Halaman Untuk Merubah Data Jurnal</h4>
                        <div class="flex-shrink-0">
                            {{--  Left Content --}}
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">
                                <div class="col-lg-4 mb-4">
                                    @forelse($media->properti as $vp)
                                    <div class="col-12 mb-3">
                                        <div>
                                            <label for="email" class="form-label">{{$vp->title}} </label>
                                            <input type="file" id="file_cover" name="{{ str_replace(' ', '', $vp->title) }}" class="fileUpload">
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="col-lg-8 row mt-3">
                                    <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show"
                                        role="alert">
                                        <i class="ri-user-smile-line label-icon me-2"></i><strong>Informasi Jurnal</strong>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <label for="judul" class="col-sm-3 form-label float-end">Judul Jurnal<span
                                                style="color: red">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" type="text" id="judul" name="judul" placeholder="Masukan Judul Jurnal"
                                                required="">{{ old('judul') ? old('judul') : $jurnal->judul }}</textarea>
                                            @error('judul')
                                                <small style="color: red;">Judul Tidak Boleh Kosong</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <label for="deskripsi" class="col-sm-3 form-label float-end">Abstrak</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="7">{{ old('deskripsi') ? old('deskripsi') : $jurnal->deskripsi }}</textarea>
                                        </div>
                                    </div>

                                    @if (count($pengarang))
                                        @foreach ($pengarang as $p)
                                            <div class="pengarang{{ $p->id . '-' . $p->media_id }}">
                                                <div class="col-12 col-sm-12 col-xs-12 mb-3 row divCode">
                                                    <label for="pengarang"
                                                        class="col-sm-3 form-label float-end labelPengarang"
                                                        id="labelpengarang-{{ $p->id . $p->media_id }}">Pengarang</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control updatePengarang"
                                                                placeholder="Masukkan Nama Pengarang"
                                                                data-btnid="pengarang{{ $p->id . '-' . $p->media_id }}"
                                                                data-id="{{ $p->id }}"
                                                                id="btn{{ $p->id . '-' . $p->media_id }}"
                                                                data-value="{{ $p->nama }}" name="EditPengarang[]"
                                                                value="{{ $p->nama }}">
                                                            <button
                                                                class="btn input-group-text btn-danger waves-effect waves-light delPengarangExist"
                                                                data-save="btn{{ $p->id . '-' . $p->media_id }}"
                                                                data-id="{{ $p->id }}"
                                                                id="pengarang{{ $p->id . '-' . $p->media_id }}"
                                                                type="button"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="copy-pengarang">
                                        <div class="col-12 col-sm-12 col-xs-12 mb-3 row divCode">
                                            <label for="pengarang" class="col-sm-3 form-label float-end labelPengarang"
                                                id="labelpengarang-1">Pengarang</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Masukkan Nama Pengarang" name="pengarang[]">
                                                    <button
                                                        class="btn input-group-text btn-success waves-effect waves-light addPengarang"
                                                        id="idDivCode" type="button"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="paste-pengarang">

                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <label for="isbn" class="col-sm-3 form-label float-end">Tahun Terbit</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="tahunTerbit" name="tahun"
                                                class="form-control flatpickr-input active"
                                                placeholder="Pilih Tahun Terbit" readonly="readonly"
                                                value="{{ old('tahun') ? old('tahun') : $jurnal->tahun_terbit }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control autocompl-penerbit"
                                                    id="penerbit" name="penerbit" placeholder="Masukkan Penerbit"
                                                    value="{{ old('penerbit') ? old('penerbit') : @$jurnal->penerbitData->label }}">
                                                <label for="floatingInput">Penerbit</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-floating ">
                                                <input class="form-control" type="text" id="isbn" name="isbn"
                                                    placeholder="Masukan ISBN"
                                                    value="{{ old('isbn') ? old('isbn') : $jurnal->isbn }}">
                                                <label for="floatingInput">ISBN</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="issn_daring"
                                                    name="issn_daring" placeholder="Masukkan ISSN Daring"
                                                    value="{{ old('issn_daring') ? old('issn_daring') : $jurnal->issn_daring }}">
                                                <label for="floatingInput">ISSN Daring</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="issn_cetak"
                                                    name="issn_cetak" placeholder="Masukkan ISSN Cetak"
                                                    value="{{ old('issn_cetak') ? old('issn_cetak') : $jurnal->issn_cetak }}">
                                                <label for="floatingInput">ISSN Cetak</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                        <div class="col-12">
                                            <label for="kategori" class="form-label ">Kategori Jurnal</label>
                                            <select class="form-control" style="font-size: 15px;" name="kategori"
                                                id="kategori">
                                                <option></option>
                                                @foreach ($kategori as $v)
                                                    <option value="{{ $v->id }}"
                                                        {{ $jurnal->kategori_id == $v->id ? 'selected' : '' }}>
                                                        {{ $v->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- <div class="col-6">
                                            <label for="tag" class="form-label">Tag Jurnal</label>
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
                                            Data Jurnal</button>
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

    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/l10n/id.js') }}"></script>

    <script src="{{ asset('assets/js/pages/jurnal.js') }}"></script>

    <script type="text/javascript">
        var fileBook = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=Upload+File&font=bebas";
        var fileBook = "{{ asset($fileBuku) }}";
        var fileCover = "{{ asset($fileCover) }}";
        var getPenerbit = "{{ url('getPenerbitAutoCompl') }}";
        var yearDefault = "{{ $jurnal->tahun_terbit }}";
        var idCodeDiv = 1;
        var updatePengarang = "{{ route('updatePengarang') }}";
        var delPengarang = "{{ route('delPengarang') }}";
        var _token = "{{ csrf_token() }}";
        const arrTag = <?php echo json_encode($arrTag); ?>;
        initEdit();
    </script>

@endsection
