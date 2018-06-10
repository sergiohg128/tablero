<div class="row">
  <div class="col col-sm-4">
    <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ url('images/profile/'.Auth::user()->imagen) }}" height="300px" style="height: 200px; width:180px;" alt="User profile picture">

            <h3 class="profile-username text-center">{{ $user->nombres.' '.$user->paterno.' '.$user->materno }}</h3>
            @if($user->tipo=='admin')
              <p class="text-center"><i class="text-success glyphicon glyphicon-king"></i>Admin del Sistema</p>
            @elseif($user->jefe)
              <p class="text-center"><i class="text-success glyphicon glyphicon-king"></i>Jefe de oficina</p>
            @else
              <p class="text-center"><i class="text-info glyphicon glyphicon-pawn"></i>Usuario de oficina</p>
            @endif


            <!-- <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Followers</b> <a class="pull-right">1,322</a>
              </li>
              <li class="list-group-item">
                <b>Following</b> <a class="pull-right">543</a>
              </li>
              <li class="list-group-item">
                <b>Friends</b> <a class="pull-right">13,287</a>
              </li>
            </ul> -->
            <a href="{{ url('perfil/edit') }}" class="btn btn-primary btn-block"><b>Editar</b></a>
            <a href="{{ url('perfil/imagen') }}" class="btn btn-primary btn-block"><b>Imagen</b></a>
            <a href="{{ url('perfil/password') }}" class="btn btn-primary btn-block"><b>Cambiar Contraseña</b></a>
          </div>
          <!-- /.box-body -->
        </div>
  </div>
  <div class="col col-sm-8">
    @yield('content2', 'default manuPerfil')
  </div>
</div>
