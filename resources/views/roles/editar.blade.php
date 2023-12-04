@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card">
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
        <div class="col col-md-6">

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
                    <label>
                        {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions)? true : false, array('class' => 'name')) }}
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
        <div class="col col-md-6 bg d-none d-sm-block"></div>
    </section>
</section>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<!-- Dentro de tu archivo Blade -->
<style>
    .bg {
        background-image: url('{{ asset("imagenesApoyo/editar-role.png") }}');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 60%;
    }
</style>
@stop

@section('js')
<script>
    console.log('Hola');
</script>
@stop