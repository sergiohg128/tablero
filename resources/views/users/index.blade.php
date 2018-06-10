@extends('layouts.main')

@section('sidebar_page_usuarios', 'active')

@section('content')

<div class="row">


  <div class="col col-sm-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="box-title">
          <i class="fa fa-users"></i>
          Usuarios
          <div class="box-tools pull-right">
          </div>
        </div>
        <div class="box-tools">
          {{ Form::open(['action'=>'UserController@index', 'method'=>'GET'])}}
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
              <th>Cuenta</th>
              <th>Jefe</th>
              <th>Correo</th>
              <th>Telefono</th>
              <th>Oficina</th>
              <th>Cargo</th>
              @if(Auth::user()->tipo=='admin')
              <th><a href="{{ url('users/create') }}" class="btn btn-xs btn-info"><i class="fa fa-user-plus"></i>Nuevo</a></th>
              @endif
            </tr>
          </thead>
          <tbody>
            <?php $num= $users->firstItem()?>
            @foreach($users as $key => $user)

            <tr>
              <td>{{$num}}</td>
              <td>{{$user->paterno.' '.$user->materno.' '.$user->nombres}}</td>
              <td>{{$user->cuenta}}</td>
              <td>
                @if($user->jefe)
                  Sí
                @else
                  No
                @endif
              </td>
              <td>{{$user->correo2}} / {{$user->correo}}</td>
              <td>{{$user->telefono}}</td>
              <td>{{$user->oficina->nombre}}</td>
              <td>{{$user->cargo}}</td>
              @if(Auth::user()->tipo=='admin')
              <td>
                {{ Form::open(['action'=>['UserController@destroy', $user->id], 'method'=>'DELETE'])}}
                  <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-xs btn-flat btn-success"><i class="fa fa-pencil"></i></a>
                  <button type="submit" class="btn btn-xs btn-flat btn-danger"><i class="fa fa-trash"></i></button>
                {{ Form::close()}}
              </td>
              @endif
            </tr>
            <?php $num++; ?>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="box-footer clearfix">
        <div id="mypag" hidden>
          @if($users->total()!=0)
            {{ 'Mostrando del '.$users->firstItem().' al  '.$users->lastItem().' de '.$users->total().' registros'}}
            {{ $users->links('',['class'=>'clearfix']) }}
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
