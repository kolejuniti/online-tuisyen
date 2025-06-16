<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'name' => 'SMK Taman Desa',
            'address' => '123 Taman Desa, 12345 Kuala Lumpur',
            'phone' => '03-12345678',
            'status' => 'active',
        ]);

        School::create([
            'name' => 'SK Bangsar',
            'address' => '456 Bangsar, 56789 Kuala Lumpur',
            'phone' => '03-87654321',
            'status' => 'active',
        ]);
    }
}
