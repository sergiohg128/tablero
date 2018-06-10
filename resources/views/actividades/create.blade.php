@extends('layouts.main')

@section('sidebar-page-actividades', 'active treeview')
@section('sidebar-page-actividades-creaciones', 'active')


@section('content')

  {{ Form::open(['action'=>['ActividadController@store'], 'method'=>'POST'])}}
    <div class="box box-primary">
      <div class="box-header with-border">
        <i class="text-primary fa fa-plus-square"></i>
        <h3 class="box-title">Actividad</h3>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col col-sm-12">
            @include('partials.myAlertErrors')
          </div>
          <div class="col col-sm-12 col-md-6">
            {{ Form::hidden('id', 0, ['id'=>'id']) }}
            <div class="form-group">
              {{ Form::label('nombre', 'Nombre') }}
              {!!Form::text('nombre', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre de actividad'])!!}
            </div>

            <div class="form-group">
              {{ Form::label('presupuesto', 'Presupuesto') }}
              <div class="input-group">
                <span class="input-group-addon">S/.</span>
                {{ Form::text('presupuesto', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Presupuesto']) }}
              </div>
            </div>

            {{ Form::hidden('fecha_creacion', null)}}
            <div class="form-group">
              {{ Form::label('fecha_inicio', 'Fecha de inicio') }}
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ Form::date('fecha_inicio', \Carbon\Carbon::now(), ['class'=>'form-control form-control-sm']) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('fecha_fin_esperada', 'Fecha final esperada') }}
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ Form::date('fecha_fin_esperada', null, ['class'=>'form-control form-control-sm']) }}
              </div>
            </div>


            <div class="form-group">
              <?php
                  $monitores = \App\User::where('oficina_id', Auth::user()->oficina_id)->get();
                  $opciones = array();
                  foreach($monitores as $user){
                    $opciones[$user->id] = $user->nombres.' '.$user->paterno.' '.$user->materno;
                  }
               ?>
               {{ Form::label('monitor_id', 'Monitor') }}
               <div class="input-group">
                 <span class="input-group-addon"><i class="fa fa-binoculars"></i></span>
                 {{ Form::select('monitor_id', $opciones , Auth::user()->id,['class'=>'form-control form-control-sm', 'placeholder'=>'Seleccione un usuario como monitor']) }}
               </div>

            </div>
          </div>

          <div class="col col-sm-12 col-md-6">
            {{ Form::label('numero_resolucion', 'Resolucion') }}
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">N°</span>
                {{ Form::textarea('numero_resolucion', null, ['class'=>'form-control form-control-sm', 'rows'=> '3','placeholder'=>'Numero de resolucion']) }}
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ Form::date('fecha_resolucion', null, ['class'=>'form-control form-control-sm']) }}
              </div>
            </div>

            {{ Form::label('fecha_acta', 'Acta') }}
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ Form::date('fecha_acta', null, ['class'=>'form-control form-control-sm']) }}
              </div>
            </div>
            <div class="form-group">
              {!!Form::textarea('descripcion_acta', null, ['class'=>'form-control form-control-sm', 'rows'=>'5', 'placeholder'=>'Descripcion de acta'])!!}
            </div>

            <div class="form-group">
              <?php
                  $opciones = array();
                  foreach($indicadores as $indicador){
                    $opciones[$indicador->id] = $indicador->nombre;
                  }
               ?>
               {{ Form::label('indicador_id', 'Indicador') }}
               <div class="input-group">
                 <span class="input-group-addon"><i class="fa fa-binoculars"></i></span>
                 {{ Form::select('indicador_id', $opciones , 0,['class'=>'form-control form-control-sm', 'placeholder'=>'Seleccione un indicador']) }}
               </div>

            </div>
          </div>
        </div>

      </div>
      <div class="box-footer">
        <div class="text-right">
          <a href="{{ url('actividades/creaciones') }}" class="btn btn-sm btn-flat btn-default">Cancelar</a>
          <button type="submit" class="btn btn-sm btn-primary btn-flat">Crear</button>
        </div>
      </div>
    </div>
  {!! Form::close() !!}

@endsection

@section('head_extras')
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script> -->
@endsection
