<?php

namespace App\Http\Controllers;

use App\Http\Requests\changePasswordRequest;
use App\Models\auther;
use App\Models\book;
use App\Models\book_issue;
use App\Models\category;
use App\Models\publisher;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class dashboardController extends Controller
{
    public function index()
    {
        try {
            return view('dashboard', [
                'authors' => auther::count(),
                'publishers' => publisher::count(),
                'categories' => category::count(),
                'books' => book::count(),
                'students' => student::count(),
                'issued_books' => book_issue::count(),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while fetching dashboard data.']);
        }
    }

    public function change_password_view()
    {
        try {
            return view('reset_password');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while preparing to change the password.']);
        }
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'c_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        try {
            $user = Auth::user();

            if (password_verify($request->c_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return redirect()->route("dashboard")->with('success', 'Password changed successfully');
            } else {
                return redirect()->back()->withErrors(['c_password' => 'Old password is incorrect']);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while changing the password.']);
        }
    }
}
