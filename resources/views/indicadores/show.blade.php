@extends('layouts.main')

@section('sidebar-page-indicadores', 'active treeview')

@section('content')
<div class="row">
  <div class="col col-sm-12">
    <div class="box">
      <div class="box-header with-border">
        <div class="box-title">
          Todas las Actividades | Meta : {{$indicador->valor}} @if($indicador->tipo=='2') % @endif
        </div>
        <div class="progress" style="margin:0">
            <div class="progress-bar progress-bar-striped  @if($indicador->porcentaje()>=$indicador->valor) avance-green @else avance-yellow @endif" role="progressbar" style="width: @if($indicador->porcentaje()>100) 100% @else {{$indicador->porcentaje()}}% @endif" aria-valuenow="{{$indicador->porcentaje()}}" aria-valuemin="0" aria-valuemax="100">{{round($indicador->porcentaje(),2)}}%</div>
          </div>
        <div class="box-tools"></div>
      </div>
      <div class="box-body table-responsive">
        <table class="table custom_datatable table-hover">
          <thead>
            <tr>
              <th>N°</th>
              <th>Nombre</th>
              <th>Fecha</th>
              <th>Presupuesto</th>
              <th>Creador</th>
              <th>Oficina</th>
              <th>Estado</th>
              <th>Tiempo</th>
              @if($indicador->tipo=='2')
              	<th>Valor</th>
              @endif
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php $num=0;
            ?>

            @foreach($actividades as $key => $actividad)
            <?php $num++; ?>
            <?php
                $meta_success=false;//para pintar fila si la meta esta cumplida
                $metas = count($actividad->metas) ;
                $metasCumplidas = count($actividad->metas->where('estado', 'F'));
                $imprimirfila = "";
                $estilofila = "x";
                if($metas==0){
                  $imprimirfila = '<span class="label label-warning"><i class="fa fa-clock-o"></i> Pendiente</span>';
                }elseif($metas==$metasCumplidas){
                  $meta_success=true;
                  $imprimirfila = '<span class="label label-success"><i class="fa fa-trophy"></i> Finalizado</span>';
                }else{
                  $imprimirfila = '<span class="label label-info"><i class="fa fa-circle-o-notch"></i> En proceso</span>';
                }
            ?>
            <tr class="{{ $meta_success?'success':''}}">
              <td>{{$actividad->id}}</td>
              <td>{{$actividad->nombre}}</td>
              <td>{{date("d-m-Y", strtotime($actividad->fecha_inicio))}}</td>
              <td>{{$actividad->presupuesto}}</td>
              <td>{{$actividad->creador->completo()}}</td>
              <td>{{$actividad->creador->oficina->nombre}}</td>
              <td>
              <?php
                 echo $imprimirfila;
              ?>
              </td>

              <td>
                <div class="col col-sm-12">
                    <div class="progress" style="margin:0;min-width:50px;">
                      <div class="progress-bar progress-bar-striped @if($actividad->porcentaje()<70) avance-green @elseif($actividad->porcentaje()<100) avance-yellow @else avance-red @endif" role="progressbar" style="width:{{$actividad->porcentaje()}}%" aria-valuenow="{{$actividad->porcentaje()}}" aria-valuemin="0" aria-valuemax="100">{{$actividad->porcentaje()}}%</div>
                    </div>
                  </div>
              </td>
              @if(Auth::user()->tipo=='admin')
	              <td>
	              	@if($indicador->tipo=='2')
	              		@if($meta_success)
	              			{{ Form::model($actividad, ['action'=>['ActividadController@valor', $actividad->id], 'method'=>'PUT']) }}
	              				<input type="hidden" name="id" value="{{$actividad->id}}">
			                  <input type="number" name="indicador_valor" value="{{$actividad->indicador_valor}}" min="0" @if($indicador->tipo=='2') max="100" @endif style="width: 50px;">
			                  <button type="submit" class="btn btn-xs btn-flat btn-success"><i class="fa fa-pencil"></i></button>
			                {{ Form::close()}}
	              		@endif
	              	@endif
	              </td>
	          @else
	          	<td>
	          		@if($actividad->indicador_valor>0) {{$actividad->indicador_valor}} @else 0 @endif @if($indicador->tipo=='2') % @endif
	          	</td>
              @endif
              <td>
                <a href="{{ url('actividades/'.$actividad->id) }}" class="btn btn-xs btn-flat btn-warning"><i class="fa fa-eye"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection

@section('script')
  <script src="{{ url('js/comun.js') }}"></script>
  <script src="{{ url('js/custom_datatable.js') }}"></script>
  <script>
    noSortableTable(0, [6]);
  </script>
@endsection
