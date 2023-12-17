@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card bg-dark text-white">
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
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-body bg-light p-0">
                    <div class="card-title bg-dark text-white p-3 m-0 w-100">
                        <p class="mb-3" style="font-weight: bold;">
                            Editar Registro
                        </p>
                    </div>
                    <div class="card-text p-3">
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
                                {!! Form::password('password', array('class'=> 'form-control', 'placeholder' => '¿Nueva contraseña?')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label class="form-label" for="name">Confirmar password</label>
                                {!! Form::password('confirm-password', array('class'=> 'form-control', 'placeholder' => '¿Nueva contraseña?')) !!}
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
                </div>
            </div>
        </div>
        <!-- imagen  -->
        <div class="col-xl-6 d-none d-xl-block">
            <img src="{{ asset('imagenesApoyo/editar.png') }}" style="width: 80%;">
        </div>
    </section>
</section>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop