{{ Form::model($requisito, ['action'=>['RequisitoController@update', $requisito->id], 'method'=>'PUT'])}}
  {{ Form::hidden('id', 0, ['id'=>'id']) }}
  {{ Form::hidden('meta_id', $meta->id)}}

  <div class="form-group">
    {{ Form::label('estadso', 'Estado', ['class'=>'control-label']) }}

    <?php
      $opciones[0] = 'En proceso';
      $opciones[1] = 'Completado';
     ?>
    {!! Form::select('estado',$opciones,null,['class'=>'form-control', 'placeholder'=>'Seleccione una oficina']) !!}
  </div>

  <div class="form-group">
    {{ Form::label('nombre', 'Nombre', ['class'=>'control-label']) }}
    {{ Form::text('nombre', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre de la oficina']) }}
  </div>

  <div class="form-group">
    {{ Form::label('nombre', 'Nombre', ['class'=>'control-label']) }}
    {{ Form::textarea('observacion', null, ['class'=>'form-control', 'rows'=>'5', 'placeholder'=>'Observacion']) }}
  </div>

  <div class="text-right">
    <a href="{{ url('metas/'.$requisito->meta->id.'/requisitos/create') }} " class="btn btn-default btn-flat">Cancelar</a>
    <button type="submit" class="btn btn-success btn-flat">Editar</button>
  </div>

{{ Form::close()}}
