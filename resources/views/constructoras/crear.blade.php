@extends('adminlte::page')

@section('title', 'Ludeño|Constructora')

@section('content_header')
<div class="card bg-dark text-white">
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
        <div class="col-xl-6">

            <div class="card shadow">
                <div class="card-body bg-light p-0">
                    <div class="card-title bg-dark text-white p-3 m-0 w-100">
                        <p class="mb-0" style="font-weight: bold;">Crear Registro</p>
                    </div>
                    <div class="card-text p-3">
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
                                <div class="form-group">
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
                                    <input class="form-control" type="number" name="Costo" min="0" max="100000" step="0.01" pattern="\d+(\.\d{2})?" placeholder="Bs." required>
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
        <div class="col-xl-6 d-none d-xl-block">
            <img src="{{ asset('imagenesApoyo/crear-constructora.png') }}" style="width: 100%;">
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
<!-- validaciones del frontend-->
<script src="{{ asset('js/validation.js') }}"></script>
@stop