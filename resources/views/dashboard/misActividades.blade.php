@extends('layouts.dashPanel')

@section('title', 'Dashboard')

@section('content')
  Usuario:: {{$usuario->nombre}}
  <div class="row">

      @foreach($actividades as $key => $actividad)
      <div class="col">
        <div class="card border-light mb-3" style="max-width: 18rem;">
          <div class="card-header">{{ $actividad->fecha_fin_esperada }}</div>
          <div class="card-body">
            <h5 class="card-title">{{ $actividad->nombre }}</h5>
            <p class="card-text">Metas</p>
            <p class="card-text">Avance</p>
            <p class="card-text">Administrar</p>
          </div>
        </div>
      </div>
      @endforeach

  </div>


@stop

@section('scripts')
@stop
