@extends('layouts.main')


@section('content')
  <div class="row">
    <div class="col col-sm-5">

      <div class="box">
        <div class="box-header with-border">

          <div class="box-title">
            Buzon de entrada
          </div>
        </div>
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
                <tr>
                  <th>ID</th>
                  <th>Fecha</th>
                  <th>Tipo</th>
                  <th class="text-right">Ir</th>
                </tr>
            </thead>
            <tbody id="table-body-oficinas">
                @foreach($notificaciones as $key => $notificacion)
                  <tr>
                    <td>{{ $notificacion->id }}</td>
                    <td>{{date("d-m-Y", strtotime($notificacion->fecha))}}</td>
                    <td>{{ $notificacion->tipo }}</td>
                    <td>
                      <div class="text-right">
                        <div class="btn-group">
                          <a href="{{ url('notificaciones/'.$notificacion->id) }}" class="btn btn-xs btn-flat btn-success"><i class="fa fa-pencil"></i>Ir</a>
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
            @if($notificaciones->total()!=0)
              <div class="text-right">
                  {{ $notificaciones->firstItem().'-'.$notificaciones->lastItem().'/'.$notificaciones->total()}}

                {{ $notificaciones->links() }}
              </div>


            @else
              No hay registros
            @endif
          </div>
        </div>
      </div>

    </div>
    <div class="col col-sm-7">
      {{ $notificacion->tipo }}
    </div>
  </div>

@endsection

@section('script')
  <script src="{{ url('js/comun.js') }}"></script>
  <script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <script src="{{ url('js/dashboard.js') }}"></script>
@endsection
