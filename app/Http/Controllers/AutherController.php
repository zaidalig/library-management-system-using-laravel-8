<?php

namespace App\Http\Controllers;

use App\Models\auther;
use App\Http\Requests\StoreautherRequest;
use App\Http\Requests\UpdateautherRequest;
use Exception;

class AutherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('auther.index', [
                'authors' => auther::Paginate(5)
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while fetching authors.']);
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
            return view('auther.create');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to create an author.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreautherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreautherRequest $request)
    {
        try {
            auther::create($request->validated());
            return redirect()->route('authors')->with('success', 'Author created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while storing the author.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\auther  $auther
     * @return \Illuminate\Http\Response
     */
    public function edit(auther $auther)
    {
        try {
            return view('auther.edit', [
                'auther' => $auther
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to edit the author.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateautherRequest  $request
     * @param  \App\Models\auther  $auther
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateautherRequest $request, $id)
    {
        try {
            $auther = auther::find($id);
            $auther->name = $request->name;
            $auther->save();
            return redirect()->route('authors')->with('success', 'Author Updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the author.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $author = auther::findOrFail($id);
            $author->delete();
            return redirect()->route('authors')->with('success', 'Author deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error', 'An error occurred while deleting the author.']);
        }
    }

}
