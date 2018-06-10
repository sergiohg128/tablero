@extends('layouts.main')

@section('sidebar-page-actividades', 'active treeview')
@section('sidebar-page-actividades-creaciones', 'active')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ url('css/jquery.cleditor.css') }}"/>
<script src="{{ url('js/jquery-2.1.4.js') }}"></script>
<script src="{{ url('js/jquery.cleditor.min.js') }}"></script>
{{ Form::model($meta, ['action'=>['MetaController@informacioneditar', $meta->id], 'method'=>'PUT']) }}
	{{ Form::hidden('id', null, ['id'=>'id']) }}
  <div class="box box-primary">
    <div class="box-header with-border">
      <i class="text-primary fa fa-gear"></i>
      <h3 class="box-title">Meta</h3>
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
	  
    $("textarea").cleditor({ controls: "source bold italic underline strikethrough subscript superscript | font size | color | bullets numbering | outdent indent | alignleft center alignright justify | undo redo" }).focus();
        
</script>
@endsection
