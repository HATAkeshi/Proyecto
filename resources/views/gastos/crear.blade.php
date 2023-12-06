@extends('adminlte::page')

@section('title', 'Ludeño|Gastos')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Nuevo Gasto</h2>
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

            <form method="POST" action="{{ route('gastos.store') }} " class="mx-auto px-4 needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="Motivo_resumido_de_salida_de_dinero">Motivo resumido de salida de dinero</label>
                        <textarea class="form-control" id="validationTextarea" name="Motivo_resumido_de_salida_de_dinero" placeholder="Un brebe resumen" required></textarea>
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
                        <label class="form-label" for="Nombre_a_quien_se_entrego_el_dinero">Nombre a quien se entrego el dinero</label>
                        <input type="text" name="Nombre_a_quien_se_entrego_el_dinero" class="form-control" placeholder="Ejemplo: Jose" required>
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
                        <label class="form-label" for="Quien_aprobo_la_entrega_de_dinero">Quien aprobo la entrega de dinero</label>
                        <input type="text" name="Quien_aprobo_la_entrega_de_dinero" class="form-control" placeholder="Ejemplo: Jose" required>
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
                        <label class="form-label" for="Nro_de_comprobante">Nro de comprobante</label>
                        <input type="number" name="Nro_de_comprobante" class="form-control" placeholder="Ejemplo: N°12345678" required>
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
                        <label class="form-label" for="Monto">Monto</label>
                        <input type="number" name="Monto" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." required>
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
        background-image: url('{{ asset("imagenesApoyo/crear-gastos.png") }}');
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