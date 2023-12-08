@extends('auth.layout')
@section('content')   

<div class="card auth-box">
    <div class="card-body">

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email Address -->
    <div class="form-group">
        <label>{{__('Email')}}</label>
        <input id="email" class="form-control"  type="email" name="email" value="{{old('email', $request->email)}}" required autofocus />
    </div>

    <!-- Password -->
    <div class="form-group">
        <label for="password">{{__('Password')}}</label>
        <input id="password" class="form-control"  type="password" name="password" required />
    </div>

    <!-- Confirm Password -->
    <div class="form-group">
        <label>{{__('Confirm Password')}}</label>
        <input id="password_confirmation" class="form-control" 
                            type="password"
                            name="password_confirmation" required />
    </div>

    <div class="form-group">
        <button class="btn btn-success" type="submit">
            {{ __('Reset Password') }}
        </button>
    </div>
</form>

</div>
</div>
@endsection                `
