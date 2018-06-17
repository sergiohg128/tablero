@extends('layouts.main')

@section('sidebar-page-actividades', 'treeview active')

@section('content')

<input type="hidden" id='url-base' value="{{url('/')}}">

<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#actividad" data-toggle="tab"><i class="fa fa-home"></i> Actividad</a></li>
		<li><a href="#responsables" data-toggle="tab"><i class="fa fa-group"></i> Responsables</a></li>
		<li><a href="#metas" data-toggle="tab"><i class="fa fa-tasks"></i> Metas</a></li>
		<li><a href="#informacion" data-toggle="tab"><i class="fa fa-tasks"></i> Información</a></li>
	</ul>
	<div class="tab-content">
		<div class="active tab-pane" id="actividad">
			{{ Form::hidden('actividad_id', $actividad->id) }}
			<!--Para capturara la actividad desde el script -->
			<div class="row">

				<div class="col col-sm-12">
					<div class="row">

						<div class="col col-sm-6">
							<div class="text-left">
								<a href="javascript: " class="btn" data-placement="rigth" data-toggle="tooltip" title="Fecha de incio de la actividad">
									<i class="fa fa-calendar"></i>
									{{ date("d/m/Y", strtotime($actividad->fecha_inicio)) }}
								</a>
							</div>

						</div>
						<div class="col col-sm-6">
							<div class="text-right">
								<a href="javascript: " class="btn" data-placement="left" data-toggle="tooltip" title="Fecha estimada para el termino de la actividad">
									<i class="fa fa-calendar"></i>
									{{ date("d/m/Y", strtotime($actividad->fecha_fin_esperada))  }}
								</a>
							</div>
						</div>
					</div>
          <div class="progress" style="margin:0">
            <div class="progress-bar progress-bar-striped @if($actividad->porcentaje()<70) avance-green @elseif($actividad->porcentaje()<100) avance-yellow @else avance-red @endif" role="progressbar" style="width:{{$actividad->porcentaje()}}%" aria-valuenow="{{$actividad->porcentaje()}}" aria-valuemin="0" aria-valuemax="100">{{$actividad->porcentaje()}}%</div>
          </div>
        </div>
				<div class="col col-sm-12">
					<div class="text-right">
						<p class="@if($actividad->porcentaje()<70)text-right text-green @elseIf($actividad->porcentaje()<100) text-yellow @else text-red  @endif">{{ $actividad->plazo() }}</p>
					</div>


				</div>
				<div class="col col-sm-12">
					<div class="callout callout-purple">
						<p class="lead mb-0">{{$actividad->nombre}}</p>
						<label for="actividad_estado">Estado:</label>
						<?php
						$metas = count($actividad->metas) ;
						$metasCumplidas = count($actividad->metas->where('estado', 'F'));
						if($metas==0){
							echo '<span class="label label-warning"><i class="fa fa-clock-o"></i> Pendiente</span>';
						}elseif($metas==$metasCumplidas){
							echo '<span class="label label-success"><i class="fa fa-trophy"></i> Finalizado</span>';
						}else{
							echo '<span class="label label-info"><i class="fa fa-circle-o-notch"></i> En proceso</span>';
						}
						?>
						
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col col-sm-6">
					<div class="col col-sm-12">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Presupuesto</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body">
								<table class="table table-sm">
									<thead>
										<tr>
											<th>Presupuesto</th>
											<th>Gastos</th>
											<th>Diferencia</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>{{ $actividad->presupuesto}}</td>
											<td>{{ $actividad->metas->sum('presupuesto') }}</td>
											<td>{{ $actividad->presupuesto - $actividad->metas->sum('presupuesto')}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col col-sm-6">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Resolucion</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body">
								<pre class="card-title">{!! $actividad->numero_resolucion!!}</pre>
								<p class="card-text">Fecha: {{ $actividad->fecha_resolucion}}</p>
							</div>
						</div>
					</div>
					<div class="col col-sm-6">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Acta</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body">
								<p class="card-title">N°: {{ $actividad->fecha_acta }}</p>
								<p class="card-text">{{ $actividad->descripcion_acta }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col col-sm-6">
					<div class="box box-primary">
						<div class="box-body">
							<table class="table table-hover">
								<tr>
									<th>ver</th>
									<th>Usuario</th>
									<th>Rol</th>
								</tr>
								<tbody>
									<?php
										$creador = $actividad->creador;
										$monitor = $actividad->monitor;
									?>
									<tr>
									  <td><a href="javascript: show_info_user({{$creador->id}})"><i class="text-red fa fa-user"></i></a></td>
									  <td>{{ $creador->nombres.' '.$creador->paterno.' '.$creador->materno }}</td>
									  <td><span class="label bg-red">Creador</span></td>
									</tr>
									<tr>
									  <td><a href="javascript: show_info_user({{$monitor->id}})"><i class="text-yellow fa fa-user"></i></a></td>
									  <td>{{ $monitor->nombres.' '.$monitor->paterno.' '.$monitor->materno }}</td>
									  <td><span class="label bg-yellow">Monitor</span></td>
									</tr>

									@foreach($actividad->responsables as $key=> $responsable)
									<tr>
										<td><a href="javascript: show_info_user({{$responsable->user->id}})"><i class="text-blue fa fa-user"></i></a></td>
										<td>{{ $responsable->user->nombres.' '.$responsable->user->paterno.' '.$responsable->user->materno }}</td>
										<td><span class="label bg-blue">Responsable</span></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal fade" id="modalUserInfo">
						<div class="modal-dialog">
							<div class="box-body no-padding">
								<div class="box box-widget widget-user no-margin">
									<div class="widget-user-header bg-aqua-active" style="padding-top:0; padding-right:0">
										<div class="text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
										</div>
										<h3 class="widget-user-username"><span id="user-fullname"></span></h3>
										<h5 class="widget-user-desc"><span id="user-puesto"></span></h5>
									</div>
									<div class="widget-user-image">
										<img class="img-circle" id='user-imagen' src="{{ url('dist/img/user1-128x128.jpg')}}" alt="User Avatar">
									</div>
									<div class="box-footer">
										<div class="row">
											<div class="col-sm-6 border-right">
												<div class="description-block">
													<h5 class="description-header"><span id="user-actividades"></span></h5>
													<span class="description-text">Actividades</span>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="description-block">
													<h5 class="description-header"><span id="user-metas"></span></h5>
                            						<span class="description-text">Metas</span>
												</div>
											</div>
											<!-- <div class="col-sm-4">
												<div class="description-block">
													<h5 class="description-header"><span id="user-puntaje"></span></h5>
                            						<span class="description-text">Puntos</span>
												</div>
											</div> -->
										</div>
										<div class="box-body">
											<table class="table table-sm mt-2">
												<tbody>
													<tr>
														<td>Oficina:</td>
														<td><span id="user-oficina"></span></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="tab-pane" id="responsables">
			<div class="row">
				<div class="col col-sm-6">
					<div class="form-row">
						<?php
								$oficinas = \App\Oficina::all();
                $oficinas_options[0] = 'Todas';
                foreach ($oficinas as $key => $oficina) {
                  $oficinas_options[$oficina->id] = $oficina->nombre;
                }
               ?>
							<div class="col col-sm-12">
								<div class="box box-primary">
									<div class="box-header with-border">
										<div class="row">
											<div class="col col-sm-7">
												<div class="input-group input-group-sm">
													{{ Form::select('search_by_oficinas',$oficinas_options, Auth::user()->oficina_id, ['class'=>'form-control', 'id'=>'search_by_oficinas'])}}
													<div class="input-group-btn">
														<span class="btn btn-default"><i class="fa fa-institution"></i></span>
													</div>
												</div>
											</div>
											<div class="col col-sm-5">
												<div class="input-group input-group-sm">
													{{ Form::text('search_word', null, ['class'=>'form-control', 'placeholder'=>'buscar', 'id'=>'search_word']) }}
													<div class="input-group-btn">
														<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="box-body table-responsive no-padding chat" id="chat-box1">
										<table class="table table-sm table-hover">
											<tr>
												<th>N°</th>
												<th>Resultados</th>
												<th class="text-right"><a href="javascript: seleccionar_varios(0)"><span id="span_0" class="fa fa-square-o"></span></a></th>
											</tr>
											<tbody id="search_results">
											</tbody>
										</table>
									</div>
								</div>
							</div>
					</div>

				</div>
				<div class="col col-sm-6">
					{{ Form::open(['action'=>['ResponsableController@store'], 'method'=>'POST']) }} {{ Form::hidden('actividad_id', $actividad->id)}}
					<div class="box box-primary">
						<div class="box-header with-border">
							<i class="fa fa-users"></i>
							<h3 class="box-title">Responsables</h3>
							<div class="box-tools pull-right">
              	{{ Form::submit('Guardar lista', ['class'=>'btn btn-sm btn-primary']) }}
              </div>
						</div>
						<div class="box-body table-responsive no-padding">
							<table class="table table-sm table-hover">
								<tr>
									<th>N</th>
									<th>Usuario</th>
									<th></th>
								</tr>
								<tbody id="responsables_selected">
								</tbody>
							</table>
						</div>
					</div>
					{{ Form::close() }}

				</div>
			</div>
		</div>
		<!-- /.tab-pane -->

		<div class="tab-pane" id="metas">
			<div class="row">
				<div class="col col-sm-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-tasks"></i> Metas</h3>
							<div class="box-tools pull-right">
								<a href="{{route('metas.create', $actividad->id)}}" class="btn btn-xs btn-info"><i class="fa fa-plus"></i></a>
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
							<!-- /.box-tools -->
						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive no-padding">
							<table class="table table-sm table-hover custom_datatable" id="meta_table">
								<thead>
									<tr>
										<th class="text-center" style="width: 80px;">#</th>
										<th class="text-center">Nombre</th>
										<th class="text-center">Fecha Inicial</th>
										<th class="text-center">Fecha Final</th>
										<th class="text-center">Estado</th>
										<th class="text-center">Presupuesto</th>
										<th class="text-center" style="width: 120px;"></th>
									</tr>
								</thead>
								<tbody>
									@foreach ($actividad->metas as $meta)
										<tr>
											<td class="text-center">{{$loop->index+1}}</td>
											<td>{{$meta->nombre}}</td>
											<td class="text-center">
												@if ($meta->estado != 'P') {{ date("d/m/Y", strtotime($meta->fecha_inicio))}} @endif
											</td>
											<td class="text-center">
												@if ($meta->estado == 'F') {{ date("d/m/Y", strtotime($meta->fecha_fin))}} @endif
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
												@if ($meta->creador->id == Auth::user()->id)
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
																	<button type="button" class="btn btn-sm btn-default mr-2" data-dismiss="modal">Cerrar</button> {!! Form::open(['route'
																	=>['metas.destroy', $meta->id], 'class' => 'new-form-inline', 'method' => 'DELETE']) !!}
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
									<tfoot>
										<tr>
											<th class="text-right" colspan="5">Total</th>
											<td class="text-right">S/. {{ number_format($actividad->metas->sum('presupuesto'), 2, '.', ',') }}</td>
											<td></td>
										</tr>
									</tfoot>
								</tbody>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
			</div>
		</div>

		<div class="tab-pane" id="informacion">
			<div class="row">
				<div class="col col-sm-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-tasks"></i> Información</h3>
							<div class="box-tools pull-right">
								<a href="{{route('actividad.informacion', $actividad->id)}}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
							</div>
							<!-- /.box-tools -->
						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive no-padding">{!!$actividad->informacion!!}</div>
						<!-- /.box-body -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.tab-content -->
</div>
@endsection

@section('script')
<script src="{{ url('js/actividad_show.js') }}"></script>
<script src="{{ url('js/actividad_show_responsables.js') }}"></script>
<script src="{{ url('js/custom_datatable.js') }}"></script>
<script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('js/dashboard.js') }}"></script>
<script>
	$(function () {
		noSortableTable(0, [6]);
	});
</script>
@endsection
