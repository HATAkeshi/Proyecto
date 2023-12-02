@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="cotainer">
  <button class="btn btn-primary">boton</button>
</div>
<p>Welcome to this beautiful admin panel.</p>
<table class="table">
  <div class="container">
    <form>
      <div class="mb-3 row">
        <label for="inputName" class="col-4 col-form-label">Name</label>
        <div class="col-8">
          <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name">
        </div>
      </div>
      <fieldset class="mb-3 row">
        <legend class="col-form-legend col-4">Group name</legend>
        <div class="col-8">
          you can use radio and checkboxes here
        </div>
      </fieldset>
      <div class="mb-3 row">
        <div class="offset-sm-4 col-sm-8">
          <button type="submit" class="btn btn-primary">Action</button>
        </div>
      </div>
    </form>
  </div>
  @stop

  @section('css')
  <link rel="stylesheet" href="/css/admin_custom.css">
  @stop

  @section('js')
  <script>
    console.log('Hola');
  </script>
  @stop
