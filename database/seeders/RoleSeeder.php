<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['system_admin', 'institute_admin', 'teacher', 'student'] as $roleName) {
            DB::table('roles')->updateOrInsert(
                ['role_name' => $roleName],
                ['role_name' => $roleName],
            );
        }
    }
}
