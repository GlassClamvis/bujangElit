@extends('layouts._main')
@section('content')


<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/select2-bootstrap4.min.css') }}">

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Bootstrap File Input -->
<link rel="stylesheet" type="text/css" href="{{ asset('libs/bootstrap-fileinput-master/css/fileinput.css') }}"/>
<script src="{{ asset('libs/bootstrap-fileinput-master/js/fileinput.js')}}"></script>

<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('libs/animate/animate_v4.css') }}">

<div class="row animate__animated animate__backInLeft">
    <form action="{{ route('update.staff',$idEncrypt)}}" id="frmStaffEdit" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="col-lg-12" data-aos="fade-up" data-aos-duration="3000">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Halaman Untuk Mengubah Data Pegawai</h4>
                <div class="flex-shrink-0">
                   {{--  Left Content --}}
                </div>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <div class="row g-3">
                        <div class="col-lg-4 mb-3"> {{-- LEFT SIDE --}}
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
                            @if(Auth::user()->can('set-staff-role'))
                            <div class="col-12 gy-4 mb-3">
                                <div>
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif1" value="1" autocomplete="off" @if($data['pegawai']->is_aktif == 1) checked @endif>
                                        <label class="btn btn-outline-primary" for="is_aktif1">&nbsp;&nbsp;&nbsp;&nbsp;Aktif&nbsp;&nbsp;&nbsp;</label>

                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif2" value="0" autocomplete="off" @if($data['pegawai']->is_aktif == 0) checked @endif>
                                        <label class="btn btn-outline-dark" for="is_aktif2">Tidak Aktif</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-12 gy-4">
                                <div>
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="tm_status_kepegawaian_id" id="tm_status_kepegawaian_id1" value="1" autocomplete="off" @if($data['pegawai']->tm_status_kepegawaian_id == 1) checked @endif>
                                        <label class="btn btn-outline-success" for="tm_status_kepegawaian_id1">Dosen</label>

                                        <input type="radio" class="btn-check" name="tm_status_kepegawaian_id" id="tm_status_kepegawaian_id2" value="2" autocomplete="off" @if($data['pegawai']->tm_status_kepegawaian_id == 2) checked @endif>
                                        <label class="btn btn-outline-warning" for="tm_status_kepegawaian_id2">Administrasi</label>

                                        <input type="radio" class="btn-check" name="tm_status_kepegawaian_id" id="tm_status_kepegawaian_id3" value="3" autocomplete="off" @if($data['pegawai']->tm_status_kepegawaian_id == 3) checked @endif>
                                        <label class="btn btn-outline-danger" for="tm_status_kepegawaian_id3">Teknisi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 row mt-3 mb-1 ml-2"> {{-- RIGTH SIDE --}}
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Pribadi</strong>
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="kode" class="col-sm-3 form-label float-end">NIP / NRP </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('nip')?old('nip'):$data['pegawai']->nip}}" id="nip" name="nip" placeholder="Masukan NIP / NRP" >
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="kode" class="col-sm-3 form-label float-end">NIK </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('nik')?old('nik'):$data['pegawai']->nik}}" id="nik" name="nik" placeholder="Masukan NIK" >
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="nama" class="col-sm-3 form-label float-end">Nama Lengkap <span style="color: red">*</span></label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('nama')?old('nama'):$data['pegawai']->nama}}" id="nama" name="nama" placeholder="Masukan Nama Lengkap" required="">
                                    @error('nama')
                                        <small style="color: red;">Nama Tidak Boleh Kosong</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="no_hp" class="col-sm-3 form-label float-end">Nomor Handphone</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('no_hp')?old('no_hp'):$data['pegawai']->no_hp}}" id="no_hp" name="no_hp" placeholder="Masukan Nomor Handphone" onkeypress="return hanyaAngka(event)">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="no_hp" class="col-sm-3 form-label float-end">Jabatan Fungsional</label>
                                <div class="col-sm-9">
                                     <select class="form-control" style="font-size: 15px;" name="jabfung" id="jabfung">
                                            <option></option>
                                            @forelse(@$data['jabfung'] as $v)
                                                <option value="{{$v->id}}" {{$v->id == @$data['jabfungs']? 'selected':''}}  >{{$v->jabatan_fungsional." | ".$v->pangkat.' | '.$v->golongan.' | '.$v->angka_kredit}}</option>
                                                @empty
                                                <option value=""></option>
                                            @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="no_hp" class="col-sm-3 form-label float-end">Bidang Ilmu</label>
                                <div class="col-sm-9">
                                     <select class="form-control" style="font-size: 15px;" name="bilmu" id="bilmu">
                                            <option></option>
                                            @forelse(@$data['bilmu'] as $v)
                                                <option value="{{$v->id}}" {{$v->id == @$data['bilmus']? 'selected':''}}  >{{$v->label}}</option>
                                                @empty
                                                <option value=""></option>
                                            @endforelse
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="no_hp" class="col-sm-3 form-label float-end">Angka Kredit</label>
                                <div class="col-sm-9">
                                    <input class="form-control decimal" type="text" value="{{old('angka_kredit')?old('angka_kredit'):$data['pegawai']->angka_kredit}}" id="angka_kredit" name="angka_kredit">
                                </div>
                            </div>
                        </div>


                        <div class="row d-flex mb-1">

                            <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-shield-keyhole-line label-icon"></i><strong>Informasi Akun</strong>
                            </div>

                            <div class="col-xxl-3 col-md-6 mb-3">
                                <div>
                                    <label for="email" class="form-label"><span style="color: red">*</span>E - Mail </label>
                                    <input class="form-control" type="text" value="{{old('email')?old('email'):$data['pegawai']->email}}" id="email" name="email" placeholder="Masukan E-Mail" >
                                    @error('email')
                                        <small style="color: red;">Email Tidak Boleh Kosong</small>
                                    @enderror
                                </div>
                            </div>

                            @can('set-staff-role')
                            <div class="col-xxl-3 col-md-6 mb-3">
                                <div >
                                    <label for="roles" class="form-label ">Roles</label>
                                    <select class="form-control" style="font-size: 15px;" name="roles[]" id="roles" multiple="multiple">
                                            <option></option>
                                            @foreach($roles as $v)
                                                <option value="{{$v}}" {{-- {{$v == @$userRole? 'selected':''}} --}}  >{{$v}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            @endcan

                            <div class="col-12 row">
                                <div class="col-xxl-3 col-md-6 mb-3">
                                    <div>
                                        <label for="password" class="form-label"><span style="color: red">*</span>Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                                        @error('password')
                                            <small style="color: red;">Password Tidak Boleh Kosong</small>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-xxl-3 col-md-6 mb-3">
                                    <div>
                                        <label for="password_confirmation" class="form-label">Ulangi Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" value="">
                                        <p style="display: none; color: red;" id="warn_pass">Password Tidak Cocok.</p>
                                    </div>
                                </div>
                                <small style="color: red">Biarkan Kosong Jika Tidak Ingin Merubah Password</small>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" id="btnSubmit" class="btn btn-primary col-md-12">Simpan Perubahan Data Pegawai</button>
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
<script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('libs/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('libs/decimal/input-number-format.jquery.min.js') }}"></script>

<script src="{{ asset('js/pages/pegawai.js') }}"></script>
<script type="text/javascript">
    var pathFoto = "{{asset($imagePath)}}";
    const arrRoles = <?php echo json_encode($arrRole); ?>;
    initEditS();
    var getNotif           = "{{url('getNotif')}}";
    var NotifId                  = "mHMdZhfR4n";


</script>
<script src= "{{ asset('js/pages/notif.js') }}"></script>
@endsection
