<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'greghobelmann@gmail.com')->first();
        
        if ($user) {
            $user->update(['is_admin' => true]);
            $this->command->info('Admin status granted to: ' . $user->email);
        } else {
            $this->command->warn('User not found: greghobelmann@gmail.com');
            $this->command->info('Creating user...');
            
            $user = \App\Models\User::create([
                'name' => 'Greg Hobelmann',
                'email' => 'greghobelmann@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_admin' => true,
            ]);
            
            $this->command->info('Admin user created: ' . $user->email);
        }
    }
}
