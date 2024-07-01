<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('category.index', [
                'categories' => category::Paginate(5)
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while fetching categories.']);
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
            return view('category.create');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to create a category.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecategoryRequest $request)
    {
        try {
            category::create($request->validated());
            return redirect()->route('categories');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while storing the category.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        try {
            return view('category.edit', [
                'category' => $category
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to edit the category.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecategoryRequest  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecategoryRequest $request, $id)
    {
        try {
            $category = category::find($id);
            $category->name = $request->name;
            $category->save();

            return redirect()->route('categories');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the category.']);
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
            category::find($id)->delete();
            return redirect()->route('categories');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the category.']);
        }
    }
}
