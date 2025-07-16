<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        DB::beginTransaction();

        try {

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


            $permissions = [
                'manage employees',
                'approve leaves',
                'view payroll',
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }


            $admin = Role::firstOrCreate(['name' => 'Admin']);
            $hr = Role::firstOrCreate(['name' => 'HR']);
            $manager = Role::firstOrCreate(['name' => 'Manager']);
            $employee = Role::firstOrCreate(['name' => 'Employee']);


            $hr->givePermissionTo('manage employees');
            $manager->givePermissionTo('approve leaves');
            $employee->givePermissionTo('view payroll');


            $roles = [
                'Admin' => $admin,
                'HR' => $hr,
                'Manager' => $manager,
                'Employee' => $employee,
            ];

            foreach ($roles as $roleName => $role) {
                for ($i = 1; $i <= 2; $i++) {
                    do {
                        $phone = '0300' . rand(1000000, 9999999);
                    } while (User::where('phone', $phone)->exists());

                    $user = User::create([
                        'name' => $roleName . ' User ' . $i,
                        'email' => strtolower($roleName) . $i . '@gmail.com',
                        'phone' => $phone,
                        'password' => Hash::make('123456'),
                        'is_active' => true,
                    ]);


                    $user->assignRole($role);
                }
            }


            DB::commit();
            $this->command->info('Roles, permissions, and users seeded successfully.');

        } catch (\Exception $e) {

            DB::rollBack();
            $this->command->error('Seeding failed: ' . $e->getMessage());
        }
    }
}
