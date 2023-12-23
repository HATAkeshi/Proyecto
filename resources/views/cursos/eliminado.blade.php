@extends('adminlte::page')

@section('title', 'Ludeño|Eliminados')

@section('content_header')
<div class="text-white" style="background-color: #000000;">
  <div class="card-body">
    <h2><i class="fas fa-trash"></i> Eliminados </h2>
  </div>
</div>
@stop

@section('content')
<section class="container-fluid">
  <div class="row">
    <div class="col-xl-12">
      @if($registrosEliminados->isEmpty())
      <div class="row align-items-center">
        <div class="card bg-success">
          <div class="card-body">
            <p style="font-weight: bold;">No hay cursos eliminados c:</p>
          </div>
        </div>
      </div>
      @else
      <table class="table table-hover border-dark mt-2">
        <thead style="background-color: #9A3B3B;" class="text-light">
          <tr>
            <th style="display: none">ID</th>
            <th>Fecha</th>
            <th>Nombre de persona anticipo</th>
            <th>Porcentaje de anticipo</th>
            <th>Nombre de persona pago total</th>
            <th>Detalle de curso</th>
            <th>Numero de comprobante</th>
            <th>Ingresos</th>
            <th>Metodo de pago</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($registrosEliminados as $curso)
          <tr>
            <td style="display: none">{{$curso->id}}</td>
            <td>{{$curso->created_at->format('Y-m-d') }}</td>
            <td>{{$curso->Nombre_de_persona}}</td>
            <td>{{$curso->Porcentaje_de_anticipo}}</td>
            <td>{{$curso->Nombre_de_persona_pago_total}}</td>
            <td>{{$curso->Detalle_de_curso}}</td>
            <td>{{$curso->Numero_de_comprobante}}</td>
            <td>{{$curso->Ingresos}}</td>
            <td>{{$curso->metodo_pago}}</td>
            <td>
              <!-- Botón para restaurar -->
              <form action="{{ route('cursos.restore', $curso->id) }}" method="POST">
                @csrf
                @method('PUT')
                @can('restaurar-eliminados')
                <button type="submit" class="btn text-light" style="background-color: #9A3B3B; font-weight: bold;">
                  <i class="fas fa-undo"></i>
                  Restaurar
                </button>
                @endcan
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
</section>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/tablasResposive.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script>
  console.log('Hola');
</script>
@stop