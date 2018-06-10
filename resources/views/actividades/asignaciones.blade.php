@extends('layouts.main')

@section('sidebar-page-actividades', 'active treeview')
@section('sidebar-page-actividades-asignaciones', 'active')

@section('content')
<div class="row">
  <div class="col col-sm-12">
    <div class="box">
      <div class="box-header with-border">
        <div class="box-title">
          Asignaciones
        </div>
        <div class="box-tools"></div>
      </div>
      <div class="box-body table-responsive">
        <table class="table custom_datatable table-hover">
          <thead>
            <tr>
              <th>N°</th>
              <th>Nombre</th>
              <th>Fecha</th>
              <th>Presupuesto</th>
              <th>Creador</th>
              <th>Estado</th>
              <th>Tiempo</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($actividades as $key => $actividad)
              <?php
                  $meta_success=false;//para pintar fila si la meta esta cumplida
                  $metas = count($actividad->metas) ;
                  $metasCumplidas = count($actividad->metas->where('estado', 'F'));
                  $imprimirfila = "";
                  $estilofila = "x";
                  if($metas==0){
                    $imprimirfila = '<span class="label label-warning"><i class="fa fa-clock-o"></i> Pendiente</span>';
                  }elseif($metas==$metasCumplidas){
                    $meta_success=true;
                    $imprimirfila = '<span class="label label-success"><i class="fa fa-trophy"></i> Finalizado</span>';
                  }else{
                    $imprimirfila = '<span class="label label-info"><i class="fa fa-circle-o-notch"></i> En proceso</span>';
                  }
              ?>
            <tr class="{{ $meta_success?'success':''}}">
              <td>{{$loop->index+1}}</td>
              <td>{{$actividad->nombre}}</td>
              <td>{{date("d-m-Y", strtotime($actividad->fecha_inicio))}}</td>
              <td>{{$actividad->presupuesto}}</td>
              <td>{{$actividad->creador->completo()}}</td>
              <td>{!! $imprimirfila !!}</td>
              <td>
                  <div class="col col-sm-12">
                    <div class="progress" style="margin:0">
                      <div class="progress-bar progress-bar-striped @if($actividad->porcentaje()<70) avance-green @elseif($actividad->porcentaje()<100) avance-yellow @else avance-red @endif" role="progressbar" style="width:{{$actividad->porcentaje()}}%" aria-valuenow="{{$actividad->porcentaje()}}" aria-valuemin="0" aria-valuemax="100">{{$actividad->porcentaje()}}%</div>
                    </div>
                  </div>
              </td>
              <td>
                <a href="{{ url('actividades/'.$actividad->id) }}" class="btn btn-xs btn-flat btn-warning"><i class="fa fa-eye"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>

  </div>
</div>
@endsection

@section('script')
  <script src="{{ url('js/comun.js') }}"></script>
  <script>
    function initTable () {
      return $('.custom_datatable').DataTable({
        "columnDefs": [{ "orderable": false, "targets": [7] }],
        'order':[0, 'asc'],
        'retrieve': true,
        'paging' : true,
        'lengthChange': true,
        'searching' : true,
        'ordering' : true,
        'info' : true,
        'autoWidth' : false,
        "language": {
          "search": '<i class="fa fa-search"></i>',
          "lengthMenu": "Mostrar _MENU_ registros por página",
          "zeroRecords": "No se encontró registros.",
          "info": "Mostrando página _PAGE_ de _PAGES_",
          "infoEmpty": "Sin registros disponibles",
          "infoFiltered": "(filtrado de _MAX_ registros totales)",
          "paginate": { "previous": "Anterior", "next": "Siguiente" }
        }
      });
    }

    $(function () {
      initTable();
    });
  </script>
@endsection
