{{ Form::open(['action'=>['RequisitoController@store'], 'method'=>'POST'])}}
  {{ Form::hidden('id', 0, ['id'=>'id']) }}
  {{ Form::hidden('meta_id', $meta->id)}}

  <div class="form-group">
    {{ Form::label('nombre', 'Nombre', ['class'=>'control-label']) }}
    {{ Form::text('nombre', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre']) }}
  </div>

  <div class="form-group">
    {{ Form::label('observacion', 'Observacion', ['class'=>'control-label']) }}
    {{ Form::textarea('observacion', null, ['class'=>'form-control', 'rows'=>'5', 'placeholder'=>'Observacion']) }}
  </div>

  <div class="text-right">
    <a href="{{ url('metas/'.$meta->id.'/requisitos/create') }} " class="btn btn-default btn-flat">Cancelar</a>
    <button type="submit" class="btn btn-primary btn-flat">Crear</button>
  </div>

{{ Form::close()}}
