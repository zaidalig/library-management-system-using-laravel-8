@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Update Student</h2>
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
                <form class="yourform" action="{{ route('student.update', $student->id) }}" method="post"
                    autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Student Name" name="name" value="{{ old('name', $student->name) }}" required>
                        @error('name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                            placeholder="Address" name="address" value="{{ old('address', $student->address) }}"
                            required>
                        @error('address')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <input type="text" class="form-control @error('class') is-invalid @enderror" placeholder="Class"
                            name="class" value="{{ old('class', $student->class) }}" required>
                        @error('class')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" class="form-control @error('age') is-invalid @enderror" placeholder="Age"
                            name="age" value="{{ old('age', $student->age) }}" required>
                        @error('age')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="phone" class="form-control @error('phone') is-invalid @enderror"
                            placeholder="Phone" name="phone" value="{{ old('phone', $student->phone) }}" required>
                        @error('phone')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" name="email" value="{{ old('email', $student->email) }}" required>
                        @error('email')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <input type="submit" name="save" class="btn btn-danger" value="Update">
                    <a href="{{ route('students') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection