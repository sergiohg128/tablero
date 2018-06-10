<!-- User Account Menu -->
<li class="dropdown user user-menu">
  <!-- Menu Toggle Button -->
  @guest
  <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
  @else
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <!-- The user image in the navbar-->
    <img src="{{ url('images/profile/'.Auth::user()->imagen) }}" width="25px" class="user-image" alt="User Image">
    <!-- hidden-xs hides the username on small devices so only the image appears. -->
    <span class="hidden-xs">{{ Auth::user()->cuenta }}</span>
  </a>
  <ul class="dropdown-menu">
    <!-- The user image in the menu -->
    <li class="user-header">
      <img src="{{ url('images/profile/'.Auth::user()->imagen) }}" class="img-circle" alt="User Image">
      <p>
        {{ Auth::user()->nombres.' '.Auth::user()->paterno.' '.Auth::user()->materno }}
        @if(Auth::user()->tipo=='admin')
        <small>Admin del Sistema</small>
        @elseif(Auth::user()->jefe)
        <small>Jefe de Oficina</small>
        @else()
        <small>Usuario de oficina</small>
        @endif
      </p>
    </li>

    <!-- Menu Footer-->
    <li class="user-footer">
      <div class="pull-left">
        <a href="{{ url('perfil') }}" class="btn btn-default btn-flat">Perfil</a>
      </div>
      <div class="pull-right">
        <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
        {{ __('Salir') }}
      </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
  </ul>
  @endguest
</li>
