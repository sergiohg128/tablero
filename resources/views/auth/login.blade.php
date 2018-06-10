@extends('layouts.log')

@section('content')
<p class="login-box-msg">Iniciar Sesión</p>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group has-feedback">
      <input id="cuenta" type="text" class="form-control{{ $errors->has('cuenta') ? ' is-invalid' : '' }}" name="cuenta" value="{{ old('cuenta') }}" placeholder="Usuario" required autofocus>
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      @if ($errors->has('cuenta'))
          <span class="invalid-feedback">
              <strong>{{ $errors->first('cuenta') }}</strong>
          </span>
      @endif
    </div>

    <div class="form-group has-feedback">
      <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña" required>
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      @if ($errors->has('password'))
          <span class="invalid-feedback">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
      @endif
    </div>

    <div class="row">
      
      <!-- /.col -->
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
      </div>
      <!-- /.col -->
    </div>
</form>
@endsection
