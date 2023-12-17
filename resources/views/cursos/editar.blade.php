@extends('adminlte::page')

@section('title', 'Ludeño|Cursos')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Editar Inscripcion de Cursos</h2>
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
    <div class="row aling-items-center">
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-body bg-light p-0">
                    <div class="card-title bg-dark text-white p-3 m-0 w-100">
                        <p class="mb-0" style="font-weight: bold;">Editar registro</p>
                    </div>
                    <div class="card-text p-3">
                        <form method="POST" action="{{ route('cursos.update', $curso->id) }}" class="mx-auto px-4 needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="Nombre_de_persona">Nombre de persona</label>
                                    <input type="text" name="Nombre_de_persona" class="form-control" placeholder="Nombre" value="{{$curso->Nombre_de_persona}}" required>
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
                                    <label class="form-label" for="Porcentaje_de_anticipo">Porcentaje de anticipo</label>
                                    <input class="form-control" type="number" name="Porcentaje_de_anticipo" min="0" max="100" step="0.01" pattern="\d+(\.\d{2})?" value="{{$curso->Porcentaje_de_anticipo}}" required>
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
                                    <input type="text" name="Nombre_de_persona_pago_total" class="form-control" placeholder="Ejemplo: Jose" value="{{$curso->Nombre_de_persona_pago_total}}" required>
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
                                        <option value="Carpiteria en Aluminio" {{ $curso->Detalle_de_curso === 'Carpintería en Aluminio' ? 'selected' : '' }}>Carpintería en Aluminio</option>
                                        <option value="Scketch Up - V-Ray" {{ $curso->Detalle_de_curso === 'Scketch Up - V-Ray' ? 'selected' : '' }}>Scketch Up - V-Ray</option>
                                        <option value="Manejo de Redes" {{ $curso->Detalle_de_curso === 'Manejo de Redes' ? 'selected' : '' }}>Manejo de Redes</option>
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
                                    <label class="form-label" for="Ingresos">Ingresos</label>
                                    <input class="form-control" type="number" name="Ingresos" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." value="{{$curso->Ingresos}}" required>
                                </div>
                                <div class="valid-feedback">
                                    Todo bien c:!
                                </div>
                                <div class="invalid-feedback">
                                    Este campo es nesesario
                                </div>
                            </div>
                            <!-- validar los depositos si es que fueron creados de esa manera -->
                            <div class="mb-3">
                                <label for="metodo_pago" class="form-label">Método de Pago:</label>
                                <select id="metodo_pago" class="form-control" name="metodo_pago">
                                    <option value="efectivo" {{ $curso->metodo_pago === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                    <option value="deposito" {{ $curso->metodo_pago === 'deposito' ? 'selected' : '' }}>Depósito</option>
                                </select>
                            </div>
                            <!-- Campos relacionados con el depósito, mostrar solo si el método de pago es un depósito -->
                            @if ($curso->metodo_pago === 'deposito')

                            <div id="campos_deposito" style="display:block">
                                @foreach($curso->depositos as $deposito)
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="Nro_de_transaccion" class="form-label">N° de transaccion</label>
                                        <input class="form-control" type="number" name="Nro_de_transaccion" value="{{ $deposito->Nro_de_transaccion }}">
                                        <div class="valid-feedback">
                                            Todo bien c:!
                                        </div>
                                        <div class="invalid-feedback">
                                            Este campo es nesesario
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="mb-3">
                                    <div class="form-group">
                                        <label for="Nombre" class="form-label">Nombre</label>
                                        <input class="form-control" type="text" name="Nombre" value="{{ $deposito-> Nombre}}">
                                        <div class="valid-feedback">
                                            Todo bien c:!
                                        </div>
                                        <div class="invalid-feedback">
                                            Este campo es nesesario
                                        </div>
                                    </div>
                                </div> -->
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="Monto" class="form-label">Monto</label>
                                        <input class="form-control" type="number" name="Monto" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." value="{{ $deposito-> Monto}}">
                                        <div class="valid-feedback">
                                            Todo bien c:!
                                        </div>
                                        <div class="invalid-feedback">
                                            Este campo es nesesario
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @else
                            <!-- si no hay un deposito y se quiere cambiar a deposito -->
                            <div id="campos_deposito" style="display: none;">
                                <div class="mb-3">
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
                                </div>
                                <div class="mb-3">
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
                                </div>
                            </div>
                            @endif

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- imagen  -->
        <div class="col-xl-6 d-none d-xl-block">
            <img src="{{ asset('imagenesApoyo/edita-cursos.png') }}" style="width: 100%;">
        </div>
    </div>
</section>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/dinamismoEdit.js') }}"></script>
<script>
    console.log('Hola');
</script>
<!-- validaciones del frontend-->
@stop