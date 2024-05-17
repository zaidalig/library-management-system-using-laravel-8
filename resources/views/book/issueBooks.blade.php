@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All Book Issue</h2>
            </div>
            <div class="offset-md-6 col-md-3">
                <a class="add-new" href="{{ route('book_issue.create') }}">Add Book Issue</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Student Name</th>
                        <th>Book Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr
                                style='@if (date('Y-m-d') > $book->return_date->format('d-m-Y') && $book->issue_status == 'N') ) background:rgba(255,0,0,0.2) @endif'>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->student->name }}</td>
                                <td>{{ $book->book->name }}</td>
                                <td>{{ $book->student->phone }}</td>
                                <td>{{ $book->student->email }}</td>
                                <td>{{ $book->issue_date->format('d M, Y') }}</td>
                                <td>{{ $book->return_date->format('d M, Y') }}</td>
                                <td>
                                    @if ($book->issue_status == 'Y')
                                        <span class='badge badge-success'>Returned</span>
                                    @else
                                        <span class='badge badge-danger'>Issued</span>
                                    @endif
                                </td>
                                <td class="edit">
                                    <a href="{{ route('book_issue.edit', $book->id) }}" class="btn btn-success">Edit</a>
                                </td>
                                <td class="delete">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger delete-author" data-toggle="modal"
                                        data-target="#deleteModal{{ $book }}">
                                        Delete
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $book }}" tabindex="-1"
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
                                                    Are you sure you want to delete this record?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('book_issue.destroy', $book) }}" method="post"
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
                                <td colspan="10">No Books Issued</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $books->links('vendor/pagination/bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection