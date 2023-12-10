@extends('auth.layout')
@section('content')  

@if ($errors->has('email'))
<span class="help-block text-danger">
    <strong>{{ $errors->first('email') }}</strong>
</span>
@endif

<h3 class="text-center page-title" style="margin-top:20px">Chat Bots AI</h3>
<div class="card auth-box">
    
    <div class="card-header">
        <p class="h4">Authorization</p>
    </div>
    <form class="card-body" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="">{{__('Email')}}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{old('email')}}" required autofocus />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="">{{__('Password')}}</label>
            <input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-success">
                {{ __('Log in') }}
            </button>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            @if (Route::has('register'))
            <a href="{{ route('register') }}">
                {{ __('New User Register') }}
            </a>
            @endif
        </div>
    </form>
</div>

@endsection                
