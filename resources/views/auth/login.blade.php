@extends('layouts.app')

@section('additional_css')
<link href="{{ asset('assets/admin/pages/css/login.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="login">
    <div class="content">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <h3 class="form-title">Log In</h3>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label visible-ie8 visible-ie9">E-Mail Address</label>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input id="email" type="text" class="form-control placeholder-no-fix" placeholder="Username" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="control-label visible-ie8 visible-ie9">Password</label>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input id="password" type="password" class="form-control form-control-solid placeholder-no-fix" placeholder="Password" name="password" required>
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success uppercase">Login</button>
                <label class="rememberme check">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me
                </label>
                <a href="{{ route('password.request') }}" id="forget-password" class="btn btn-link">Forgot Password?</a>
            </div>
        </form>
    </div>    
</div>
@endsection
