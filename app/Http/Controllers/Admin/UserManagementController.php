<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Announcement;
use App\Models\User;
use App\Services\ErrorLoggingService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    protected $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            // Profile Image
            $profileImagePath = null;
            if ($request->hasFile('profile_image')) {
                $profileImagePath = $request->file('profile_image')->store('user_images', 'public');
            }

            // Documents
            $documentsPath = null;
            if ($request->hasFile('documents')) {
                $documentsPath = $request->file('documents')->store('user_documents', 'public');
            }

            // Resume
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('user_resumes', 'public');
            }

            // Contract
            $contractPath = null;
            if ($request->hasFile('contract')) {
                $contractPath = $request->file('contract')->store('user_contracts', 'public');
            }

            // Prepare DTO with all data
            $userDTO = new UserDTO(
                $request,
                $profileImagePath,
                $request->skills,
                $documentsPath,
                $resumePath,
                $contractPath
            );

            $this->userservice->createUser($userDTO);

            return redirect()->route('admin.dashboard')->with('Success', 'User added successfully');
        } catch (\Throwable $e) {
            ErrorLoggingService::log($e);
            return redirect()->back()->with('Error', 'Something went wrong');
        }
    }

    public function listHR()
    {
        $hrs = User::role('HR')->get();
        $deletedHR = User::role('HR')->onlyTrashed()->get();
        return view('admin.users.hr', compact('hrs', 'deletedHR'));
    }

    public function listManagers()
    {
        $managers = User::role('Manager')->get();
        $deletedManagers = User::role('Manager')->onlyTrashed()->get();
        return view('admin.users.manager', compact('managers', 'deletedManagers'));
    }

    public function listEmployees()
    {
        $employees = User::role('Employee')->get();
        $deletedEmployees = User::role('Employee')->onlyTrashed()->get();
        return view('admin.users.employee', compact('employees', 'deletedEmployees'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function profile(User $user)
    {
        return view('admin.users.profile', compact('user'));
    }

    public function dashboardRedirect(User $user)
    {
        try {
            $announcements = Announcement::where('is_active', 1)
                ->orderBy('created_at', 'desc')
                ->get();
            if ($user->hasRole('HR')) {
                return view('hr.dashboard', ['user' => $user, 'announcements' => $announcements]);
            } elseif ($user->hasRole('Manager')) {
                return view('manager.dashboard', ['user' => $user, 'announcements' => $announcements]);
            } elseif ($user->hasRole('Employee')) {
                return view('employee.dashboard', ['user' => $user, 'announcements' => $announcements]);
            } else {
                abort(403, 'User has no valid dashboard.');
            }
        } catch (\Throwable $th) {
            \Log::error('Dashboard access failed: ' . $th->getMessage());
            abort(500, 'Internal server error.');
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $profileImagePath = $user->profile_image;
            if ($request->hasFile('profile_image')) {
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                }
                $profileImagePath = $request->file('profile_image')->store('user_images', 'public');
            }

            // Documents
            $documentsPath = $user->documents;
            if ($request->hasFile('documents')) {
                if ($user->documents && Storage::disk('public')->exists($user->documents)) {
                    Storage::disk('public')->delete($user->documents);
                }
                $documentsPath = $request->file('documents')->store('user_documents', 'public');
            }

            // Resume
            $resumePath = $user->resume;
            if ($request->hasFile('resume')) {
                if ($user->resume && Storage::disk('public')->exists($user->resume)) {
                    Storage::disk('public')->delete($user->resume);
                }
                $resumePath = $request->file('resume')->store('user_resumes', 'public');
            }

            // Contract
            $contractPath = $user->contract;
            if ($request->hasFile('contract')) {
                if ($user->contract && Storage::disk('public')->exists($user->contract)) {
                    Storage::disk('public')->delete($user->contract);
                }
                $contractPath = $request->file('contract')->store('user_contracts', 'public');
            }

            $userDTO = new UserDTO(
                $request,
                $profileImagePath,
                $request->skills,
                $documentsPath,
                $resumePath,
                $contractPath
            );

            $this->userservice->updateUser($user, $userDTO);

            return redirect()->route('admin.users.' . strtolower($user->getRoleNames()->first()))
                ->with('Success', 'User updated successfully');
        } catch (\Throwable $e) {
            ErrorLoggingService::log($e);
            return redirect()->back()->with('Error', 'Something went wrong during update');
        }
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('Admin')) {
            return redirect()->back()->with('Error', 'Admin user cannot be deleted.');
        }

        $user->delete();
        return redirect()->back()->with('Success', 'User deleted successfully.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if (!$user->trashed()) {
            return redirect()->back()->with('Info', 'User is already active.');
        }

        $user->restore();
        return redirect()->back()->with('Success', 'User restored successfully.');
    }
}
