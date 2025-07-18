<?php

namespace App\DTOs\User;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;


class UserDTO extends BaseDTO
{

    public string $name;
    public string $email;
    public ?string $password;
    public string $phone;
    public bool $is_active;
    public ?string $profile_image;
    public string $role;

    public function __construct(Request $request,?string $profileImagePath=null)
    {
        $this->profile_image = $profileImagePath;
        $this->name=$request->name;
        $this->email=$request->email;
        $this->password = $request->filled('password') ? $request->password : null;
        $this->is_active=$request->has('is_active');
        $this->role=$request->role;
        $this->phone=$request->phone;

    }


}
