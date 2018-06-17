@extends('layouts.main')

@section('sidebar-page-actividades', 'active treeview')
@section('sidebar-page-actividades-creaciones', 'active')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ url('css/jquery.cleditor.css') }}"/>
<script src="{{ url('js/jquery-2.1.4.js') }}"></script>
<script src="{{ url('js/jquery.cleditor.min.js') }}"></script>
<script src="{{ url('js/jquery.cleditor-table.min.js') }}"></script>
{{ Form::model($actividad, ['action'=>['ActividadController@informacioneditar', $actividad->id], 'method'=>'PUT']) }}
	{{ Form::hidden('id', null, ['id'=>'id']) }}
  <div class="box box-primary">
    <div class="box-header with-border">
      <i class="text-primary fa fa-gear"></i>
      <h3 class="box-title">Actividad</h3>
    </div>

    <div class="box-body">
      <div class="row">
        <div class="col col-sm-12">
          @include('partials.myAlertErrors')
        </div>

        <div class="col col-sm-12">
          
          <div class="form-group">
            {!!Form::textarea('informacion', null)!!}
          </div>
        </div>
      </div>

    </div>
    <div class="box-footer">
      <div class="text-right">
        <a href="{{ url('actividades/creaciones') }}" class="btn btn-sm btn-flat btn-default">Cancelar</a>
        <button type="submit" class="btn btn-sm btn-success btn-flat">Editar</button>
      </div>
    </div>
  </div>
{!! Form::close() !!}
<script>
	  
    $("textarea").cleditor(
      {
        height: 500,
        styles:     [["Párrafo", "<p>"], ["Encabezado 1", "<h1>"], ["Encabezado 2", "<h2>"],
                    ["Encabezado 3", "<h3>"],  ["Encabezado 4","<h4>"],  ["Encabezado 5","<h5>"],
                    ["Encabezado 6","<h6>"]],
      }).focus();
        
</script>
@endsection
