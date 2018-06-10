@extends('layouts.main')


@section('content')
  <div class="row">
    <div class="col col-sm-6">
      <div class="row">
        <div class="col col-sm-12">
          <div class="box box-primary">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Mis Notificaciones</h3>

              <div class="box-tools pull-right">
                {{ Form::open(['action'=>'NotificacionController@index', 'method'=>'GET'])}}
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <?php
                      $opciones = ['Actividad', 'Responsable', 'Meta' ];
                    ?>
                    {{ Form::select('oficina_id',$opciones,null,['class'=>'form-control form-control-sm', 'placeholder'=>'Todas']) }}
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                {{ Form::close() }}
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th></th>
                    <th>Titulo</th>
                    <th>Visto</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($notificaciones as $key => $notificacion)
                  <tr>
                    <td>{!! $notificacion->type_icon() !!}</td>
                    <td>{{ $notificacion->title }} {!! $notificacion->creadoHace() !!}</td>
                    <td>
                      <a href="{{ url('notificaciones/'.$notificacion->id) }}"><i class="fa  @if($notificacion->checked) fa-envelope-o  @else fa-envelope  @endif"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <div class="box-footer clearfix">
                <div id="mypag" hidden>
                  @if($notificaciones->total()!=0)
                    {{ 'Mostrando del '.$notificaciones->firstItem().' al  '.$notificaciones->lastItem().' de '.$notificaciones->total().' registros'}}
                    {{ $notificaciones->links() }}
                  @else
                    No hay registros
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="col col-sm-12">
          <div class="box box-info collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Tipos de Notificaciones</h3>
							<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
							</div>
						</div>
						<div class="box-body ">
              <div class="row">
                <div class="col col-sm-6">
                  <p><i class="fa fa-sitemap"></i> Actividad</p>
                  <p><i class="fa fa-flag"></i> Meta</p>
                  <p><i class="fa fa-binoculars"></i> Monitor</p>
                  <p><i class="fa fa-user-plus"></i> Responsable</p>
                </div>
                <div class="col col-sm-6">

                  <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-info"></i> Hey!</h4>
                    *Tambien Puedes utilizar estas paralabras en el filtro de busqueda
                  </div>
                </div>
              </div>
						</div>
					</div>
        </div>
      </div>

    </div>
    <div class="col col-sm-6">

      <div class="box box-primary">
        <div class="box-header with-border">
          <i class="fa fa-bell-o"></i>
          <h3 class="box-title">Notificacion</h3>
          <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body  no-padding" >
          @if(isset($noti))
          <?php $from = \App\User::find($noti->from);  ?>

          <div class="box box-solid" style="margin-bottom:0">
            <div class="box-header with-border">
              <div class="user-panel">
                <div class="pull-left image">
                  <img src="{{url('images/profile/'.$from->imagen)}}" style="width: 100%; max-width: 45px; height: 45px;" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                  <p class="text-primary">{{ $from->nombres.' '.$from->paterno.' '.$from->materno }}</p>
                  <!-- Status -->
                  <p class="text-muted">{{ date('m/d/Y' ,strtotime($noti->date))}}</p>
                  </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body chat" id="chat-box">
              <blockquote>
                <p class="lead">{{$noti->title}}</p>
                <p align=justify>{!! $noti->detail !!}</p>
                <small><cite title="Source Title">Mensaje automatico</cite></small>
              </blockquote>
            </div>
          </div>

          @else
          <div class="text-center">
            <div class="form-group">
              <a href="javascript:" class="btn btn-app">
                <i class="fa fa-bullhorn"></i> Notifications
              </a>
            </div>
            <blockquote>
              <p>Selecciona una elemento para leerlo</p>
            </blockquote>
          </div>
          @endif

        </div>
        <div class="box-footer">
          <div class="text-right">
            @if(isset($noti))
              <i class="fa fa-check"></i> Visto el {{ date('d/m/Y', strtotime($noti->checked_date)) }} a las {{ date('H:i:s', strtotime($noti->checked_date)) }}
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection

@section('script')
  <script src="{{ url('js/comun.js') }}"></script>
  <script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <script src="{{ url('js/dashboard.js') }}"></script>
@endsection
