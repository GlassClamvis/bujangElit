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
                    <h4 class="header-title mb-0 flex-grow-1">Tabel Data Jurnal</h4>
                    @can('jurnal-create')
                        <div class="col col-md-auto d-flex align-items-start justify-content-end">
                            <a href="{{ route('jurnal.create') }}" class="btn btn-blue waves-effect waves-light"
                                id="BtnAddJurnal">
                                <i class="mdi mdi-book-plus-outline me-1" style="font-size: 16px;"></i>
                                Tambah Data Jurnal
                            </a>
                        </div>
                    @endcan
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableJurnal" class="table dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Judul Jurnal</th>
                                        <th>Plagiarism</th>
                                        <th>Cover</th>
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

   {{--  <div class="modal fade" id="FormViewFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelDefault" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="labelAdm"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="col-12">
                        <iframe id="ifr" class="col-lg-12" src="" height="400" width="600"></iframe>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div> --}}

    <div id="FormViewFile" class="modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="labelAdm">Modal Heading</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="col-12">
                            <iframe id="ifr" class="col-lg-12" src="" height="400" width="600"></iframe>
                        </div>
                    </div>
                </div>
              
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    
    <div id="ViewStatistik" class="modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="labelStatistik">Modal Heading</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="col-12">
                            <table id="tableStatistik" class="table dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Media Download</th>
                                        <th>Jumlah Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Cover</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Pendahuluan</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Full Text</td>
                                        <td>9</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/jurnal.js') }}"></script>

    <script type="text/javascript">
        var getJurnal = "{{ route('getJurnal') }}";
        var JurnaCheck = "{{ route('jurnalCek') }}";
        var jurnalDelete = "{{ url('jurnalDelete') }}";
        var csrf = "{{ csrf_token() }}";
        var tableJurnal;
        initIndex();
    </script>
@endsection
