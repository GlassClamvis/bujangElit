@extends('layouts._main')
@section('content')
    <!-- Responsive Datatables -->
    <link href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2-bootstrap4.min.css') }}">


    @if (session('success'))
        <div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
            <strong> {{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">

            <div class="card formElement" style="display: none;" id="formContainer">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Jenis Media</h4>
                    <div class="flex-shrink-0">
                        {{--  Left Content --}}
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="row g-3">
                            <form action="" class="form-horizontal" id="frmJenisMedia" method="post"
                                enctype="multipart/form-data" data-parsley-validate="">
                                @csrf

                                <input id="metod" type="hidden" name="_method" value="">
                                <input type="hidden" name="jenisMediaId" id="jenisMediaId">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="jenismedia" class="form-label">Jenis Media</label>
                                            <input class="form-control" type="text" value="" id="jenismedia"
                                                name="jenismedia" placeholder="Masukan Jenis Media" required="" style="">
                                        </div>
                                    </div>
                                  {{--   <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="url" class="form-label">Url</label>
                                            <input class="form-control" type="text" value="" id="url"
                                                name="url" placeholder="Masukan url" required="" style="">
                                        </div>
                                    </div> --}}
                                    {{--  <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="icon" class="form-label text-right">Icon</label>
                                            <input class="form-control" type="text" value="" id="icon"
                                                name="icon" placeholder="Masukan Icon">
                                        </div>
                                    </div> --}}




                                    <div class="col-md-12 row button-items justify-content-center gap-3"
                                        style="margin-top: 10px;">
                                        <button type="submit" id="btnSubmit"
                                            class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data
                                            Menu</button>
                                        <button type="button" id="btnCancel"
                                            class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan
                                            Tambah Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card tableElement wow fadeInLeft" id="tableCard"
                style="display: @if ($errors->any()) none @else block @endif">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tabel Data Jenis Media</h4>
                    @can('jenisMedia-create')
                        <a href="{{ route('jenisMedia.create') }}" class="float-left">
                            <button id="BtnAddJenisMedia" class="btn btn-primary waves-effect waves-light" type="button">
                                <i data-feather="plus-circle"></i> Tambah Jenis Media
                            </button>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableJenisMedia" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Jenis Media</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div>

            <div class="card formElementProperti" style="display: none;" id="formContainerSubMenu">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data SubMenu</h4>
                    <div class="flex-shrink-0">
                        {{--  Left Content --}}
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="row g-3">
                            <form action="" class="form-horizontal" id="frmSubMenu" method="post"
                                enctype="multipart/form-data" data-parsley-validate="">

                                {{-- <input type="hidden" name="globalMenuId" id="globalMenuId"> --}}
                                <div class="row d-flex justify-content-center">
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="properti" class="form-label">Label Properti Media</label>
                                            <input class="form-control" type="text" value="" id="properti"
                                                name="properti" placeholder="Masukan Label Properti Media" required="">
                                            <input type="hidden" name="propertiId" id="propertiId">
                                        </div>
                                    </div>
                                    {{--  <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="subMenuUrl" class="form-label">Url</label>
                                            <input class="form-control" type="text" value="" id="subMenuUrl"
                                                name="subMenuUrl" placeholder="Masukan Sub Menu Url" required="">
                                        </div>
                                    </div> --}}

                                    <div class="col-md-12 row button-items justify-content-center gap-3"
                                        style="margin-top: 10px;">
                                        <button type="submit" id="btnSubmitProperties"
                                            class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan
                                            Data
                                            Properti Media</button>
                                        <button type="button" id="btnCancelProperties"
                                            class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan
                                            Tambah Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card tableElementProperti col-md-12 col-lg-12 col-sm-12" style="display: flex; flex-direction: column; width: 100%;">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 header-title-SubMenu"></h4>
                    @can('jenisMedia-create')
                        <a href="#" class="float-left">
                            <button id="BtnAddProperti" class="btn btn-primary waves-effect waves-light" type="button">
                                <i data-feather="plus-circle"></i> Tambah Properti Media
                            </button>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableProperties" class="table align-middle table-nowrap mb-0" width="100%"
                                cellspacing="">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Label</th>
                                        <th>Is Aktif?</th>
                                        <th>Is Cek?</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->


                <a href="" class="float-left" style="margin: 0px 0px 10px 10px;">
                    <button id="BtnBackProperti" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="arrow-left-circle"></i> Kembali
                    </button>
                </a>
            </div>

        </div>

    </div>

    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <!-- Sweet alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Select 2 -->
    <script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>

    <script type                       = "text/javascript">
    var     tableProperties            = "";
    var     tableJenisMedia            = "";
    var     getjenisMediaProperties    = "{{ url('getjenisMediaProperties') }}";
    var     getjenisMedia              = "{{ route('getjenisMedia') }}";
    var     act                        = "{{ route('jenisMedia.store') }}";
    var     jenisMediaDelete           = "{{ url('jenisMediaDelete') }}";
    var     jenisMediaPropertiesStore  = "{{ route('jenisMediaProperties.store') }}";
    var     token                      = "{{ csrf_token() }}";
    var     jenisMediaPropertiesDelete = "{{ url('jenisMediaPropertiesDelete') }}";
    var     globalMenuId               = "";
    var     statusJenisMediaProperties = "{{url('statusJenisMediaProperties')}}";
    var     isCekJenisMedia            = "{{url('isCekJenisMedia')}}";
    </script>
    <script src="{{ asset('assets/js/pages/jenisMedia.js') }}"></script>
@endsection
