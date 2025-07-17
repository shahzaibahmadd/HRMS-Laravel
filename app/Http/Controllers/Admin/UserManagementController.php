<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\ErrorLoggingService;
use App\Services\User\UserService;

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

}
