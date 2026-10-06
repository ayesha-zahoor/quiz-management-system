<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SystemAdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('role_name', 'system_admin')->firstOrFail();

        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        if (! $adminEmail || ! $adminPassword) {
            throw new \RuntimeException('ADMIN_EMAIL and ADMIN_PASSWORD must be configured in .env.');
        }

        User::updateOrCreate(
            [
                'email' => $adminEmail,
            ],
            [
                'name' => env('ADMIN_NAME', 'System Admin'),
                'role_id' => $role->id,
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
            ],
        );
    }
}
