@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All Categories</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="{{ route('category.create') }}">Add Category</a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Category Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td class="edit">
                                    <a href="{{ route('category.edit', $category) }}" class="btn btn-success">Edit</a>
                                </td>
                                <td class="delete">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger delete-author" data-toggle="modal"
                                        data-target="#deleteModal{{ $category->id }}">
                                        Delete
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this category?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('category.destroy', $category->id) }}"
                                                        method="post" class="form-hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No Category Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $categories->links('vendor/pagination/bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection