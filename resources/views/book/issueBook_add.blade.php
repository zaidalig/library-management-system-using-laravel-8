@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Add Book Issue</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="{{ route('book_issued') }}">All Issue List</a>
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
                <form class="yourform" action="{{ route('book_issue.create') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Student Name</label>
                        <select class="form-control" name="student_id" required>
                            <option value="">Select Name</option>
                            @foreach ($students as $student)
                                <option value='{{ $student->id }}'>{{ $student->name }}</option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Book Name</label>
                        <select class="form-control" name="book_id" required>
                            <option value="">Select Name</option>
                            @foreach ($books as $book)
                                <option value='{{ $book->id }}'>{{ $book->name }}</option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <input type="submit" name="save" class="btn btn-danger" value="save">
                    <a href="{{ route('books') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection