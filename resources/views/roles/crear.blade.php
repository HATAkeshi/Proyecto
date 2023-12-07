@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Crear Rol</h2>
    </div>
</div>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-dark alert-dimissible fade show" role="alert">
    <strong>¡Revise los campos >:c!</strong>
    @foreach ($errors->all() as $error)
    <span class="badge badge-danger">{{$error}}</span>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<section class="container">
    <section class="row aling-items-center">
        <div class="col col-md-6">

            <form method="POST" action="{{ route('roles.store') }} " class="mx-auto px-4">
                @csrf
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Nombre del Rol</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Permisos para este Rol: </label>
                        <br />
                        @foreach ($permission as $value)
                        <label class="form-check-label ml-5" style="font-weight: bold;">
                            {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name form-check-input')) }}
                            {{ $value->name }}
                        </label>
                        <br />
                        @endforeach
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
            
        </div>
        <div class="col col-md-6 bg d-none d-sm-block"></div>
    </section>
</section>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<!-- Dentro de tu archivo Blade -->
<style>
    .bg {
        background-image: url('{{ asset("imagenesApoyo/roles-crear.png") }}');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 50%;
    }
</style>
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop