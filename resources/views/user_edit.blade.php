@extends('main')

@section('content')

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card user-profile">
        <div class="card-body">
            <p class="h4">User Profile</p>
            <form method="post" action="{{ route('user.update') }}">
                <div class="form-group">
                    <input class="form-control" name="name" value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <input class="form-control" name="email" value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <input class="form-control" name="password" placeholder="password">
                </div>

                <div class="form-group">
                    <input class="form-control" name="password_confirm" placeholder="Confirm password">
                </div>

                <div class="form-group">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>

        </div>
    </div>

@endsection