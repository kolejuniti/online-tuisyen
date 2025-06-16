<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\School;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the SchoolSeeder first
        $this->call(SchoolSeeder::class);

        // Get the first school for the student
        $school = School::first();

        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'user_type' => 'Admin',
            'password' => Hash::make('password'),
        ]);

        // Create a teacher user
        User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'user_type' => 'Teacher',
            'password' => Hash::make('password'),
        ]);

        // Create a student
        Student::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'school_id' => $school->id,
            'ic' => '000000000000', // Adding a dummy IC number
            'status' => 'active',
        ]);
    }
}
