<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'description' => 'Full system access',
                'is_active' => true,
            ],
            [
                'name' => 'Organization Admin',
                'slug' => 'organization_admin',
                'description' => 'Organization administrator',
                'is_active' => true,
            ],
            [
                'name' => 'Doctor',
                'slug' => 'doctor',
                'description' => 'Medical doctor/provider',
                'is_active' => true,
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Organization staff member',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
