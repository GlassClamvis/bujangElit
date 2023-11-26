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

    <style>
        .dataTables_filter {
            margin-bottom: 20px;
        }

        .previous {
            margin-right: 30px;
        }
    </style>

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
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data Unit</h4>
                    <div class="flex-shrink-0">
                        {{--  Left Content --}}
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="row g-3">
                            <form action="" class="form-horizontal" id="frmUnit" method="post"
                                enctype="multipart/form-data" data-parsley-validate="">
                                @csrf

                                <input id="linkUpdate" type="hidden" name="linkUpdate" value="">
                                <input id="metod" type="hidden" name="_method" value="">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="kodeunit" class="form-label text-right">Kode Unit</label>
                                            <input class="form-control" type="text" value="" id="kodeunit"
                                                name="kodeunit" placeholder="Masukan Kode Unit"
                                                style=" text-transform: uppercase;">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="unit" class="form-label">Unit</label>
                                            <input class="form-control" type="text" value="" id="unit"
                                                name="unit" placeholder="Masukan Unit" required=""
                                                style=" text-transform: capitalize;">
                                        </div>
                                    </div>
                                    <div class="col-md-12 row button-items justify-content-center gap-3"
                                        style="margin-top: 10px;">
                                        <button type="button" id="btnCancel"
                                            class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light">Batalkan
                                            Tambah Data</button>
                                        <button type="button" id="btnSubmit"
                                            class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light">Simpan Data
                                            Unit</button>
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
                    <h4 class="card-title mb-0 flex-grow-1">Tabel Data Unit</h4>
                    @can('unit-create')
                        <div class="col col-md-auto d-flex align-items-start justify-content-end">
                            <a href="{{ route('unit.create') }}"
                                class="btn btn-outline-primary btn-icon btn-icon-start ms-1 w-100 w-md-auto mb-2"
                                id="BtnAddUnit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="acorn-icons acorn-icons-plus undefined">
                                    <path d="M10 17 10 3M3 10 17 10"></path>
                                </svg>
                                <span>Tambah Data Unit</span>
                            </a>
                        </div>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableUnit" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Kode Unit</th>
                                        <th>Unit</th>
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

        </div>

    </div>

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
    <script src="{{ asset('assets/js/pages/unit.js') }}"></script>

    <script type       = "text/javascript">
    var     idjur      = "";
    var     getUnit    = "{{ route('getUnit') }}";
    var     act        = "{{ route('unit.store') }}";
    var     unitDelete = "{{ url('UnitDelete') }}";
    var     token      = "{{ csrf_token() }}";
    var     tableUnit  = "";
        IndexUnit();
    </script>
@endsection
