@extends('layouts.main')

@section('css')
	<link rel="stylesheet" href="{{ url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
<div class="row">
	<div class="col col-sm-12 col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
					@if (isset($gasto))
					Editar Gasto @else
					Nuevo Gasto @endif
				</div>
			</div>
			<div class="box-body">
				<div class="col-sm-12">
					@include('partials.myAlertErrors') 
					@if (isset($gasto))
					@include('gastos.edit') @else
					@include('gastos.create') @endif
				</div>
			</div>
		</div>
	</div>
	<div class="col col-sm-12 col-md-8">
		<div class="box box-info">
			<div class="box-header with-border">
				<div class="box-title" style="display:block;">
					Gastos
					@if (isset($gasto))
					<a href="{{route('gastos.create', $meta->id)}}" class="btn btn-xs btn-info btn-flat pull-right"><i class="fa fa-plus"></i> Nuevo Gasto</a>@endif
					<a href="{{route('metas.show', [$meta->actividad->id, $meta->id])}}" style="margin-right: .75rem;" class="btn-xs pull-right"><i class="fa fa-caret-left"></i> Volver</a>
				</div>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-sm table-hover table-fixed">
					<thead>
						<tr>
							<th class="text-center" style="width: 50px">#</th>
							<th class="text-center">Fecha</th>
							<th class="text-center">Documento</th>
							<th class="text-center">N°</th>
							<th class="text-center">Detalle del gasto</th>
							<th class="text-center">Importe</th>
							<th style="width: 70px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($meta->gastos as $gasto)
						<tr>
							<td class="text-center">{{ $loop->index+1 }}</td>
							<td class="text-center">{{ date("d-m-Y", strtotime($gasto->fecha)) }}</td>
							<td class="text-center">{{ $gasto->tipo_documento->nombre }}</td>
							<td class="text-center">{{ $gasto->numero }}</td>
							<td>{{ $gasto->descripcion }}</td>
							<td class="text-right pr-3">S/. {{ number_format($gasto->monto, 2, '.', ',') }}</td>
							<td class="text-center">
								<a class="btn btn-xs btn-flat btn-success" href="{{route('gastos.edit', [$meta->id, $gasto->id])}}"><i class="fa fa-pencil"></i></a>
								<button type="button" class="btn btn-xs btn-flat btn-danger" data-toggle="modal" data-target="#modalElimGasto{{$gasto->id}}" title="Eliminar"><i class="fa fa-trash"></i></button>
								<div class="modal fade in" id="modalElimGasto{{$gasto->id}}" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Eliminar Gasto</h4>
											</div>
											<div class="modal-body">
												¿Realmente desea eliminar el gasto "<strong>{{ $gasto->descripcion }}</strong>"?
											</div>
											<div class="modal-footer text-right">
												<div class="inline-flex">
													<button type="button" class="btn btn-sm btn-secondary mr-2" data-dismiss="modal">Cerrar</button> {!! Form::open(['route'
													=>['gastos.destroy', $gasto->id], 'method' => 'DELETE']) !!}
													<button type="submit" class="btn btn-sm btn-danger">Eliminar</button> {!! Form::close() !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
						<tr>
							<th class="text-right" colspan="5">Total</th>
							<td class="text-right">S/. {{ number_format($meta->gastos->sum('monto'), 2, '.', ',') }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection