@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="admin-heading">All Students</h2>
            </div>
            <div class="offset-md-6 col-md-2">
                <a class="add-new" href="{{ route('student.create') }}">Add Student</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Student Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td class="id">{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td class="text-capitalize">{{ $student->gender }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->email }}</td>
                                <td class="view">
                                    <button data-sid='{{ $student->id }}' class="btn btn-primary view-btn">View</button>
                                </td>
                                <td class="edit">
                                    <a href="{{ route('student.edit', $student) }}" class="btn btn-success">Edit</a>
                                </td>
                                <td class="delete">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger delete-student" data-toggle="modal"
                                        data-target="#deleteModal{{ $student->id }}">
                                        Delete
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1"
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
                                                    Are you sure you want to delete this student?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('student.destroy', $student) }}" method="post"
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
                                <td colspan="8">No Students Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $students->links('vendor/pagination/bootstrap-4') }}
                <div id="modal">
                    <div id="modal-form">
                        <table cellpadding="10px" width="100%">
                        </table>
                        <div id="close-btn">X</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript">
    //Show student detail
    $(".view-btn").on("click", function () {
        var student_id = $(this).data("sid");
        $.ajax({
            url: "/student/show/" + student_id,
            type: "GET",
            success: function (student) {
                console.log(student);
                var form = "<tr><td>Student Name :</td><td><b>" + student['name'] + "</b></td></tr><tr><td>Address :</td><td><b>" + student['address'] + "</b></td></tr><tr><td>Gender :</td><td><b>" + student['gender'] + "</b></td></tr><tr><td>Class :</td><td><b>" + student['class'] + "</b></td></tr><tr><td>Age :</td><td><b>" + student['age'] + "</b></td></tr><tr><td>Phone :</td><td><b>" + student['phone'] + "</b></td></tr><tr><td>Email :</td><td><b>" + student['email'] + "</b></td></tr>";
                console.log(form);

                $("#modal-form table").html(form);
                $("#modal").show();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    });

    //Hide modal box
    $('#close-btn').on("click", function () {
        $("#modal").hide();
    });

    //delete student script
    $(".delete-student").on("click", function () {
        var s_id = $(this).data("sid");
        $.ajax({
            url: "delete-student.php",
            type: "POST",
            data: {
                sid: s_id
            },
            success: function (data) {
                $(".message").html(data);
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            }
        });
    });
</script>
@endsection
