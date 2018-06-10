<li class="dropdown notifications-menu">
  <!-- Menu toggle button -->
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <?php
    $notificaciones = \App\Notificacion::where('to', Auth::user()->id)
    ->orderBy('date', 'desc')
    ->where('checked', 0)->get();
  ?>
      <i class="fa fa-bell-o"></i>
      <span class="label label-warning">{{ count($notificaciones) }}</span>
  </a>
  <ul class="dropdown-menu">
    <li class="header">Tienes {{ count($notificaciones) }} notificaciones</li>
    <li>
      <!-- Inner Menu: contains the notifications -->
      <ul class="menu">
        @if(count($notificaciones)!=0) @foreach($notificaciones as $key => $notificacion)
        <li>
          <!-- start notification -->
          <a href="{{ url('notificaciones/'.$notificacion->id) }}">
            @if($notificacion->type == 'actividad')
              @if($notificacion->action == 'create' || $notificacion->action == 'crear')
                <p class="text-blue">
                  <i class="fa fa-sitemap"></i>
                   Actividad Creada
                </p>
              @elseif($notificacion->action == 'eliminar')
                <p class="text-red">
                  <i class="fa fa-sitemap text-red"></i>
                   Actividad Eliminada
                </p>
              @elseif($notificacion->action == 'progreso')
                <p class="text-red">
                  <i class="fa fa-hourglass-end text-red"></i>
                   Progreso de actividad
                </p>
              @endif

            @elseif($notificacion->type == 'responsable')
              @if($notificacion->action == 'asignar')
                <p class="text-blue">
                  <i class="fa fa-user-plus"></i>
                  Asignado como responsable
                </p>
              @elseif($notificacion->action == 'reasignar')
                <p class="text-green">
                  <i class="fa fa-user-plus"></i>
                  Reasignado como responsable
                </p>
              @elseif($notificacion->action == 'eliminar')
                <p class="text-red">
                  <i class="fa fa-user-plus text-red"></i>
                  Eliminado como responsable
                </p>
              @endif

            @elseif($notificacion->type == 'meta')
              <i class="fa fa-flag text-red"></i>

            @elseif($notificacion->type == 'Monitoreo')
              <i class="fa fa-binoculars text-yellow"></i>
            @endif
          </a>
        </li>
        @endforeach @else
        <li>
          <!-- start notification -->
          <a href="#">
          <i class="fa fa-users text-aqua"></i> No tienes nuevas notificaciones
        </a>
        </li>
        @endif
        <!-- end notification -->
      </ul>
    </li>
    <li class="footer"><a href="{{ url('notificaciones') }}">Ver todas</a></li>
  </ul>
</li>
