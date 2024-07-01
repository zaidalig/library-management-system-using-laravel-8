<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Http\Requests\StorestudentRequest;
use App\Http\Requests\UpdatestudentRequest;
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('student.index', [
                'students' => student::Paginate(5)
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while fetching students.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('student.create');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to create a student.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorestudentRequest $request)
    {
        try {
            student::create($request->validated());
            return redirect()->route('students');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while storing the student.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $student = student::find($id)->first();
            return $student;
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while fetching the student.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(student $student)
    {
        try {
            return view('student.edit', [
                'student' => $student
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to edit the student.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatestudentRequest $request, $id)
    {
        try {
            $student = student::find($id);
            $student->name = $request->name;
            $student->address = $request->address;
            $student->gender = $request->gender;
            $student->class = $request->class;
            $student->age = $request->age;
            $student->phone = $request->phone;
            $student->email = $request->email;
            $student->save();
            return redirect()->route('students');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the student.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            student::find($id)->delete();
            return redirect()->route('students');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the student.']);
        }
    }
}
