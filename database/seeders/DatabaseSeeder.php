<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserType;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'user_type' => UserType::SUPER_ADMIN,
                'password' => Hash::make('12345678'),
                'is_active' => true,
                'email_verified_at' => now()
            ]
        );
        $this->call([
            StatesSeeder::class,
            DocumentTypesSeeder::class,
            LicenseTypesSeeder::class,
            RolesSeeder::class,
            SpecialtiesSeeder::class,
        ]);
    }
}
