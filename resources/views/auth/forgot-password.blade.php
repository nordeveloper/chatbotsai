@extends('auth.layout')
@section('content')   

<div class="card auth-box">

<div class="card-body">
    <p>
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </p>
    
    
    @if ($errors->has('email'))
    <span class="help-block text-danger">
        <strong>{{ $errors->first('email') }}</strong>
    </span>
    @endif
    
    @if(!empty($status))
    {{$status}}
    @endif
    
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
    
        <!-- Email Address -->
        <div class="form-group">
            <label for="email">{{__('Email')}}</label>
            <input id="email" class="form-control" type="email" name="email" value="admin@laravelstarter.loc" required autofocus />
        </div>
    
        <div class="form-group">
            <button type="submit" class="btn btn-success">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</div>

</div>
@endsection  
