{!! Form::open(['route' => 'monitoreo.store']) !!}
{!! Form::hidden('meta_id', $meta->id) !!}
<div class="form-group">
	<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			{!! Form::date('fecha', null, ['class'=>'form-control form-control-sm', 'placeholder' => 'Fecha']) !!}
		</div>
	</div>
</div>
<div class="form-group">
	{!! Form::label('descripcion', 'Descripción', ['class'=>'control-label control-label-sm']) !!}
	{!! Form::textarea('descripcion', null, ['class'=>'form-control', 'placeholder'=>'Descripción', 'rows'=>'3']) !!}
</div>
<div class="form-group">
	{!! Form::label('observacion', 'Observación', ['class'=>'control-label control-label-sm']) !!}
	{!! Form::textarea('observacion', null, ['class'=>'form-control', 'placeholder'=>'Observación', 'rows'=>'5']) !!}
</div>
<div class="form-group pt-4">
	<button class="btn btn-md btn-info" type="submit"><i class="fa fa-plus"></i> Crear</button>
	<a href="{{route('monitoreo.create', $meta->id)}}" class="btn btn-md btn-default"><i class="fa fa-times"></i> Cancelar</a>
</div>
{!! Form::close() !!}