@extends('layouts.main')

@section('sidebar-page-reportes', 'active')

@section('content')


<div class="row">
  <div class="col col-sm-12">
    <div class="box">
      <div class="box-header with-border">
        <div class="box-title">
          REPORTE POR OFICINA
        </div>
        <div class="box-tools"></div>
      </div>
      <div class="box-body">
        <div class="row">
        	<div class="col col-sm-12">
          <?php
            $oficinas = \App\Oficina::all();
            if(Auth::user()->tipo=="admin"){
              $oficinas_options[0] = 'Todas';
            }
            foreach ($oficinas as $key => $oficina) {
              if(Auth::user()->tipo=="admin"){
                $oficinas_options[$oficina->id] = $oficina->nombre;
              }else{
                if($oficina->id==Auth::user()->oficina_id){
                  $oficinas_options[$oficina->id] = $oficina->nombre;
                  break;
                }
              }
            }
           ?>


              {!! Form::open(['route' => 'reportes.generar','method'=>'POST','target'=>'_blank']) !!} 
                <div class="col col-sm-12">
                  <label for="oficinas">Oficinas</label>
                	<div class="input-group input-group-sm">
	                  <div class="input-group-btn">
	                    <span class="btn btn-default"><i class="fa fa-institution"></i></span>
	                  </div>
                    {{ Form::select('oficina',$oficinas_options, 0, ['class'=>'form-control'])}} 
	                </div>
                </div>
	                
                <div class="col col-sm-6">
                	<div class="form-group">
		              {{ Form::label('fecha_inicio', 'Desde') }}
		              <div class="input-group">
		                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                {{ Form::date('fecha_inicio', null, ['class'=>'form-control form-control-sm']) }}
		              </div>
		            </div>
                </div>

                <div class="col col-sm-6">
                	<div class="form-group">
		              {{ Form::label('fecha_fin', 'Hasta') }}
		              <div class="input-group">
		                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                {{ Form::date('fecha_fin', null, ['class'=>'form-control form-control-sm']) }}
		              </div>
		            </div>
                </div>

                <div class="col col-sm-12">
                  <label for="estado">Estado</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-btn">
                      <span class="btn btn-default"><i class="fa fa-institution"></i></span>
                    </div>
                    <select name="estado" class="form-control form-control-sm">
                      <option value="Todos">Todos</option>
                      <option value="Pendiente">Pendiente</option>
                      <option value="En proceso">En proceso</option>
                      <option value="Finalizado">Finalizado</option>
                    </select>
                  </div>
                </div>

	                <div class="col col-sm-12">
                    <br>
                    <button type="submit" class="btn btn-sm btn-primary btn-flat">Generar</button> 
                  </div>
	            
              {!! Form::close() !!}
            </div>
        </div>
      </div>
    </div>

    <div class="box">
      <div class="box-header with-border">
        <div class="box-title">
          REPORTE POR ACTIVIDAD
        </div>
        <div class="box-tools"></div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col col-sm-12">
          <?php
            
            if(Auth::user()->tipo=="admin"){
              $actividades = \App\Actividad::all()->sortBy("id");
            }else{
              $actividades = \App\Actividad::select("actividades.*")->join("users","actividades.creador_id","=","users.id")->where("users.oficina_id",Auth::user()->oficina_id)->orderBy("id")->get();
            }

            foreach ($actividades as $key => $actividad) {
                $actividades_options[$actividad->id] = $actividad->id.' - '.$actividad->nombre;
            }
           ?>


              {!! Form::open(['route' => 'reportes.generar2','method'=>'POST','target'=>'_blank']) !!} 
                <div class="col col-sm-12">
                  <label for="actividad">Actividades</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-btn">
                      <span class="btn btn-default"><i class="fa fa-institution"></i></span>
                    </div>
                    {{ Form::select('actividad',$actividades_options, 0, ['class'=>'form-control'])}} 
                  </div>
                </div>

                <div class="col col-sm-12">
                  <label for="metas">¿Ver Detalle de Metas?</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-btn">
                      <span class="btn btn-default"><i class="fa fa-institution"></i></span>
                    </div>
                    <select name="detalle" class="form-control">
                      <option value="N">No</option>
                      <option value="S">Sí</option>
                    </select>
                  </div>
                </div>
                  
                <div class="col col-sm-12">
                  <br>
                  <button type="submit" class="btn btn-sm btn-primary btn-flat">Generar</button> 
                </div>
              
              {!! Form::close() !!}
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
  
  <script src="{{ url('js/comun.js') }}"></script>
  <script src="{{ url('js/custom_datatable.js') }}"></script>
  
@endsection
