@extends('layouts._main')
@section('content')

<!-- third party css -->

<!-- Responsive Datatables -->
<link href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- third party css end -->

<style>
    .dataTables_filter {margin-bottom: 10px;}
    .previous{margin-right: 30px;}
</style>


    @if(session('success'))
    <div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
        <strong> {{session('success')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

        <div class="row">
        <div class="col-xl-12">

            <div class="card formElementAdd" style="display: none;" id="formContainerAdd">
                <div class="card-body ">
                    <h4 class="header-title">Tambah Data Permission</h4>
                    <p class="text-muted font-13 mb-4">
                        Halaman Untuk Menambah <code>Data Permissions</code>.
                    </p>

                       <form action="<?php echo @$link;?>" class="form-horizontal" id="frmPermission" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex ">
                            <div class="col-md-12 row justify-content-center">
                                <div class="copy-fields">
                                    <div class="row form-group col-md-12 abc vstack gap-3" style="margin-bottom: 10px;">
                                        <div class="col-md-12 row">
                                            <div class="col-md-10">
                                                <input class="form-control txtPermission" type="text" name="permission[]" placeholder="Masukan Permission" required="">
                                            </div>
                                            <div class="col-md-2 row">
                                                <button class="col btn btn-success waves-effect waves-light add-more" type="button">
                                                    <i class="mdi mdi-plus-circle" style="font-size: 16px;"></i>
                                                </button>

                                                <button class="col btn btn-danger waves-effect waves-light remove" type="button" style="display: none;" >
                                                    <i class="mdi mdi-minus-circle" style="font-size: 16px;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="core-ans"></div>
                            </div>
                            <div class="col-md-12 row justify-content-center">
                                <button type="button" id="btnCancelAdd" class="col-md-4 btn btn-warning waves-effect waves-light" style="margin-right:1mm;">
                                    <i class="mdi mdi-close-box-multiple me-1"></i>
                                    Batalkan Tambah Data
                                </button>
                                <button type="submit" id="btnSubmitAdd" class="col-md-4 btn btn-info waves-effect waves-light" >
                                    <i class="mdi mdi-content-save-all me-1"></i>
                                    Simpan Data Permission
                                </button>
                            </div>
                        </div>
                    </form>
                </div><!--end card-body-->
            </div>

            <div class="card formElementEdit" style="display: none;" id="formContainer">
                <h4 class="header-title">Ubah Data Permission</h4>
                <p class="text-muted font-13 mb-4">
                    Halaman Untuk Merubah <code>Data Permissions</code>.
                </p>

                <div class="card-body ">
                       <form action="" class="form-horizontal" id="frmPermissionUbah" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="row form-group col-md-12 abc vstack gap-3" style="margin-bottom: 10px;">
                                <div class="col-md-12 ">
                                    <div class="hstack gap-3">
                                        <input class="form-control" type="text" id="permissionUbah" name="permission" placeholder="Masukan Permission" required="">
                                        <input type="hidden" name="id" id="id" value=""/>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 row button-items justify-content-center gap-3">
                                <button type="submit" id="btnSubmit" class="col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Matakuliah</button>
                                <button type="button" id="btnCancel" class="col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                            </div>
                        </div>

                    </form>
                </div><!--end card-body-->
            </div>


            <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif" >
                    <div class="card-header align-items-center d-flex">
                        <h4 class="header-title mb-0 flex-grow-1">Tabel Permission</h4>

                    {{-- @can('permission-create') --}}
                          <div class="col col-md-auto d-flex align-items-start justify-content-end">
                            <button type="button" class="btn btn-blue waves-effect waves-light" id="BtnAddPermission">
                                <i class="mdi mdi-folder-plus-outline me-1" style="font-size: 16px;"></i>
                                Tambah Data Permission
                            </button>
                          </div>
                   {{-- @endcan --}}
                    </div><!-- end card header -->

                <div class="card-body ">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tablePermission" class="table dt-responsive nowrap w-100"  data-datatable="#datatablePagination">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->

        </div><!-- end col -->
    </div><!-- end row -->




<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>

<script src="{{ asset('assets/js/pages/permission.js') }}"></script>

<script type="text/javascript">
var getPermission = "{{route('getPermission')}}";
var act = "{{route('permission.store')}}";
var permissionDelete = "{{url('permissionDelete')}}";
var csrf = "{{ csrf_token() }}";
initIndex();
initEdit();
</script>
@endsection
