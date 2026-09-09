<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'super.admin@gmail.com',
            'profile_picture' => null,
            'bio' => null,
            'role' => UserRole::SUPER_ADMIN->value,
            'email_verified_at' => now(),
            'password' => 'password', // Change this to a secure password
        ]);
    }
}
