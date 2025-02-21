<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Faculty;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(FacultiesTableSeeder::class);
        // User::factory(10)->create();

    }
}
