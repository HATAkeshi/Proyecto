@extends('adminlte::page')

@section('title', 'Ludeño|Deposito')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Editar Deposito</h2>
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

            <form method="POST" action="{{ route('depositos.update', $deposito->id) }} " class="mx-auto px-4 needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="Nro_de_transaccion">Nro de transaccion</label>
                        <input type="number" name="Nro_de_transaccion" class="form-control" placeholder="Ejemplo N° 12345678" value="{{ $deposito->Nro_de_comprobante }}" required>
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
                        <label class="form-label" for="Nombre">Nombre</label>
                        <input type="number" name="Nombre" class="form-control" placeholder="" value="{{ $deposito->Nombre }}" required>
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
                        <input type="number" name="Monto" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." value="{{ $deposito->Monto }}" required>
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
        background-image: url('{{ asset("imagenesApoyo/editar-depositos.png") }}');
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
<!-- validaciones del frontend-->
<script src="{{ asset('js/validation.js') }}"></script>
@stop