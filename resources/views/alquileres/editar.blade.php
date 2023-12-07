@extends('adminlte::page')

@section('title', 'Ludeño|Alquiler')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Editar Alquiler</h2>
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

            <form method="POST" action="{{ route('alquileres.update', $alquilere->id) }}" class="mx-auto px-4 needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label">Nombre de persona o empresa</label>
                        <input type="text" name="Nombre_de_persona_o_empresa" class="form-control" placeholder="Escriba el nombre o empresa" value="{{ $alquilere->Nombre_de_persona_o_empresa }}" required>
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
                        <label class="form-label" for="Detalle">Detalle</label>
                        <textarea class="form-control" name="Detalle" id="Detalle" required>{{ $alquilere->Detalle }}</textarea>
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
                        <label class="form-label" for="Modulos">Modulos</label>
                        <input type="number" name="Modulos" class="form-control" placeholder="" value="{{ $alquilere->Modulos }}" required>
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
                        <label class="form-label" for="Plataforma">Plataforma</label>
                        <input type="number" name="Plataforma" class="form-control" placeholder="" value="{{ $alquilere->Plataforma }}" required>
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
                        <label class="form-label" for="Retraso_de_entrega">Retraso de entrega</label>
                        <textarea class="form-control" name="Retraso_de_entrega" id="detalle" required>{{ $alquilere->Retraso_de_entrega }}</textarea>
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
                        <label class="form-label" for="Numero_de_comprobante">Nro de comprobante</label>
                        <input type="number" name="Numero_de_comprobante" class="form-control" placeholder="Ejemplo N° 12345678" value="{{ $alquilere->Nro_de_comprobante }}" required>
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
                        <input class="form-control" type="number" name="Ingresos" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." value="{{ $alquilere->Ingresos }}" required>
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
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<!-- Dentro de tu archivo Blade -->
<style>
    .bg {
        background-image: url('{{ asset("imagenesApoyo/editar-andamios.png") }}');
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
<!-- validaciones del frontend-->
<script src="{{ asset('js/validation.js') }}"></script>
@stop