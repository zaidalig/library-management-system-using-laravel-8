<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Http\Requests\StorebookRequest;
use App\Http\Requests\UpdatebookRequest;
use App\Models\auther;
use App\Models\category;
use App\Models\publisher;
use Exception;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('book.index', [
                'books' => book::Paginate(5)
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while fetching books.']);
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
            return view('book.create', [
                'authors' => auther::latest()->get(),
                'publishers' => publisher::latest()->get(),
                'categories' => category::latest()->get(),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to create a book.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorebookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorebookRequest $request)
    {
        try {
            book::create($request->validated() + [
                'status' => 'Y'
            ]);
            return redirect()->route('books')->with('success', 'Book created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while storing the book.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(book $book)
    {
        try {
            return view('book.edit', [
                'authors' => auther::latest()->get(),
                'publishers' => publisher::latest()->get(),
                'categories' => category::latest()->get(),
                'book' => $book
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to edit the book.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatebookRequest  $request
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatebookRequest $request, $id)
    {
        try {
            $book = book::find($id);
            $book->name = $request->name;
            $book->auther_id = $request->author_id;
            $book->category_id = $request->category_id;
            $book->publisher_id = $request->publisher_id;
            $book->save();
            return redirect()->route('books')->with('success', 'Book updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the book.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            book::find($id)->delete();
            return redirect()->route('books')->with('success', 'Book deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the book.']);
        }
    }
}
