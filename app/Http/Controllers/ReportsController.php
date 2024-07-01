<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\book_issue;
use Illuminate\Http\Request;
use Exception;

class ReportsController extends Controller
{
    public function index()
    {
        try {
            return view('report.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while loading the reports index.']);
        }
    }

    public function date_wise()
    {
        try {
            return view('report.dateWise', ['books' => '']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while loading the date-wise report.']);
        }
    }

    public function generate_date_wise_report(Request $request)
    {
        $request->validate(['date' => "required|date"]);
        try {
            return view('report.dateWise', [
                'books' => book_issue::where('issue_date', $request->date)->latest()->get()
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while generating the date-wise report.']);
        }
    }

    public function month_wise()
    {
        try {
            return view('report.monthWise', ['books' => '']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while loading the month-wise report.']);
        }
    }

    public function generate_month_wise_report(Request $request)
    {
        $request->validate(['month' => "required|date"]);
        try {
            return view('report.monthWise', [
                'books' => book_issue::where('issue_date', 'LIKE', '%' . $request->month . '%')->latest()->get(),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while generating the month-wise report.']);
        }
    }

    public function not_returned()
    {
        try {
            return view('report.notReturned', [
                'books' => book_issue::latest()->get()
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while loading the not-returned report.']);
        }
    }
}
