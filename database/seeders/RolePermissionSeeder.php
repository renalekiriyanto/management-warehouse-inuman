<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Admin',
            'Reporting Manager',
            'Facility Lead',
            'Operator',
            'Admin'
        ];

        foreach($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }
    }
}
