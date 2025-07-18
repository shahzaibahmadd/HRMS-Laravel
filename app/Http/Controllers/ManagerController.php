<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class ManagerController extends Controller
{
    /**
     * Show Manager Dashboard with live announcements
     */
    public function dashboard()
    {
        // Get all announcements, latest first
        $user=auth()->user();

        $announcements = Announcement::orderBy('created_at', 'desc')->get();

        return view('manager.dashboard', compact('announcements','user'));
    }
}
