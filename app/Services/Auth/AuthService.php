<?php

namespace App\Services\Auth;

use App\DTOs\Auth\LoginDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
     public function login(LoginDTO $dto):User
     {
          $credentials =[
              'email' => $dto->email,
              'password' => $dto->password,
          ];
          if(Auth::attempt($credentials)){
              return Auth::user();
          }
          throw ValidationException::withMessages([
              'email' =>['The provided credentials do not match our records.'],
          ]);
     }
     public function logout(){
         Auth::logout();
     }
}
