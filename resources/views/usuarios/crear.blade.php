@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Crear Usuario</h2>
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

            <form method="POST" action="{{ route('usuarios.store') }} " class="mx-auto px-4">
                @csrf
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" name="name" class="form-control" placeholder="Escriba su nombre">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="name">E-mail</label>
                        <input type="email" name="email" class="form-control" placeholder="Aqui va su E-mail">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Confirmar password</label>
                        <input type="password" name="confirm-password" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="name">Roles</label>
                        {!! Form::select('roles[]', $roles,[], array('class'=> 'form-control')) !!}
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
        background-image: url('{{ asset("imagenesApoyo/user.jpg") }}');
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