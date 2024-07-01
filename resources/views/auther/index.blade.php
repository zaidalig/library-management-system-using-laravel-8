@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All Authors</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="{{ route('authors.create') }}">Add Author</a>
            </div>
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
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Author Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($authors as $auther)
                            <tr>
                                <td>{{ $auther->id }}</td>
                                <td>{{ $auther->name }}</td>
                                <td class="edit">
                                    <a href="{{ route('authors.edit', $auther) }}" class="btn btn-success">Edit</a>
                                </td>
                                <td class="delete">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger delete-author" data-toggle="modal"
                                        data-target="#deleteModal{{ $auther->id }}">
                                        Delete
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $auther->id }}" tabindex="-1"
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
                                                    Are you sure you want to delete this author?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('authors.destroy', $auther->id) }}" method="post"
                                                        class="form-hidden">
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
                                <td colspan="4">No Authors Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $authors->links('vendor/pagination/bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection