{{ Form::open(['action'=>['OficinaController@store'], 'method'=>'POST'])}}
  {{ Form::hidden('id', 0, ['id'=>'id']) }}
  <div class="form-group">
    {{ Form::text('nombre', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre de la oficina']) }}
  </div>
  <div class="form-group">
    <div class="d-flex flex-row-reverse">
      {{ Form::submit('Crear', ['class'=>'btn btn-sm btn-info'])}}
      {{ Link_to('oficinas', 'Cancelar', ['class'=>'btn btn-sm btn-secondary mr-2'])}}
    </div>

  </div>
{{ Form::close()}}
