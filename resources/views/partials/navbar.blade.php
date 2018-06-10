<nav class="navbar navbar-expand-lg navbar-light bg-light mb-0">
  <a class="navbar-brand" href="{{ url('/') }}">
    <img src="{{ url('images/icon.png') }}" alt="" width="30" height="30" alt="icono-unprg">UNPRG
  </a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class='nav-link ' href="{{ url('/') }}">Tareas</a>
      </li>
    </ul>


    <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @guest
            <li><a style="width:160px" class="btn btn-light"  href="{{ url('login') }}">Login</a></li>
        @else
            <li class="dropdown">
                <a style="width:160px" href="#" class="dropdown-toggle btn btn-light" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                    {{ Auth::user()->cuenta }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ url('logout') }}">Salir</a></li>
                </ul>
            </li>
        @endguest
    </ul>

  </div>
</nav>
