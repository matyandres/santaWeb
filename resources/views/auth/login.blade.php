@extends('layouts.auth')

@section('content')


<form class="kt-form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <div class="col-md-12">
            <input id="username" placeholder="Correo" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
            @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <div class="col-md-12">
            <input id="password" type="password" placeholder="Contraseña" class="form-control" name="password" required>

            @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="row kt-login__extra">
        <div class="col kt-align-right">
            <a href="{{ route('password.request') }}" id="kt_login_forgot" class="kt-login__link">Olvidaste Contraseña ?</a>
        </div>
    </div>
    <div class="kt-login__actions">
        <button type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Iniciar</button>
    </div>
</form>

@endsection