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

            <form method="POST" action="{{ route('cursos.store') }} " class="mx-auto px-4 needs-validation" id="miFormulario" novalidate>
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
                        <input class="form-control" type="number" name="Porcentaje_de_anticipo" min="0" max="100" step="0.01" pattern="\d+(\.\d{2})?" required>
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
                            <option value="Carpiteria en Aluminio">Carpiteria en Aluminio</option>
                            <option value="Scketch Up - V-Ray">Scketch Up - V-Ray</option>
                            <option value="Manejo de Redes">Manejo de Redes</option>
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
                        <input class="form-control" type="number" name="Ingresos" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." required>
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
                        <label for="metodo_pago" class="form-label">Método de Pago:</label>
                        <select id="metodo_pago" class="form-control" name="metodo_pago">
                            <option value="efectivo">Efectivo</option>
                            <option value="deposito">Depósito Bancario</option>
                        </select>
                    </div>
                </div>
                <div id="campos_deposito" style="display: none;">
                    <div class="mb-3">
                        <!-- formularios para pago por depositos -->
                        <div class="form-group">
                            <label for="Nro_de_transaccion" class="form-label">N° de transaccion</label>
                            <input class="form-control" type="number" name="Nro_de_transaccion">
                            <div class="valid-feedback">
                                Todo bien c:!
                            </div>
                            <div class="invalid-feedback">
                                Este campo es nesesario
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Nombre" class="form-label">Nombre</label>
                            <input class="form-control" type="text" name="Nombre">
                            <div class="valid-feedback">
                                Todo bien c:!
                            </div>
                            <div class="invalid-feedback">
                                Este campo es nesesario
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Monto" class="form-label">Monto</label>
                            <input class="form-control" type="number" name="Monto" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs.">
                            <div class="valid-feedback">
                                Todo bien c:!
                            </div>
                            <div class="invalid-feedback">
                                Este campo es nesesario
                            </div>
                        </div>
                        <br>
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
        background-image: url('{{ asset("imagenesApoyo/crea-cursos.png") }}');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 60%;
    }
</style>

@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/formularioDinamico.js') }}"></script>
<script src="{{ asset('js/validacionesDesactivadas.min.js') }}"></script>
<script>
    console.log('Hola');
</script>
<!-- validaciones del frontend-->
<script src="{{ asset('js/validation.js') }}"></script>
@stop