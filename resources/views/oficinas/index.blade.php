@extends('layouts.main')

@section('sidebar_page_oficina', 'active')

@section('content')
  <div class="row">
    <div class="col col-sm-12 col-md-4 mb-5">
      @include('partials.myAlertErrors')
      @if(isset($oficina))
        @include('oficinas.edit')
      @else
        @include('oficinas.create')
      @endif
    </div>
    <div class="col col-sm-12 col-md-8">

      <div class="box">
        <div class="box-header with-border">
          <div class="box-title">
            Oficinas
            <a href="{{ url('oficinas/create') }}" class="btn btn-xs btn-info"><i class="fa fa-plus"></i></a>
          </div>
          <div class="box-tools">
            @if(isset($oficina))
              {{ Form::open(['action'=>['OficinaController@edit', $oficina->id], 'method'=>'GET'])}}
            @else
              {{ Form::open(['action'=>'OficinaController@create', 'method'=>'GET'])}}
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
                <th>N°</th>
                <th>Nombre</th>
                <td></td>
              </tr>
            </thead>
            <tbody id="table-body-oficinas">
                @foreach($oficinas as $key => $oficina)
                  <tr>
                    <td>{{ $oficina->id }}</td>
                    <td>{{ $oficina->nombre }}</td>
                    <td>
                      <div class="text-right">
                        <div class="btn-group">
                          {{ Form::open(['action'=>['OficinaController@destroy', $oficina->id], 'method'=>'DELETE']) }}
                          <a href="{{ url('oficinas/'.$oficina->id.'/edit') }}" class="btn btn-xs btn-flat btn-success"><i class="fa fa-pencil"></i></a>
                          <button type="submit" class="btn btn-xs btn-flat btn-danger"><i class="fa fa-trash"></i></button>
                          {{ Form::close() }}
                        </div>
                      </div>

                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <div class="box-footer clearfix">
          <div id="mypag" hidden>
            @if($oficinas->total()!=0)
              {{ 'Mostrando del '.$oficinas->firstItem().' al  '.$oficinas->lastItem().' de '.$oficinas->total().' registros'}}
              {{ $oficinas->links() }}
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
