<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'              => 'Admin',
                'email'             => 'admin@app.com',
                'password'          => bcrypt('password'),
                'email_verified_at' => now(),
                'is_admin'          => true,
            ],
            [
                'name'              => 'User',
                'email'             => 'user@app.com',
                'password'          => bcrypt('password'),
                'email_verified_at' => now(),
                'is_admin'          => false,
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('User table seeded!');
    }
}
