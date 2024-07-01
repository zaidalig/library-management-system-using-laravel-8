<?php

namespace App\Http\Controllers;

use App\Models\publisher;
use App\Http\Requests\StorepublisherRequest;
use App\Http\Requests\UpdatepublisherRequest;
use Exception;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('publisher.index', [
                'publishers' => publisher::Paginate(5)
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while fetching publishers.']);
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
            return view('publisher.create');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to create a publisher.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepublisherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepublisherRequest $request)
    {
        try {
            publisher::create($request->validated());
            return redirect()->route('publishers');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while storing the publisher.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(publisher $publisher)
    {
        try {
            return view('publisher.edit', [
                'publisher' => $publisher
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to edit the publisher.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepublisherRequest  $request
     * @param  \App\Models\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepublisherRequest $request, $id)
    {
        try {
            $publisher = publisher::find($id);
            $publisher->name = $request->name;
            $publisher->save();
            return redirect()->route('publishers');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the publisher.']);
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
            publisher::find($id)->delete();
            return redirect()->route('publishers');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the publisher.']);
        }
    }
}
