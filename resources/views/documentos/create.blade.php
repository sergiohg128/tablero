{{ Form::open(['action'=>['DocumentoController@store'],'method'=>'POST'])}}
  <div class="form-group">
    {{ Form::label('nombre', 'Documento') }}
    {{ Form::text('nombre', null, ['class'=>'form-control']) }}
  </div>
  {{ Form::submit('Crear', ['class'=>'btn btn-info']) }}
{{ Form::close() }}
