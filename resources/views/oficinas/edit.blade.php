{{ Form::model($oficina, ['action'=>['OficinaController@update', $oficina->id], 'method'=>'PUT']) }}
  {{ Form::hidden('id', $oficina->id, ['id'=>'id']) }}
  <div class="form-group">
    {{ Form::text('nombre', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre de la oficina'])}}
  </div>
  <div class="d-flex flex-row-reverse">
    {{ Form::submit('Editar', ['class'=>'btn btn-sm btn-success'])}}
    {{ Link_to('oficinas', 'Cancelar', ['class'=>'btn btn-sm btn-secondary mr-2'])}}
  </div>
{{ Form::close()}}
