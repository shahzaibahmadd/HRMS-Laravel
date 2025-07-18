<?php

namespace App\Http\Controllers;

use App\DTOs\Auth\LoginDTO;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function showLoginForm(){


        return $this->authService->AlreadyLoggedIn();

    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $dto= new LoginDTO($request);

        $user=$this->authService->login($dto);

        if($user->hasRole('Admin')){
            return redirect()->route('admin.dashboard');
        }
        if($user->hasRole('Employee')){
            return redirect()->route('employee.dashboard');
        }
        if($user->hasRole('Manager')){
            return redirect()->route('manager.dashboard');
        }
        if($user->hasRole('HR')){
            return redirect()->route('hr.dashboard');
        }


        return redirect()->route('dashboard');


    }


    public function logout(){
        $this->authService->logout();
        return redirect()->route('login');
    }

}
