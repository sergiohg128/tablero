@extends('layouts.perfil')

@section('content2')
@include('partials.myAlertErrors')
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Imagen</h3>
  </div>
  <div class="box-body">
    {{ Form::open(['action'=>['PerfilController@postImagen'], 'method'=>'POST', 'enctype'=>'multipart/form-data']) }}
          <div class="row">
            <div class="col-sm-6">

              <div class="text-center">
                  <div class="small-box bg-green">
                    <div class="inner">
                      Sube una foto de perfil, esto servirá para que puedas reconocer y seleccionar
                      mejor a tus compañeros para trabajar juntos en las actividades.
                    </div>
                  </div>
              </div>

              <div class="text-center">
                <label for="files" class="btn btn-app">
                    <i class="fa fa-file-image-o"></i> Foto
                </label>
                <input type="file" id="files" name="files[]" style="display:none">
                <button class="btn btn-app" type="submit">
                  <i class="fa fa-save"></i> Subir
                </button>
              </div>
            </div>
            <div class="col-sm-6">

              <style>
                .thumb {
                  height: 200px;
                  width: 200px;
                  border: 1px solid #000;
                  margin: 0px 5px 0 0;
                }
              </style>
              <div class="text-center">
                <output id="list">
                  <img src="{{ url('images/user_default.png') }}"  width="200px" height="200px" alt="">
                </output>
              </div>

            </div>
          </div>
    {{ Form::close()}}
  </div>
  <!-- /.box-body -->
</div>
@endsection

@section('script')
  <script type="text/javascript" src="{{url('js/inputFile.js')}}"></script>
@endsection
