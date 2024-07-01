@extends('layouts.guest')
@section('content')
<div id="wrapper-admin">
    <div class="container">
        <div class="row">
            <div class="offset-md-4 col-md-4">
                <div class="logo border border-danger">
                    <img src="{{ asset('images/library.png') }}" alt="">
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="yourform" action="{{ route('login') }}" method="post">
                    @csrf
                    <h3 class="heading">Admin Login</h3>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}" required>
                        @error('username')
                            <div class='alert alert-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" value="" required>
                        @error('password')
                            <div class='alert alert-danger'>{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="submit" name="login" class="btn btn-danger" value="Login">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection