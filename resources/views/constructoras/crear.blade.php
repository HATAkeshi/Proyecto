@extends('adminlte::page')

@section('title', 'Ludeño|Constructora')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Crear Construccion</h2>
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

            <form method="POST" action="{{ route('constructoras.store') }} " class="mx-auto px-4 needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="Dueño_de_la_obra">Dueño de la obra</label>
                        <input type="text" name="Dueño_de_la_obra" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="valid-feedback">
                        Todo bien c:!
                    </div>
                    <div class="invalid-feedback">
                        Este campo es nesesario
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-floating">
                        <label class="form-label" for="Direccion_de_la_obra">Direccion de la obra</label>
                        <input type="text" name="Direccion_de_la_obra" class="form-control" placeholder="Calle/Av." required>
                    </div>
                    <div class="valid-feedback">
                        Todo bien c:!
                    </div>
                    <div class="invalid-feedback">
                        Este campo es nesesario
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="Fecha_inicio_de_Obra">Fecha inicio de Obra</label>
                        <input type="date" name="Fecha_inicio_de_Obra" class="form-control" placeholder="" required>
                    </div>
                    <div class="valid-feedback">
                        Todo bien c:!
                    </div>
                    <div class="invalid-feedback">
                        Este campo es nesesario
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="Fecha_fin_de_Obra">Fecha fin de Obra</label>
                        <input type="date" name="Fecha_fin_de_Obra" class="form-control" placeholder="" required>
                    </div>
                    <div class="valid-feedback">
                        Todo bien c:!
                    </div>
                    <div class="invalid-feedback">
                        Este campo es nesesario
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="Costo">Costo</label>
                        <input type="number" name="Costo" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." required>
                    </div>
                    <div class="valid-feedback">
                        Todo bien c:!
                    </div>
                    <div class="invalid-feedback">
                        Este campo es nesesario
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
<link rel="stylesheet" href="{{ 'css/bootstrap.min.css' }}">
<!-- Dentro de tu archivo Blade -->
<style>
    .bg {
        background-image: url('{{ asset("imagenesApoyo/crear-constructora.png") }}');
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
<!-- validaciones del frontend-->
<script src="{{ asset('js/validation.js') }}"></script>
@stop