@extends('layouts.main')


@section('content')
  <div class="row">
    <div class="col col-sm-4">
      <div class="box box-solid">
            <div class="box-header with-border">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Requisito</h3>
              <div class="box-tools">
                <a href="{{ url('actividades/'.$meta->actividad->id.'/metas/'.$meta->id) }}"><i class="fa fa-arrow-left"></i> Volver</a>
              </div>
            </div>


            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col col-sm-12">
                  @include('partials.myAlertErrors')
                  @if(isset($requisito))
                    @include('requisitos.edit')
                  @else
                    @include('requisitos.create')
                  @endif
                </div>
              </div>

            </div>
            <!-- /.box-body -->
          </div>
    </div>
    <div class="col col-sm-8">

      <div class="box">
        <div class="box-header with-border">
          <i class="ion ion-clipboard"></i>
          <div class="box-title">
            Requisitos
          </div>
          <div class="box-tools">
            @if(isset($requisito))
              {{ Form::open(['route'=>['requisito.edit', $meta->id, $requisito->id], 'method'=>'GET'])}}
            @else
              {{ Form::open(['route'=>['requisito.create', $meta->id], 'method'=>'GET'])}}
            @endif
            <div class="input-group input-group-sm" style="width: 150px;">
              {{ Form::text('search', null, ['class'=>'form-control form-control-sm', 'placeholder'=>'buscar']) }}
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
              </div>
            </div>
            {{ Form::close() }}
          </div>
        </div>
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>estado</th>
                  <th>observacion</th>
                  <th>Fecha completado</th>
                  <th></th>
                </tr>
            </thead>
            <tbody id="table-body-oficinas">
                @foreach($requisitos as $key => $requisito)
                  <tr>
                    <td>{{ $requisito->id }}</td>
                    <td>{{ $requisito->nombre }}</td>
                    <td>
                      @if($requisito->estado==0)
                        <small class="label label-info"><i class="fa fa-clock-o"></i> En proceso</small>
                      @else
                        <small class="label label-warning"><i class="fa fa-trophy"></i> Completado</small>
                      @endif
                    </td>
                    <td>{{ $requisito->observacion }}</td>
                    <td>{{date("d-m-Y", strtotime($requisito->fecha_completado))}}</td>
                    <td>
                      {{ Form::open(['action'=>['RequisitoController@destroy', $requisito->id], 'method'=>'DELETE']) }}
                        <a href="{{ url('metas/'.$meta->id.'/requisitos/'.$requisito->id.'/edit') }}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-pencil"></i></a>
                        <button type="submit" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></button>
                      {{ Form::close() }}
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <div class="box-footer clearfix">
          <div id="mypag" hidden>
            @if($requisitos->total()!=0)
              {{ 'Mostrando del '.$requisitos->firstItem().' al  '.$requisitos->lastItem().' de '.$requisitos->total().' registros'}}
              {{ $requisitos->links() }}
            @else
              No hay registros
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection

@section('script')
  <script src="{{ url('js/comun.js') }}"></script>

@endsection
