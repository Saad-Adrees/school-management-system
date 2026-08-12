<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create School Classes from Class 1 to Class 10
        for ($i = 1; $i <= 10; $i++) {
            SchoolClass::firstOrCreate([
                'name' => "Class {$i}",
            ]);
        }

        // 2. Admin User
        User::updateOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 3. Teacher User
        User::updateOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'Teacher User',
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]
        );

        // 4. Student User
        User::updateOrCreate(
            ['email' => 'student@school.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );
    }
}