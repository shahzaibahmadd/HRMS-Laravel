<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\ErrorLoggingService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Storage;


class UserManagementController extends Controller
{
    protected $userservice;
    public function __construct(UserService $userservice){
        $this->userservice=$userservice;
    }
    public function create()
    {
        return view('admin.create');
    }
    public function store(StoreUserRequest $request){
        try {

            $profileImagePath=null;
            if ($request->hasFile('profile_image')) {
                $profileImagePath=$request->file('profile_image')->store('user_images', 'public');
            }

            $userDTO=new UserDTO($request,$profileImagePath);
            $user=$this->userservice->createUser($userDTO);
            return redirect()->route('admin.dashboard')->with('Success', 'User added successfully');
        }catch (\Throwable $e){

            ErrorLoggingService::log($e);
            return redirect()->back()->with('Error', 'Something went wrong');
        }
    }
    public function listHR(){
        $hrs=User::role('HR')->get();
        return view('admin.users.hr',compact('hrs'));

    }
    public function listManagers(){

        $managers=User::role('Manager')->get();
        return view('admin.users.manager',compact('managers'));
    }
    public function listEmployees(){
        $employees=User::role('Employee')->get();
        return view('admin.users.employee',compact('employees'));
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
            if ($user->hasRole('HR')) {
                return view('hr.dashboard', ['user' => $user]);
            } elseif ($user->hasRole('Manager')) {
                return view('manager.dashboard', ['user' => $user]);
            } elseif ($user->hasRole('Employee')) {
                return view('employee.dashboard', ['user' => $user]);
            } else {
                abort(403, 'User has no valid dashboard.');
            }
        } catch (\Throwable $th) {

            Log::error('Dashboard access failed: ' . $th->getMessage());
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


            $userDTO = new UserDTO($request, $profileImagePath);


            $this->userservice->updateUser($user, $userDTO);

            return redirect()->route('admin.users.' . strtolower($user->getRoleNames()->first()))
                ->with('Success', 'User updated successfully');
        } catch (\Throwable $e) {
            ErrorLoggingService::log($e);
            return redirect()->back()->with('Error', 'Something went wrong during update');
        }
    }


}
