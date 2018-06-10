@extends('layouts.main') 
@section('css')
<link rel="stylesheet" href="{{ url('plugins/iCheck/all.css') }}">
@endsection
 
@section('content')
<div class="row">
	<div class="col col-sm-12 col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
					Nuevo registro de monitoreo
				</div>
			</div>
			<div class="box-body">
				<div class="col-sm-12">
					@include('partials.myAlertErrors') @if (isset($monitoreo))
					@include('monitoreos.edit') @else
					@include('monitoreos.create') @endif
				</div>
			</div>
		</div>
	</div>
	<div class="col col-sm-12 col-md-8">
		<div class="box box-info">
			<div class="box-header with-border">
				<div class="box-title" style="display:block;">
					Registros de Monitoreo 
					@if (isset($monitoreo))
					<a href="{{route('monitoreo.create', $meta->id)}}" class="btn btn-xs btn-info btn-flat pull-right"><i class="fa fa-plus"></i> Nuevo Registro</a>@endif
					<a href="{{route('metas.show', [$meta->actividad->id, $meta->id])}}" style="margin-right: .75rem;" class="btn-xs pull-right"><i class="fa fa-caret-left"></i> Volver</a>
				</div>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover custom_datatable" id="monitoreo_table">
					<thead>
						<tr>
							<th class="text-center" style="width: 80px;">#</th>
							<th class="text-center">Descripción</th>
							<th class="text-center">Fecha</th>
							<th class="text-center">Observacion</th>
							<th class="text-center" style="width: 120px;"></th>
						</tr>
					</thead>
					<tbody id="table-body-oficinas">
						@foreach($meta->monitoreos as $monitoreo)
						<tr>
							<td class="text-center">{{ $loop->index+1 }}</td>
							<td>{{ $monitoreo->descripcion }}</td>
							<td class="text-center">{{ date("d-m-Y", strtotime($monitoreo->fecha)) }}</td>
							<td>{{ $monitoreo->observacion }}</td>
							<th>
								<a class="btn btn-xs btn-flat btn-success" href="{{route('monitoreo.edit', [$meta->id, $monitoreo->id])}}"><i class="fa fa-pencil"></i></a>
								<button type="button" class="btn btn-xs btn-flat btn-danger" data-toggle="modal" data-target="#modalElimMonitoreo{{$monitoreo->id}}" title="Eliminar"><i class="fa fa-trash"></i></button>
								<div class="modal fade in" id="modalElimMonitoreo{{$monitoreo->id}}" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Eliminar Registro de Monitoreo</h4>
											</div>
											<div class="modal-body">
												¿Realmente desea eliminar el registro "<strong>{{ $monitoreo->descripcion }}</strong>"?
											</div>
											<div class="modal-footer text-right">
												<div class="inline-flex">
													<button type="button" class="btn btn-sm btn-secondary mr-2" data-dismiss="modal">Cerrar</button> {!! Form::open(['route'
													=>['monitoreo.destroy', $monitoreo->id], 'method' => 'DELETE']) !!}
													<button type="submit" class="btn btn-sm btn-danger">Eliminar</button> {!! Form::close() !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
	</div>
</div>
@endsection
 
@section('script')
<script src="{{ url('plugins/iCheck/icheck.min.js') }}"></script>
<script>
	$(function () {
		$('input[type="radio"]').iCheck({ checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue' });
	});
</script>
@endsection