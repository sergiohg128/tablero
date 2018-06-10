@extends('layouts.dashPanel')

@section('title', 'Perfil')

@section('content')
<?php
//para manejar las vistas del nav y nav-content
$nav_info = '';
$nav_editar = '';
$nav_foto = '';
$tap_info = '';
$tap_editar = '';
$tap_foto = '';

if(count($errors)>0 || Session::has('error') ){
  $nav_editar = 'active';
  $tap_editar = 'show active';
}else{
  $nav_info = 'active';
  $tap_info = 'show active';
}

?>

  <div class="row">
    <div class="col col-sm-12 col-md-4 mt-5 pl-5">
      <div class="text-center mb-3">
        <?php $url = url('storage/'.$user->foto); ?>

        <img src="{{$url}}" alt="" width="200px" height="200px" class="rounded-circle">
      </div>
      <div class="">
        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
          <a class="nav-link {{$nav_info}}" data-toggle="pill" href="#user-info" role="tab">Info</a>
          <a class="nav-link {{$nav_editar}}" data-toggle="pill" href="#user-editar" role="tab">Editar</a>
          <a class="nav-link {{$nav_foto}}" data-toggle="pill" href="#user-foto" role="tab">Foto</a>
        </div>
      </div>

    </div>
    <div class="col col-sm-12 col-md-8 mt-5 pr-5 pl-5">

      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade {{$tap_info}}" id="user-info" role="tabpanel">
          <div class="form-group">
            <label for="">Cuenta</label>
            <br>{{ $user->cuenta }}<hr>
          </div>
          <div class="form-group">
            <label for="">Nombre</label>
            <br>{{ $user->nombres}}<hr>
          </div>
          <div class="form-group">
            <label for="">Apellidos</label>
            <br>{{ $user->paterno." ". $user->materno }}<hr>
          </div>
          <div class="form-group">
            <label for="">Oficina</label>
            <br>{{ $oficina->nombre }}<hr>
          </div>
          <div class="form-group">
            <label for="">Jefe de Area</label>
            <br>{{ $user->jefe }}<hr>
          </div>
        </div>
        <div class="tab-pane fade {{$tap_editar}}" id="user-editar" role="tabpanel">
          @include('partials.myMessage')
          @if(Session::has('error'))
          <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
          </div>
          @endif
          {{ Form::model($user, ['action'=>['PerfilController@update', 'id'=>$user->id], 'method'=>'PUT'])}}
            <div class="form-group">
              {{ Form::label('cuenta','Cuenta') }}
              {{ Form::text('cuenta',null, ['class'=>'form-control']) }}
            </div>
            <div class="form-group">
              {{ Form::label('nombre','Nombres') }}
              {{ Form::text('nombres',null, ['class'=>'form-control']) }}
            </div>
            <div class="form-group">
              {{ Form::label('paterno','Apellidos') }}
              <div class="row">
                <div class="col">
                  {{ Form::text('paterno', null, ['class'=>'form-control', 'placeholder'=>'paterno']) }}
                </div>
                <div class="col">
                  {{ Form::text('materno',null, ['class'=>'form-control', 'placeholder'=>'materno']) }}
                </div>
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('clave','Contraseña') }}
              <div class="row">
                <div class="col">
                  {{ Form::password('password',['class'=>'form-control', 'placeholder'=>'actual']) }}
                </div>
                <div class="col">
                  {{ Form::password('password_new',['class'=>'form-control', 'placeholder'=>'nueva']) }}
                </div>
              </div>
            </div>
            {{ Form::submit('Editar', ['class'=>'btn btn-primary']) }}
          {{ Form::close() }}
        </div>
        <div class="tab-pane fade {{$tap_foto}}" id="user-foto" role="tabpanel">

          {{ Form::open(['url'=>['file/uploadPhoto', $user->id], 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}

              <div class="jumbotron">
                <div class="row">
                  <div class="col">
                    <div class="text-center">
                      <div class="btn btn-outline-info">
                        <label for="files" class="pt-2 mb-0" >
                          <h3><span class="icon-camera mr-1"></span>Archivo</h3>
                        </label>
                        <input type="file" id="files" name="files[]" style="display:none">
                      </div>
                      <hr>
                      <button class="btn btn-outline-danger" type="submit">
                        <h3>
                          <span class="icon-upload mr-2"></span>Subir
                        </h3>
                      </button>
                    </div>

                  </div>
                  <div class="col">
                    <style>
                      .thumb {
                        height: 200px;
                        width: 200px;
                        border: 1px solid #000;
                        margin: 0px 5px 0 0;
                      }
                    </style>
                    <output id="list"></output>
                  </div>
                </div>
              </div>


<html>
      <head>

    </head>
    <body>


          {{ Form::close()}}
        </div>
      </div>


    </div>
  </div>
@stop

@section('scripts')
<script type="text/javascript" src="{{url('js/inputFile.js')}}"></script>
@stop
