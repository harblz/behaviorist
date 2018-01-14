@extends('layouts.app')

@section('content')
<div class="container" style="padding: 15px;" id="app">
    <form class="field" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="label">E-Mail Address</label>

            <div class="column">
                <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="label">Password</label>

            <div class="column">
                <input id="password" type="password" class="input" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="field">
            <div class="column">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>
        </div>

        <div class="field">
            <button type="submit" class="button is-primary">
                Login
            </button>

            <a class="button is-text" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        </div>
    </form>
</div>
@endsection
