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
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data Menu</h4>
                    <div class="flex-shrink-0">
                        {{--  Left Content --}}
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="row g-3">
                            <form action="" class="form-horizontal" id="frmMenu" method="post"
                                enctype="multipart/form-data" data-parsley-validate="">
                                @csrf

                                <input id="metod" type="hidden" name="_method" value="">
                                <input type="hidden" name="menuId" id="menuId">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="menu" class="form-label">Menu</label>
                                            <input class="form-control" type="text" value="" id="menu"
                                                name="menu" placeholder="Masukan Menu" required="" style="">
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        <div>
                                            <label for="url" class="form-label">Url</label>
                                            <input class="form-control" type="text" value="" id="url"
                                                name="url" placeholder="Masukan url" required="" style="">
                                        </div>
                                    </div>
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
                    <h4 class="card-title mb-0 flex-grow-1">Tabel Data Menu</h4>
                    @can('menu-create')
                        <a href="{{ route('menu.create') }}" class="float-left">
                            <button id="BtnAddMenu" class="btn btn-primary waves-effect waves-light" type="button">
                                <i data-feather="plus-circle"></i> Tambah Menu
                            </button>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableMenu" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Menu</th>
                                        <th>Url</th>
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

            <div class="card formElementSubMenu" style="display: none;" id="formContainerSubMenu">
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
                                            <label for="subMenu" class="form-label">Sub Menu</label>
                                            <input class="form-control" type="text" value="" id="subMenu"
                                                name="subMenu" placeholder="Masukan Sub Menu" required="">
                                            <input type="hidden" name="subMenuId" id="subMenuId">
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
                                        <button type="submit" id="btnSubmitSubMenu"
                                            class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan
                                            Data
                                            Sub Menu</button>
                                        <button type="button" id="btnCancelSubMenu"
                                            class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan
                                            Tambah Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card tableElementSubMenu col-md-12 col-lg-12 col-sm-12"
                style="display: flex; flex-direction: column; width: 100%;">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 header-title-SubMenu"></h4>
                    @can('submenu-create')
                        <a href="#" class="float-left">
                            <button id="BtnAddSubMenu" class="btn btn-primary waves-effect waves-light" type="button">
                                <i data-feather="plus-circle"></i> Tambah Data Sub Menu
                            </button>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableSubMenu" class="table align-middle table-nowrap mb-0" width="100%"
                                cellspacing="">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Sub Menu</th>
                                        <th>Is Aktif?</th>
                                        <th>Action</th>
                                        <th>Create?</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->


                <a href="" class="float-left" style="margin: 0px 0px 10px 10px;">
                    <button id="BtnBackSubMenu" class="btn btn-primary waves-effect waves-light" type="button">
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

    <script type="text/javascript">
        var tableSubMenu = "";
        var tableMenu = "";
        var getSubMenu = "{{ url('getSubMenu') }}";
        var getMenu = "{{ route('getMenu') }}";
        var act = "{{ route('menu.store') }}";
        var menuDelete = "{{ url('menuDelete') }}";
        var subMenuStore = "{{ route('subMenu.store') }}";
        var token = "{{ csrf_token() }}";
        var subMenuDelete = "{{ url('subMenuDelete') }}";
        var globalMenuId = "";
    </script>
    <script src="{{ asset('assets/js/pages/menu.js') }}"></script>
@endsection
