<?php

namespace App\DTOs\Auth;

class LoginDTO
{
    public string $email;
    public string $password;
   public function __construct($request){
       $this->email = $request->email;
       $this->password = $request->password;
   }
}
