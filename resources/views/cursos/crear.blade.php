@extends('adminlte::page')

@section('title', 'Ludeño|Cursos')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Nueva Inscripcion de Cursos</h2>
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

            <form method="POST" action="{{ route('cursos.store') }} " class="mx-auto px-4 needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="Nombre_de_persona">Nombre de persona</label>
                        <input type="text" name="Nombre_de_persona" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="valid-feedback">
                        <p>Todo bien c:!</p>
                    </div>
                    <div class="invalid-feedback">
                        <p>Este campo es nesesario</p>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="Porcentaje_de_anticipo">Porcentaje de anticipo</label>
                        <input type="number" name="Porcentaje_de_anticipo" min="0" max="100" step="0.01" pattern="\d+(\.\d{2})?" required>
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
                        <label class="form-label" for="Nombre_de_persona_pago_total">Nombre de persona pago total</label>
                        <input type="text" name="Nombre_de_persona_pago_total" class="form-control" placeholder="Ejemplo: Jose" required>
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
                        <label class="form-label" for="Detalle_de_curso">Detalle de curso</label>
                        <select name="Detalle_de_curso" id="detalle" class="form-select">
                            <option value="carpinteria">Carpiteria en Aluminio</option>
                            <option value="sketchup">Scketch Up - V-Ray</option>
                            <option value="manejo_redes">Manejo de Redes</option>
                        </select>
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
                        <label class="form-label" for="Numero_de_comprobante">Numero de comprobante</label>
                        <input type="number" name="Numero_de_comprobante" class="form-control" placeholder="" required>
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
                        <label class="form-label" for="Ingresos">Ingresos</label>
                        <input type="number" name="Ingresos" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." required>
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
        background-image: url('{{ asset("imagenesApoyo/crea-cursos.png") }}');
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