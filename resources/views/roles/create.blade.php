@extends('layouts._main')
@section('content')

<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('libs/animate/animate_v4.css') }}">

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="header-title mb-0 flex-grow-1">Halaman Untuk Menambah Role</h4>
                <div class="flex-shrink-0">
                   {{--  Left Content --}}
                </div>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <div class="row ">
                        {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group">
                                    <strong>Masukan Role</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Masukan Role','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 pl-5">
                                <div class="row"> @php $ctrl=0; @endphp
                                    @foreach($permission as $value) @if($ctrl==4) @php $ctrl=0; @endphp @endif
                                    @php $class="";
                                        if($ctrl==4){$ctrl=0;}
                                        if(strpos($value,"-list") !== false){$class="form-check-secondary";}
                                        elseif (strpos($value,"-create") !== false){ $class="form-check-success";}
                                        elseif (strpos($value,"-delete") !== false){ $class="form-check-danger" ;}
                                        elseif (strpos($value,"-edit") !== false){ $class="form-check-warning";}
                                        else { $class="form-check-dark";}
                                    @endphp

                                    <div class="col-lg-3 col-md-3 form-check {{$class}} mb-3">
                                        <input class="form-check-input" type="checkbox" id="formCheck{{$value->id}}" name="permission[]" value="{{$value->id}}" >
                                        <label class="form-check-label" for="formCheck{{$value->id}}">
                                            {{ $value->name }}
                                        </label>
                                    </div>
                                    @php $ctrl++ @endphp
                                @endforeach


                                </div>
                               {{--  <div class="form-group">
                                    <strong>Permission:</strong>
                                    <br/>
                                    @foreach($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br/>
                                    @endforeach
                                </div> --}}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
                                <button type="submit" class="btn btn-primary">Simpan Data Role</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

</script>
@endsection
