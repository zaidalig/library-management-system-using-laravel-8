@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Update Book</h2>
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
                <form class="yourform" action="{{ route('book.update', $book->id) }}" method="post" autocomplete="off">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label>Book Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Book Name" name="name" value="{{ old('name', $book->name) }}">
                        @error('name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $book->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <select class="form-control @error('auther_id') is-invalid @enderror" name="author_id">
                            <option value="">Select Author</option>
                            @foreach ($authors as $auther)
                                <option value="{{ $auther->id }}" {{ $auther->id == $book->auther_id ? 'selected' : '' }}>
                                    {{ $auther->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('auther_id')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Publisher</label>
                        <select class="form-control @error('publisher_id') is-invalid @enderror" name="publisher_id">
                            <option value="">Select Publisher</option>
                            @foreach ($publishers as $publisher)
                                <option value="{{ $publisher->id }}" {{ $publisher->id == $book->publisher_id ? 'selected' : '' }}>
                                    {{ $publisher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('publisher_id')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <input type="submit" name="save" class="btn btn-danger" value="Update">
                    <a href="{{ route('books') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection