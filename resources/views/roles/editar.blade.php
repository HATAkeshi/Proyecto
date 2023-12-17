@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Editar Rol</h2>
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
                        {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
                        <div class="mb-3">
                            <div class="form-group">
                                <label class="form-label" for="name">Nombre del Rol: </label>
                                {!! Form::text('name', null, array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label class="form-label" for="name">Permisos de este Rol:</label>
                                <br />
                                @foreach ($permission as $value)
                                <label class="form-check-label ml-5" style="font-weight: bold;">
                                    {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions)? true : false, array('class' => 'name form-check-input')) }}
                                    {{ $value->name }}
                                </label>
                                <br />
                                @endforeach
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
            <img src="{{ asset('imagenesApoyo/editar-role.png') }}" style="width: 100%;">
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