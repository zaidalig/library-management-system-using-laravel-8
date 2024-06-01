@extends('layouts.app')
@section('content')

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All Books</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="{{ route('book.create') }}">Add Book</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Book Name</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td class="id">{{ $book->id }}</td>
                                <td>{{ $book->name }}</td>
                                <td>{{ optional($book->category)->name }}</td>
                                <td>{{ optional($book->author)->name }}</td>
                                <td>{{ optional($book->publisher)->name }}</td>
                                <td>
                                    @if ($book->status == 'Y')
                                        <span class='badge badge-success'>Available</span>
                                    @else
                                        <span class='badge badge-danger'>Issued</span>
                                    @endif
                                </td>
                                <td class="edit">
                                    <a href="{{ route('book.edit', $book) }}" class="btn btn-success">Edit</a>
                                </td>
                                <td class="delete">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger delete-author" data-toggle="modal"
                                        data-target="#deleteModal{{ $book->id }}">
                                        Delete
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $book->id }}" tabindex="-1"
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
                                                    Are you sure you want to delete this book?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('book.destroy', $book) }}" method="post"
                                                        class="form-hidden">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No Books Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $books->links('vendor/pagination/bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Custom styles for the modal -->
<style>
    /* Ensure the modal backdrop has the correct color and z-index */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
        z-index: 1040 !important;
    }

    /* Ensure the modal itself is on top of the backdrop */
    .modal {
        z-index: 1050 !important;
    }
</style>
@endsection