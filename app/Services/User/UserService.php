<?php

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Services\ErrorLoggingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserService
{

    public function createUser(UserDTO $dto): ?User
    {
        DB::beginTransaction();
        try{
            $data=$dto->toArray();
            $data['password']=Hash::make($data['password']);
            $user= User::create($data);
            $user->assignRole($dto->role);
            DB::commit();
            return $user;

        }catch (\Throwable $e){

            DB::rollBack();
            ErrorLoggingService::log($e);
            return null;
        }
    }



    public function updateUser(User $user, UserDTO $dto)
    {
        $data = $dto->toArray();


        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);

        }

        $user->update($data);


        if ($dto->role && !$user->hasRole($dto->role)) {
            $user->syncRoles([$dto->role]);
        }

        return $user;
    }


}
