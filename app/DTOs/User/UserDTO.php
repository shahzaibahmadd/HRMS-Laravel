<?php

namespace App\DTOs\User;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UserDTO extends BaseDTO
{
    public string $name;
    public string $email;
    public ?string $password;
    public ?string $phone;
    public bool $is_active;
    public ?string $profile_image;
    public string $role;

    // New Fields
    public ?string $skills;
    public ?string $documents;
    public ?string $resume;
    public ?string $contract;

    public function __construct(
        Request $request,
        ?string $profileImagePath = null,
        ?string $skills = null,
        ?string $documentsPath = null,
        ?string $resumePath = null,
        ?string $contractPath = null
    ) {
        $this->profile_image = $profileImagePath;
        $this->name          = $request->name;
        $this->email         = $request->email;
        $this->password      = $request->filled('password') ? $request->password : null;
        $this->is_active     = (bool)$request->is_active; // Ensure it's cast to boolean
        $this->role          = $request->role;
        $this->phone         = $request->phone;

        // New properties
        $this->skills        = $skills ?? $request->skills;
        $this->documents     = $documentsPath;
        $this->resume        = $resumePath;
        $this->contract      = $contractPath;
    }
}
