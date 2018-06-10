@extends('layouts.main')

@section('sidebar_page_indicadores', 'active')

@section('content')

<div class="row">


  <div class="col col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="box-title">
          <i class="fa fa-users"></i>
          Indicadores
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-tools">
          {{ Form::open(['action'=>'IndicadorController@index', 'method'=>'GET'])}}
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
        <table class="table table-hover table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Creador</th>
              <th>Oficina</th>
              <th>Valor</th>
              <th>Año</th>
              <th colspan="3">
                @if(Auth::user()->tipo=='admin' || Auth::user()->jefe)
                  <a href="{{ url('indicadores/create') }}" class="btn btn-xs btn-info"><i class="fa fa-user-plus"></i>Nuevo</a>
                  @endif
                </th>
            </tr>
          </thead>
          <tbody>
            <?php $num= $indicadores->firstItem()?>
            @foreach($indicadores as $key => $indicador)

            <tr>
              <td>{{$num}}</td>
              <td>{{$indicador->nombre}}</td>
              <td>{{$indicador->creador->completo()}}</td>
              <td>{{$indicador->oficina->nombre}}</td>
              <td>{{$indicador->valor}} @if($indicador->tipo=='2')% @endif</td>
              <td>{{$indicador->anio}}</td>
              <td><a href="{{ url('indicadores/'.$indicador->id) }}" class="btn btn-xs btn-flat btn-warning"><i class="fa fa-eye"></i></a></td>
              <td><a href="{{ url('indicadores/'.$indicador->id.'/edit') }}" class="btn btn-xs btn-flat btn-success"><i class="fa fa-pencil"></i></a></td>
              <td>
                @if(Auth::user()->tipo=='admin')
                  {{ Form::open(['action'=>['IndicadorController@destroy', $indicador->id], 'method'=>'DELETE'])}}
                    <button type="submit" class="btn btn-xs btn-flat btn-danger"><i class="fa fa-trash"></i></button>
                  {{ Form::close()}}
                @endif
              </td>
            </tr>
            <?php $num++; ?>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="box-footer clearfix">
        <div id="mypag" hidden>
          @if($indicadores->total()!=0)
            {{ 'Mostrando del '.$indicadores->firstItem().' al  '.$indicadores->lastItem().' de '.$indicadores->total().' registros'}}
            {{ $indicadores->links('',['class'=>'clearfix']) }}
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
