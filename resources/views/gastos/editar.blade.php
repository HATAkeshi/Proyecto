@extends('adminlte::page')

@section('title', 'Ludeño|Gastos')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Editar Gasto</h2>
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
                        <p class="mb-3" style="font-weight: bold;">
                            Editar Registro
                        </p>
                    </div>
                    <div class="card-text p-3">
                        <form method="POST" action="{{ route('gastos.update', $gasto->id) }} " class="mx-auto px-4 needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="Motivo_resumido_de_salida_de_dinero">Motivo resumido de salida de dinero</label>
                                    <textarea class="form-control" id="validationTextarea" name="Motivo_resumido_de_salida_de_dinero" placeholder="Un brebe resumen" required>{{$gasto->Motivo_resumido_de_salida_de_dinero}}</textarea>
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
                                    <label class="form-label" for="Nombre_a_quien_se_entreg el_dinero">Nombre a quien se entrego el dinero</label>
                                    <input type="text" name="Nombre_a_quien_se_entrego_el_dinero" class="form-control" placeholder="Ejemplo: Jose" value="{{$gasto->Nombre_a_quien_se_entrego_el_dinero}}" required>
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
                                    <input type="text" name="Quien_aprobo_la_entrega_de_dinero" class="form-control" placeholder="Ejemplo: Jose" value="{{$gasto->Quien_aprobo_la_entrega_de_dinero}}" required>
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
                                    <input class="form-control" type="number" name="Monto" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." value="{{$gasto->Monto}}" required>
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
                </div>
            </div>
        </div>
        <!-- imagen  -->
        <div class="col-xl-6 d-none d-xl-block">
            <img src="{{ asset('imagenesApoyo/editar-gastos.png') }}" style="width: 100%;">
        </div>
    </div>
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
<!-- validaciones del frontend-->
<script src="{{ asset('js/validation.js') }}"></script>
@stop