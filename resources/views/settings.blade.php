@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Settings</h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="yourform" action="{{ route('settings') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Return Days</label>
                        <input type="number" class="form-control @error('return_days') is-invalid @enderror"
                            name="return_days" value="{{ old('return_days', $data->return_days) }}" required>
                        @error('return_days')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Fine (in Rs.)</label>
                        <input type="number" class="form-control @error('fine') is-invalid @enderror" name="fine"
                            value="{{ old('fine', $data->fine) }}" required>
                        @error('fine')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-danger" value="Update">
                    <a href="{{ url('/') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection