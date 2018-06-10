@extends('layouts.dashPanel')

@section('content')

{{ Form::model($actividad, ['action'=>['ActividadController@update', $actividad->id], 'method'=>'PUT']) }}

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="actividad-tab" data-toggle="tab" href="#div-actividad" role="tab" aria-controls="home" aria-selected="true">Actividad</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="responsable-tab" data-toggle="tab" href="#div-responsable" role="tab" aria-controls="profile" aria-selected="false">Responsable</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="documento-tab" data-toggle="tab" href="#div-documento" role="tab" aria-controls="contact" aria-selected="false">Documento</a>
  </li>
  <div class="d-flex flex-row-reverse">
  <li class="mt-1">

      {{ link_to('actividades/','volver', ['class'=>'btn btn-sm btn-info ml-5']) }}
      {{ Form::submit('Update', ['class'=>'btn btn-sm btn-success float-right ml-1']) }}
  </li>
  </div>

</ul>
<div class="tab-content" id="myTabContent">

  <div class="tab-pane fade show active pt-3  " id="div-actividad" role="tabpanel" aria-labelledby="actividad-tab">
    <div class="row">
      <div class="col-12">
        {{ Form::hidden('id',null, ['id'=>'id']) }}
        <div class="form-group">
          {!! Form::label('nombre', 'Nombre', ['class'=>'control-label control-label-sm']) !!}
          {!!Form::text('nombre', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre'])!!}
        </div>
        <div class="form-group">
          {!! Form::label('presupuesto', 'Presupuesto', ['class'=>'control-label control-label-sm']) !!}
          {!!Form::text('presupuesto', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'presupuesto'])!!}
        </div>
      </div>
      <div class="col col-sm-6">
        <div class="form-group">
          {!! Form::label('fecha_inicio', 'Fecha de inicio', ['class'=>'control-label control-label-sm']) !!}
          {!! Form::date('fecha_inicio',null, ['class'=>'form-control form-control-sm']) !!}
        </div>
      </div>
      <div class="col col-sm-6">
        <div class="form-group">
          {!! Form::label('fecha_fin_esperada', 'Fecha final esperada', ['class'=>'control-label control-label-sm']) !!}
          {!! Form::date('fecha_fin_esperada',null, ['class'=>'form-control form-control-sm']) !!}
        </div>
      </div>
    </div>

  </div>

  <div class="tab-pane fade pt-3" id="div-responsable" role="tabpanel" aria-labelledby="responsable-tab">
    <div class="row">
      <div class="col col-sm-6">
        <div class="form-row">
          <?php
            $oficinas_options[0] = 'todas';
            foreach ($oficinas as $key => $oficina) {
              $oficinas_options[$oficina->id] = $oficina->nombre;
            }
           ?>
          <div class="col col-sm-3">
            {{ Form::select('search_by_oficinas',$oficinas_options, '0', ['class'=>'form-control', 'id'=>'search_by_oficinas'])}}
          </div>

          <div class="col col-sm-9">
            {{ Form::text('search_word', null, ['class'=>'form-control', 'placeholder'=>'buscar', 'id'=>'search_word']) }}
          </div>
        </div>
        <div class="row">
          <div class="col col-sm-12 ">
              <table class="table table-sm table-hover">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Resultados</th>
                    <th><a href="javascript: seleccionar_varios(0)" class="btn btn-sm btn-secondary"><span id="span_0" class="icon-plus"></span></a></th>
                  </tr>
                </thead>
                <tbody id="search_results">

                </tbody>
              </table>
          </div>
        </div>



      </div>
      <div class="col col-sm-6">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th>N</th>
              <th>Nombre</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="responsables_selected">

          </tbody>
        </table>
        <div id="div_asignados">

        </div>
      </div>
    </div>
  </div>

  <div class="tab-pane fade pt-3" id="div-documento" role="tabpanel" aria-labelledby="documento-tab">
    <div class="row">
      <div class="col col-sm-6">
        <div class="input-group input-group-sm mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text "> N</span>
          </div>
          {!!Form::text('numero_resolucion', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Numero de resolucion'])!!}
        </div>

        <div class="input-group input-group-sm mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text icon icon-calendar"></span>
          </div>
          {!! Form::date('fecha_resolucion',null, ['class'=>'form-control form-control-sm']) !!}
        </div>
      </div>
      <div class="col col-sm-6">
        <div class="input-group input-group-sm mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text "> N</span>
          </div>
          {!! Form::text('numero_acta', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Numero de acta'])!!}
        </div>
        <div class="input-group input-group-sm mb-3">
          <div class="valid-feedback">
            Fecha
          </div>
          <div class="input-group-prepend">
            <span class="input-group-text icon icon-calendar"></span>
          </div>
          {!! Form::date('fecha_acta',null, ['class'=>'form-control form-control-sm']) !!}
        </div>
        <div class="form-group mb-0">
          {!! Form::textarea('descripcion_acta', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'descripcion acta', 'rows'=>'8'])!!}
        </div>
      </div>
    </div>
  </div>
</div>
{{Form::close() }}

@stop

@section('scripts')
  <script type="text/javascript" src="{{url('js/actividad.js')}}"></script>
@stop
