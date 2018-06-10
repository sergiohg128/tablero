{{ Form::model($documento, ['action'=>['DocumentoController@update', $documento->id],'method'=>'PUT'])}}
  <div class="form-group">
    {{ Form::label('nombre', 'Documento') }}
    {{ Form::text('nombre', null, ['class'=>'form-control']) }}
  </div>
  {{ Form::submit('Editar', ['class'=>'btn btn-info']) }}
{{ Form::close() }}
