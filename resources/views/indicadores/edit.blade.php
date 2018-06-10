@extends('layouts.main')

@section('sidebar_page_indicadores', 'active')

@section('content')

{{ Form::model($indicador,['action'=>['IndicadorController@update',$indicador->id], 'method'=>'PUT']) }}

  <div class="box box-primary">
    <div class="box-header with-border">
      <i class="fa fa-gears"></i>
      <h3 class="box-title">Indicador</h3>
    </div>

    <div class="box-body">
      <div class="row">
        <div class="col col-sm-12">
          @include('partials.myAlertErrors')
        </div>
        <div class="col col-sm-12 col-md-6">
          {{ Form::hidden('id', null, ['id'=>'id']) }}

          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="nombre" ><div style="width:16px">N</div></label>
              {{ Form::text('nombre', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre']) }}
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="anio"><i style="width:16px"class="fa fa-calendar"></i></label>
              {{ Form::number('anio', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Año']) }}
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="valor"><div style="width:16px">N</div></label>
              {{ Form::number('valor', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Valor']) }}
            </div>
          </div>
        </div>

        <div class="col col-sm-12 col-md-6">

          <div class="form-group">
            <?php
              $opciones = array();
              foreach($oficinas as $oficina){
                $opciones[$oficina['id']] = $oficina['nombre'];
              }
             ?>
             <div class="input-group">
               <label class="input-group-addon" for="oficina_id"><i class="fa fa-institution"></i></label>
               {{ Form::select('oficina_id',$opciones,null,['class'=>'form-control form-control-sm', 'placeholder'=>'Seleccione una oficina']) }}
             </div>
          </div>

          <div class="form-group">
            <div class="input-group">
               <label class="input-group-addon" for="tipo"><i class="fa fa-binoculars"></i></label>
               {{ Form::select('tipo',array('1'=>'Conteo','2'=>'Promedio'),null,['class'=>'form-control form-control-sm', 'placeholder'=>'Tipo']) }}
             </div>
          </div>

        </div>
      </div>
    </div>

    <div class="box-footer">
      <div class="text-right">
        {{ link_to('indicadores','Cancelar',['class'=>'btn btn-sm btn-default btn-flat']) }}
        {{ Form::submit('Crear', ['class'=>'btn btn-sm btn-success btn-flat']) }}
      </div>
    </div>
  </div>
{!! Form::close() !!}

@endsection

@section('script')
  <script src="{{ url('js/comun.js') }}"></script>
  <script src="{{ url('js/user.js') }}"></script>
@endsection









{!! Form::close() !!}
