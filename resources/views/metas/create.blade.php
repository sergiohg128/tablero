{!! Form::open(['route' => 'metas.store']) !!} 
	{!! Form::hidden('actividad_id', $actividad->id) !!}
	<div class="form-group">
		{!! Form::label('nombre', 'Nombre', ['class'=>'control-label control-label-sm']) !!} {!! Form::text('nombre', null, ['class'=>'form-control
		form-control-sm', 'placeholder'=>'Nombre'])!!}
	</div>
	<div class="form-group">
		{!! Form::label('producto', 'Producto', ['class'=>'control-label control-label-sm']) !!} {!!Form::text('producto', null,
		['class'=>'form-control form-control-sm', 'placeholder'=>'Producto'])!!}
	</div>
	<div class="form-group">
		{!! Form::label('presupuesto', 'Presupuesto', ['class'=>'control-label control-label-sm']) !!}
		<div class="input-group">
			<div class="input-group-addon">S/.</div>
			{!!Form::text('presupuesto', null, ['class'=>'form-control', 'placeholder'=>'Presupuesto'])!!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('fecha_inicio_esperada', 'Fecha de inicio esperada') !!}
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span> {!! Form::date('fecha_inicio_esperada', null, ['class'=>'form-control
			form-control-sm']) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('fecha_fin_esperada', 'Fecha final esperada') !!}
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span> {!! Form::date('fecha_fin_esperada', null, ['class'=>'form-control
			form-control-sm']) !!}
		</div>
	</div>
	<div class="form-group pt-4">
		<button class="btn btn-md btn-info" type="submit"><i class="fa fa-plus"></i> Crear</button>
		<a class="btn btn-md btn-default" href="{{route('metas.create', $actividad->id)}}"><i class="fa fa-times"></i> Cancelar</a>
	</div>
{!! Form::close() !!}