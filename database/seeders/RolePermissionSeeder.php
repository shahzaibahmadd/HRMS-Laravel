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

            // Define roles
            $roleNames = ['Admin', 'HR', 'Manager', 'Employee'];
            $roles = [];

            foreach ($roleNames as $roleName) {
                $roles[$roleName] = Role::firstOrCreate(['name' => $roleName]);
            }

            // Define permission groups
            $permissionGroups = [
                'employee_permissions' => [
                    'manage employees' => ['HR'],
                    'approve leaves' => ['Manager'],
                    'view payroll' => ['Employee'],
                ],
                'payroll_permissions' => [
                    'view all payrolls' => ['Admin'],
                    'view hr and manager payrolls' => ['HR'],
                    'view employee payrolls' => ['Manager'],
                    'view own payroll' => ['Employee'],
                ],
                'dashboard_permissions' => [
                    'view all dashboards' => ['Admin'],
                    'view hr and below dashboards' => ['HR'],
                    'view manager and below dashboards' => ['Manager'],
                    'view own dashboard' => ['Employee'],
                ],
            ];

            // Create and assign permissions
            foreach ($permissionGroups as $group) {
                foreach ($group as $permission => $roleList) {
                    $perm = Permission::firstOrCreate(['name' => $permission]);

                    foreach ($roleList as $roleName) {
                        $roles[$roleName]->givePermissionTo($perm);
                    }
                }
            }

            // Create 2 dummy users for each role
            foreach ($roles as $roleName => $role) {
                for ($i = 1; $i <= 2; $i++) {
                    do {
                        $phone = '0300' . rand(1000000, 9999999);
                    } while (User::where('phone', $phone)->exists());

                    $user = User::create([
                        'name' => "$roleName User $i",
                        'email' => strtolower($roleName) . $i . '@gmail.com',
                        'phone' => $phone,
                        'password' => Hash::make('123456'),
                        'is_active' => true,
                    ]);

                    $user->assignRole($role);
                }
            }

            DB::commit();
            $this->command->info('✅ Roles, permissions, and users seeded successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->command->error('❌ Seeding failed: ' . $e->getMessage());
        }
    }
}
