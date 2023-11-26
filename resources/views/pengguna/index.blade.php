@extends('layouts._main')
@section('content')
    <!-- third party css -->

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

    <!-- third party css end -->

    <style>
        .dataTables_filter {
            margin-bottom: 10px;
        }

        .previous {
            margin-right: 30px;
        }
    </style>

    <!-- Animate V4 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
            <strong> {{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row animate__animated animate__backInLeft">
        <div class="col-xl-12">
            <div class="card tableElement">
                <div class="card-header align-items-center d-flex" style="margin-bottom:0px;padding-bottom:0px;">
                    <h4 class="header-title mb-0 flex-grow-1">Tabel Data Pengguna</h4>
                    @can('user-create')
                        <div class="col col-md-auto d-flex align-items-start justify-content-end">
                            <a href="{{ route('pengguna.create') }}" class="btn btn-blue waves-effect waves-light"
                                id="BtnAddPegawai">
                                <i class="mdi mdi-account-plus-outline me-1" style="font-size: 16px;"></i>
                                Tambah Data Pengguna
                            </a>
                        </div>
                    @endcan
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableUser" class="table dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Foto</th>
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

    <script src="{{ asset('assets/js/pages/pengguna.js') }}"></script>

    <script type="text/javascript">
        var getStaff = "{{ route('getPengguna') }}";
        var PenggunaDelete = "{{ url('PenggunaDelete') }}"; 
        var csrf = "{{ csrf_token() }}";
        initIndex();
    </script>
@endsection
