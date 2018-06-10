@extends('layouts.perfil')

@section('content2')
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Password</h3>
  </div>
  <div class="box-body">
    @include('partials.myAlertErrors')
    @if(Session::has('error_password'))
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Alerta!</strong>
        <ul>
          <li>{{ Session::get('error_password') }}</li>
        </ul>
      </div>
    @endif


    {{ Form::model($user, ['action'=>['PerfilController@postPassword'], 'method'=>'POST']) }}
    {{ Form::hidden('pass_state',1)}}
    <div class="form-horizontal">
      <div class="form-group">
        {{ Form::label('password', 'Contraseña Actual', ['class'=>'col-sm-3 control-label']) }}

        <div class="col-sm-9">
          {{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Ingrese su contraseña actual']) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('password_new', 'Nueva Contraseña', ['class'=>'col-sm-3 control-label']) }}
        <div class="col-sm-9">
          {{ Form::password('password_new', ['class'=>'form-control', 'placeholder'=>'Ingrese su nueva contraseña']) }}
        </div>
      </div>
      <div class="text-right">
        <button type="submit" class="btn btn-sm btn-success btn-flat">Guardar Cambios</button>
      </div>
    </div>
    {{ Form::close() }}


  </div>
  <!-- /.box-body -->
</div>
@endsection

@section('script')

@endsection
