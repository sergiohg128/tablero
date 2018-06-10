@php 
//$gasto->fecha = date("d-m-Y", strtotime($gasto->fecha));
@endphp
Gasto: 
{!! Form::model($gasto, ['route' => ['gastos.update', $gasto->id], 'method' => 'PUT']) !!}
{!! Form::hidden('meta_id', $gasto->meta->id) !!}
<div class="form-group">
	{!! Form::select('tipo', ['B' => 'Bien', 'S' => 'Servicio'], null, ['class'=>'form-control form-control-sm', 'placeholder' => 'Elige un tipo de gasto...']) !!}
</div>
<div class="form-group">
	{!! Form::text('descripcion', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Detalle'])!!}
</div>
<div class="form-group">
	<div class="input-group">
		<div class="input-group-addon">S/.</div>
		{!!Form::text('monto', null, ['class'=>'form-control', 'placeholder'=>'Importe'])!!}
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
		{!! Form::date('fecha', null, ['class'=>'form-control form-control-sm', 'placeholder' => 'Fecha']) !!}
	</div>
</div>
Documento:
<div class="form-group">
	{!! Form::select('tipo_documento_id', $documentos, null, ['class'=>'form-control form-control-sm', 'placeholder' => 'Elige un tipo de documento...']) !!}
</div>
<div class="form-group">
	<div class="input-group">
		<div class="input-group-addon">N° </div>
		{!!Form::text('numero', null, ['class'=>'form-control', 'placeholder'=>'Número de documento'])!!}
	</div>
</div>
<div class="form-group pt-4">
	<button class="btn btn-md btn-info" type="submit"><i class="fa fa-save"></i> Guardar</button>
	<a href="{{route('gastos.create', $meta->id)}}" class="btn btn-md btn-default"><i class="fa fa-times"></i> Cancelar</a>
</div>
{!! Form::close() !!}