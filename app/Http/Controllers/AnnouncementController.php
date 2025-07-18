<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Events\AnnouncementCreated;

class AnnouncementController extends Controller
{
    /**
     * Admin: Show announcement management page
     */
    public function adminIndex()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('layouts.admin.announcement', compact('announcements'));
    }


    public function index()
    {
        $announcements = Announcement::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $announcements
        ]);
    }

    /**
     * Store a new announcement and broadcast
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'message'   => 'required|string',
            'is_active' => 'required|boolean'
        ]);

        $announcement = Announcement::create([
            'user_id'   => auth()->id(),
            'title'     => $request->title,
            'message'   => $request->message,
            'is_active' => $request->is_active
        ]);

        // Fire Event for Broadcasting
        event(new AnnouncementCreated($announcement));

        return response()->json([
            'success' => true,
            'message' => 'Announcement created successfully!',
            'data' => $announcement
        ]);
    }
}
