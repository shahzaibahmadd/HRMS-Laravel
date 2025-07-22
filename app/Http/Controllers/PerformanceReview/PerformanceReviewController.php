<?php

namespace App\Http\Controllers\PerformanceReview;

use App\DTOs\PerformanceReview\PerformanceReviewDTO;
use App\Http\Controllers\Controller;
use App\Mail\PerformanceReviewMail;
use App\Models\PerformanceReview;
use App\Models\User;
use App\Services\PerformanceReview\PerformanceReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;   // <-- MISSING BEFORE

class PerformanceReviewController extends Controller
{
    protected PerformanceReviewService $reviewService;

    public function __construct(PerformanceReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $reviews = PerformanceReview::with('user')->latest()->get();
        } elseif ($user->hasRole('HR')) {
            // HR can see Managers + Employees
            $reviews = PerformanceReview::with('user')
                ->whereHas('user', fn ($q) => $q->role(['Manager', 'Employee']))
                ->get();
        } elseif ($user->hasRole('Manager')) {
            // Manager sees Employees
            $reviews = PerformanceReview::with('user')
                ->whereHas('user', fn ($q) => $q->role('Employee'))
                ->get();
        } else {
            // Employee sees only their own
            $reviews = PerformanceReview::with('user')
                ->where('user_id', $user->id)
                ->get();
        }

        return view('performance_reviews.index', compact('reviews', 'user'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $users = User::role(['HR', 'Manager', 'Employee'])->get();
        } elseif ($user->hasRole('HR')) {
            $users = User::role(['Manager', 'Employee'])->get();
        } elseif ($user->hasRole('Manager')) {
            $users = User::role(['Employee'])->get();
        } else {
            abort(403);
        }

        return view('performance_reviews.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'feedback'    => 'nullable|string',
            'review_date' => 'required|date',
        ]);

        $rating = $this->reviewService->calculateRatingFromTasks($request->user_id);

        $dto = new PerformanceReviewDTO(
            user_id: $request->user_id,
            rating: $rating,
            feedback: $request->feedback,
            review_date: $request->review_date,
        );

        $this->reviewService->create($dto);

        return redirect()->route('performance.index')->with('success', 'Review created.');
    }

    public function edit(PerformanceReview $performanceReview)
    {
        return view('performance_reviews.edit', compact('performanceReview'));
    }

    public function update(Request $request, PerformanceReview $performanceReview)
    {
        $request->validate([
            'feedback'    => 'nullable|string',
            'review_date' => 'required|date',
        ]);

        $dto = new PerformanceReviewDTO(
            user_id: $performanceReview->user_id,
            rating: $this->reviewService->calculateRatingFromTasks($performanceReview->user_id),
            feedback: $request->feedback,
            review_date: $request->review_date,
        );

        $this->reviewService->update($performanceReview, $dto);

        return redirect()->route('performance.index')->with('success', 'Review updated.');
    }

    public function destroy(PerformanceReview $performanceReview)
    {
        try {
            $performanceReview->delete();

            if (PerformanceReview::find($performanceReview->id)) {
                return back()->with('error', 'Failed to delete the review.');
            }

            return redirect()->route('performance.index')->with('success', 'Review deleted.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Send a performance review email to a single user.
     * POST route: performance.sendReminders
     * Expects: review_id in the request.
     */
    public function sendReminders(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:performance_reviews,id',
        ]);

        $review = PerformanceReview::with('user')->findOrFail($request->review_id);
        $user   = $review->user;

        Mail::to($user->email)->send(new PerformanceReviewMail($review));

        return redirect()->back()->with('success', 'The performance review has been emailed to ' . $user->email . '.');
    }
}
