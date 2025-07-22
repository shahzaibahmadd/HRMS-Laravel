<?php

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Services\ErrorLoggingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class UserService
{
    public function createUser(UserDTO $dto): ?User
    {
        DB::beginTransaction();
        try {
            $data = $dto->toArray();

            // Handle File Uploads
            if ($dto->documents instanceof \Illuminate\Http\UploadedFile) {
                $data['documents'] = $dto->documents->store('user_documents', 'public');
            }

            if ($dto->resume instanceof \Illuminate\Http\UploadedFile) {
                $data['resume'] = $dto->resume->store('user_resumes', 'public');
            }

            if ($dto->contract instanceof \Illuminate\Http\UploadedFile) {
                $data['contract'] = $dto->contract->store('user_contracts', 'public');
            }

            // Hash password
            $data['password'] = Hash::make($data['password']);

            // Create User
            $user = User::create($data);

            // Assign Role
            $user->assignRole($dto->role);

            DB::commit();

            // Send Welcome Email
            Mail::to($user->email)->queue(new WelcomeEmail($user));

            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            ErrorLoggingService::log($e);
            return null;
        }
    }

    public function updateUser(User $user, UserDTO $dto)
    {
        $data = $dto->toArray();

        // Handle password
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Handle File Updates
        if ($dto->documents instanceof \Illuminate\Http\UploadedFile) {
            if ($user->documents && Storage::disk('public')->exists($user->documents)) {
                Storage::disk('public')->delete($user->documents);
            }
            $data['documents'] = $dto->documents->store('user_documents', 'public');
        }

        if ($dto->resume instanceof \Illuminate\Http\UploadedFile) {
            if ($user->resume && Storage::disk('public')->exists($user->resume)) {
                Storage::disk('public')->delete($user->resume);
            }
            $data['resume'] = $dto->resume->store('user_resumes', 'public');
        }

        if ($dto->contract instanceof \Illuminate\Http\UploadedFile) {
            if ($user->contract && Storage::disk('public')->exists($user->contract)) {
                Storage::disk('public')->delete($user->contract);
            }
            $data['contract'] = $dto->contract->store('user_contracts', 'public');
        }

        // Update User
        $user->update($data);

        // Sync Roles if changed
        if ($dto->role && !$user->hasRole($dto->role)) {
            $user->syncRoles([$dto->role]);
        }

        return $user;
    }
}
