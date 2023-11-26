@extends('layouts._main')
@section('content')


<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Bootstrap File Input -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap-fileinput-master/css/fileinput.css') }}"/>
<script src="{{ asset('assets/libs/bootstrap-fileinput-master/js/fileinput.js')}}"></script>

<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

<div class="row">
    <form action="{{route('penerbit.store')}}" id="frmStaff" method="post" enctype="multipart/form-data">
    @csrf
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="header-title mb-0 flex-grow-1">Halaman Untuk Menambah Data Penerbit</h4>
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
                                    <input type="file" id="foto" name="foto">
                                    @error('foto')
                                    <span class="help-block">
                                        <small style="color: red;">Hanya boleh menggunggah file foto (jpg, png, jpeg, gif, svg) dengan ukuran tidak lebih dari 2 Mb.</small>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 row mt-3">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon me-2"></i><strong>Informasi Penerbit</strong>
                            </div>

                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="nama" class="col-sm-3 form-label float-end">Penerbit <span style="color: red">*</span></label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('nama')}}" id="nama" name="nama" placeholder="Masukan Nama Penerbit" required="">
                                    @error('nama')
                                        <small style="color: red;">Nama Tidak Boleh Kosong</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="no_hp" class="col-sm-3 form-label float-end">Nomor Handphone</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('no_hp')}}" id="no_hp" name="no_hp" placeholder="Masukan Nomor Handphone" onkeypress="return hanyaAngka(event)">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="no_hp" class="col-sm-3 form-label float-end">Email</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('email')}}" id="email" name="email" placeholder="Masukan E-Mail">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="no_hp" class="col-sm-3 form-label float-end">Kota</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('alamat')}}" id="alamat" name="alamat" placeholder="Masukan Kota Penerbit">
                                </div>
                            </div>

                          {{--   <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="SelectProvinsi" class="col-sm-3 col-form-label text-right">Provinsi</label>
                                <div class="col-sm-9">
                                    <select class="" style="font-size: 15px;" name="SelectProvinsi" id="SelectProvinsi">
                                        <option></option>
                                        @foreach($data['provinsi'] as $v)
                                            <option value="{{$v->kode}}">{{$v->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="SelectKabupaten" class="col-sm-3 col-form-label text-right">Kabupaten</label>
                                <div class="col-sm-9">
                                    <select class="" style="font-size: 15px;" name="SelectKabupaten" id="SelectKabupaten" >
                                        <option></option>

                                    </select>
                                </div>
                            </div> --}}

                            <div class="mb-3 d-flex justify-content-center">
                                <div class="col-6">
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif1" value="1" autocomplete="off" checked="">
                                        <label class="btn btn-outline-primary" for="is_aktif1">&nbsp;&nbsp;&nbsp;&nbsp;Aktif&nbsp;&nbsp;&nbsp;</label>

                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif2" value="0" autocomplete="off">
                                        <label class="btn btn-outline-dark" for="is_aktif2">Tidak Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" id="btnSubmit" class="btn btn-primary col-md-12">Simpan Data Penerbit</button>
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
<script src="{{ asset('assets/js/pages/penerbit.js') }}"></script>

<script type="text/javascript">
    var pathFoto = "{{asset('img/logo/logo-placeholder.png')}}";
    var NusantaraSelect = "{{route('NusantaraSelect')}}";
    initAdd();
</script>
@endsection
