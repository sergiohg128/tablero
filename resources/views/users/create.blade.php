@extends('layouts.main')

@section('sidebar_page_usuarios', 'active')

@section('content')

{{ Form::open(['action'=>['UserController@store'], 'method'=>'POST'])}}
  <div class="box box-primary">
    <div class="box-header with-border">
      <i class="fa fa-user-plus"></i>
      <h3 class="box-title">Usuario</h3>
    </div>

    <div class="box-body">
      <div class="row">
        <div class="col col-sm-12">
          @include('partials.myAlertErrors')
        </div>
        <div class="col col-sm-12 col-md-6">
          {{ Form::hidden('id', 0, ['id'=>'id']) }}
          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="nombres" ><div style="width:16px">N</div></label>
              {{ Form::text('nombres', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre']) }}
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="paterno"><div style="width:16px">P</div></label>
              {{ Form::text('paterno', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Apellido paterno']) }}
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="materno"><div style="width:16px">M</div></label>
              {{ Form::text('materno', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Apellido materno']) }}
            </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="correo2"><div style="width:16px">@</div></label>
              {{ Form::email('correo2', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Correo Institucional']) }}
            </div>
          </div>
          
          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="correo"><div style="width:16px">@</div></label>
              {{ Form::email('correo', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Correo Personal']) }}
            </div>
          </div>

          
        </div>

        <div class="col col-sm-12 col-md-6">
          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="telefono"><i style="width:16px"class="fa fa-phone"></i></label>
              {{ Form::text('telefono', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Telefono']) }}
            </div>
          </div>
          
          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="cuenta"><i style="width:16px" class="fa fa-user"></i></label>
              {{ Form::text('cuenta', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Cuenta']) }}
            </div>
          </div>

          <div class="form-group">
            <?php
              $opciones = array();
              foreach($oficinas as $oficina){
                $opciones[$oficina['id']] = $oficina['nombre'];
              }
             ?>
           <div class="input-group">
             <label class="input-group-addon" for="password"><i class="fa fa-institution"></i></label>
             {{ Form::select('oficina_id',$opciones,null,['class'=>'form-control form-control-sm', 'placeholder'=>'Seleccione una oficina']) }}
           </div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <label class="input-group-addon" for="cargo"><i style="width:16px"class="fa fa-user"></i></label>
              {{ Form::text('cargo', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Cargo']) }}
            </div>
          </div>

          <div class="form-group">
            <div class="form-check">
              {!!Form::checkbox('jefe', null ,false, ['class'=>'form-check-input form-check-input-sm', 'id'=>'jefe', 'disabled'])!!}
              <label for="jefe" class="form-check-label">Jefe de oficina</label>
            </div>
          </div>
        </div>
      </div>





    </div>

    <div class="box-footer">
      <div class="text-right">
        {{ link_to('users','Cancelar',['class'=>'btn btn-sm btn-flat btn-default']) }}
        {{ Form::submit('Crear', ['class'=>'btn btn-sm btn-info btn-flat']) }}
      </div>
    </div>
  </div>


{!! Form::close() !!}
@endsection

@section('script')
  <script src="{{ url('js/comun.js') }}"></script>
  <script src="{{ url('js/user.js') }}"></script>
@endsection
