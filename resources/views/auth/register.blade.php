@extends('auth.layout')
@section('content')        
       
<h3 class="text-center">Chat Bots AI</h3>

<div class="card register-box">
    
    <div class="card-header">
        <h4>{{ __('Register') }}</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
                <div class="col-md-2">
                    <label for="first_name" >{{ __('Your Name') }}</label>
                </div>
                <div class="col-md-5">
                    <input id="first_name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- <div class="form-group row">
                <div class="col-md-2">
                    <label for="phone">{{ __('Phone') }}</label>
                </div>
                <div class="col-md-5">
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autofocus>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-md-2">
                    <label for="email">{{ __('E-Mail') }}</label>
                </div>
                <div class="col-md-5">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2">
                    <label for="password">{{ __('Password') }}</label>
                </div>

                <div class="col-md-5">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                </div>
                <div class="col-md-5">
                    <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-5 text-right">
                    <button type="submit" class="btn btn-success">
                        {{ __('Register') }}
                    </button>
                </div>
                <div class="col-md-6">
                    @if (Route::has('login'))
                    <a href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

@endsection        