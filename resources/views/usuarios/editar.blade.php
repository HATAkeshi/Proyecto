@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Editar Usuario</h2>
    </div>
</div>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-dark alert-dismissible fade show" role="alert">
    <strong>¡Revise los campos!</strong>
    @foreach ($errors->all() as $error)
    <span class="badge badge-danger">{{ $error }}</span>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<section class="container">
    <section class="row aling-items-center">
        <div class="col col-md-6">

            {!! Form::model($user, ['method' => 'PUT','route' => ['usuarios.update', $user->id]]) !!}
            <div class="mb-3">
                <div class="form-group">
                    <label class="form-label" for="name">Nombre</label>
                    {!! Form::text('name', null, array('class'=> 'form-control')) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label class="form-label" for="name">E-mail</label>
                    {!! Form::text('email', null, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label class="form-label" for="name">Password</label>
                    {!! Form::password('password', array('class'=> 'form-control')) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label class="form-label" for="name">Confirmar password</label>
                    {!! Form::password('confirm-password', array('class'=> 'form-control')) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label class="form-label" for="name">Roles</label>
                    {!! Form::select('roles[]', $roles, $userRole, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            
            {!! Form::close() !!}
        </div>
        <div class="col col-md-6 bg d-none d-sm-block"></div>
    </section>
</section>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<!-- Dentro de tu archivo Blade -->
<style>
    .bg {
        background-image: url('{{ asset("imagenesApoyo/editar.png") }}');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 50%;
    }
</style>
@stop

@section('js')
<script>
    console.log('Hola');
</script>
@stop