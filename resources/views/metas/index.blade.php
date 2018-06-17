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
					@if (isset($meta)) Editar Meta @else Nueva Meta @endif
				</div>
			</div>
			<div class="box-body">
				<div class="col-sm-12">
					@include('partials.myAlertErrors')
					@if (isset($meta))
					@include('metas.edit')
					@else
					@include('metas.create')
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="col col-sm-12 col-md-8">
		<div class="box box-info">
			<div class="box-header with-border">
				<div class="box-title" style="display:block;">
					Lista de Metas
					@if (isset($meta))
					<a href="{{route('metas.create', $actividad->id)}}" class="btn btn-xs btn-info btn-flat pull-right"><i class="fa fa-plus"></i> Nueva Meta</a>
					@endif
					<a href="{{route('actividades.show', $actividad->id)}}" class="btn-xs pull-right mr-3"><i class="fa fa-caret-left"></i> Volver</a>
				</div>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-sm table-hover table-fixed">
					<thead>
						<tr>
							<th class="text-center" style="width:50px;">#</th>
							<th class="text-center">Nombre</th>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Presupuesto</th>
							<th class="text-center"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($actividad->metas as $meta)
						<tr>
							<td class="text-center">{{$loop->index+1}}</td>
							<td>{{$meta->nombre}}</td>
							<td class="text-center">
								@if ($meta->estado != 'P') {{ date("d-m-Y", strtotime($meta->fecha_inicio))}} @endif
							<td class="text-center">
								@if ($meta->estado == 'F') {{ date("d-m-Y", strtotime($meta->fecha_fin))}} @endif
							</td>
							<td class="text-center">
								@if ($meta->estado == 'P')
								<span class="label label-warning"><i class="fa fa-clock-o"></i> Pendiente</span> @endif @if ($meta->estado == 'E')
								<span class="label label-info"><i class="fa fa-circle-o-notch"></i> En proceso</span> @endif @if ($meta->estado == 'F')
								<span class="label label-success"><i class="fa fa-trophy"></i> Finalizado</span> @endif
							</td>
							<td class="text-right">{{number_format($meta->presupuesto, 2, '.', ',')}}</td>
							<td class="text-center">
								<a href="{{route('metas.show', [$actividad->id, $meta->id])}}" title="Ver" class="btn btn-xs btn-flat btn-warning"><i class="fa fa-eye"></i></a>
								@if ($meta->estado != 'F')
								<a href="{{route('metas.edit', [$actividad->id, $meta->id])}}" title="Editar" class="btn btn-xs btn-flat btn-success"><i class="fa fa-pencil"></i></a>
								@endif
								@if ($meta->creador->id == Auth::user()->id && $meta->estado != 'F')
								<button type="button" class="btn btn-xs btn-flat btn-danger" data-toggle="modal" data-target="#modalElimMeta{{$meta->id}}" title="Eliminar"><i class="fa fa-trash"></i></button>
								<div class="modal fade" id="modalElimMeta{{$meta->id}}" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Eliminar Meta</h4>
											</div>
											<div class="modal-body">
												¿Realmente desea eliminar la meta "<strong>{{ $meta->nombre }}</strong>"?
											</div>
											<div class="modal-footer text-right">
												<div class="inline-flex">
													<button type="button" class="btn btn-sm btn-default mr-2" data-dismiss="modal">Cerrar</button>
													{!! Form::open(['route' =>['metas.destroy', $meta->id], 'class' => 'new-form-inline', 'method' => 'DELETE']) !!}
													<button type="submit" class="btn btn-sm btn-danger">Eliminar</button> {!! Form::close() !!}
												</div>
											</div>
										</div>
									</div>
								</div>
								@endif
							</td>
						</tr>
						@endforeach
						<tr>
							<th class="text-right" colspan="5">Total</th>
							<td class="text-right pr-3">S/. {{ number_format($actividad->metas->sum('presupuesto'), 2, '.', ',') }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
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