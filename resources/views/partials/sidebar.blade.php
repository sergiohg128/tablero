<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ url('images/profile/'.Auth::user()->imagen) }}" style="width: 100%; max-width: 45px; height: 45px;" class="img-circle"
         alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->cuenta }}</p>
        <!-- Status -->
        @if(Auth::user()->tipo=='admin')
        <a href="#"><i class="fa fa-circle text-success"></i>Admin</a>
        @elseif(Auth::user()->jefe)
        <a href="#"><i class="fa fa-circle text-success"></i>Jefe</a>
        @else()
        <a href="#"><i class="fa fa-circle text-success"></i>Usuario</a>
        @endif
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU</li>
      <!-- Optionally, you can add icons to the links -->
      <li class="@yield('sidebar-page-perfil', '')">
        <a href="{{ url('perfil') }}">
          <i class="fa fa-user"></i> <span>Perfil</span>
        </a>
      </li>
      <li class="@yield('sidebar_page_indicadores', '')"><a href="{{ url('indicadores') }}"><i class="fa fa-circle-o"></i> <span>Indicadores</span></a></li>
      <li class="@yield('sidebar-page-actividades', 'treeview')">
        <a href="#"><i class="fa fa-magic"></i> <span>Actividades</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
        <ul class="treeview-menu">
          <li class="@yield('sidebar-page-actividades-oficina', '')"><a href="{{ url('actividades/oficina') }}"><i class="fa fa-circle-o"></i> <span>Por Oficina</span></a></li>
          <li class="@yield('sidebar-page-actividades-asignaciones', '')"><a href="{{ url('actividades/asignaciones') }}"><i class="fa  fa-share-alt"></i> <span>Asignaciones</span></a></li>
          <li class="@yield('sidebar-page-actividades-creaciones', '')"><a href="{{ url('actividades/creaciones') }}"><i class="fa fa-magic"></i> <span>Creaciones</span></a></li>
          <li class="@yield('sidebar-page-actividades-monitoreos', '')"><a href="{{ url('actividades/monitoreos')}}"><i class="fa fa-dot-circle-o"></i> <span>Monitoreos</span></a></li>
        </ul>
      </li>
      <li class="@yield('sidebar_page_usuarios', '')"><a href="{{ url('users') }}"><i class="fa fa-user"></i> <span>Usuarios</span></a></li>
      @if(Auth::user()->tipo=='admin')
      <li class="@yield('sidebar_page_oficina', '')"><a href="{{ url('oficinas') }}" }}><i class="fa fa-institution"></i> <span>Oficinas</span></a></li>
      @endif

      
        <li class="@yield('sidebar_page_reportes', '')"><a href="{{ url('reportes') }}" }}><i class="fa fa-institution"></i> <span>Reportes</span></a></li>
      
      </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
