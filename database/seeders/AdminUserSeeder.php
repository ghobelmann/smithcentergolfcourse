<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the admin user
        User::updateOrCreate(
            ['email' => 'greghobelmann@gmail.com'],
            [
                'name' => 'Greg Hobelmann',
                'email' => 'greghobelmann@gmail.com',
                'password' => Hash::make('password123'), // Change this to a secure password
                'is_admin' => true,
                'handicap' => 10,
                'home_course' => 'SC Golf Club',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created/updated: greghobelmann@gmail.com');
    }
}
