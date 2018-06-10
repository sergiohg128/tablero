@php
	$meta->fecha_fin = !is_null($meta->fecha_fin) ? date("d-m-Y", strtotime($meta->fecha_fin)) : null;
	$meta->fecha_inicio = !is_null($meta->fecha_inicio) ? date("d-m-Y", strtotime($meta->fecha_inicio)) : null;
@endphp
{!! Form::model($meta, ['route' => ['metas.update', $meta->id], 'method' => 'PUT']) !!} 
	{!! Form::hidden('actividad_id', $meta->actividad->id) !!}
	<div class="form-group">
		{!! Form::label('nombre', 'Nombre', ['class'=>'control-label control-label-sm']) !!} {!! Form::text('nombre', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Nombre'])!!}
	</div>
	<div class="form-group">
		{!! Form::label('producto', 'Producto', ['class'=>'control-label control-label-sm']) !!} {!!Form::text('producto', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Producto'])!!}
	</div>
	<div class="form-group">
		{!! Form::label('presupuesto', 'Presupuesto', ['class'=>'control-label control-label-sm']) !!}
		<div class="input-group">
			<div class="input-group-addon">S/.</div>
			{!!Form::text('presupuesto', null, ['class'=>'form-control', 'placeholder'=>'Presupuesto'])!!}
		</div>
	</div>
	@if ($meta->estado != 'F')
	<div class="form-group">
		{!! Form::label('estado', 'Estado', ['class'=>'control-label control-label-sm']) !!}
		<br>
		@if ($meta->estado == 'P')
		<label style="font-weight:400;">
			Pendiente {!! Form::radio('estado', 'P') !!}
		</label>
		<label style="font-weight:400;">
			{!! Form::radio('estado', 'E' )!!} En Proceso
		</label>	
		@endif
		@if ($meta->estado == 'E')
		<label style="font-weight:400;">
			En Proceso {!! Form::radio('estado', 'E') !!}
		</label>
		<label style="font-weight:400;">
			{!! Form::radio('estado', 'F' )!!} Finalizado
		</label>
		@endif
	</div>
	@endif
	@if ($meta->estado != 'F')
	<div class="form-group">
		@if ($meta->estado == 'P')
		{!! Form::label('fecha_inicio', 'Fecha de Inicio', ['class'=>'control-label control-label-sm']) !!}
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			{!! Form::date('fecha_inicio', null, ['class'=>'form-control form-control-sm']) !!}
		</div>
		@endif
		@if ($meta->estado == 'E')
		{!! Form::hidden('fecha_inicio', date("Y-m-d", strtotime($meta->fecha_inicio))) !!}
		{!! Form::label('fecha_fin', 'Fecha de Fin', ['class'=>'control-label control-label-sm']) !!}
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			{!! Form::date('fecha_fin', null, ['class'=>'form-control form-control-sm']) !!}
		</div>
		@endif
	</div>
	@endif
	<div class="form-group pt-4">
		<button class="btn btn-md btn-info" type="submit"><i class="fa fa-save"></i> Guardar</button>
		<a class="btn btn-md btn-default" href="{{route('metas.create', $meta->actividad->id)}}"><i class="fa fa-times"></i> Cancelar</a>
	</div>
{!! Form::close() !!}