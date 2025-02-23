<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'name' => 'Anatomy',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Physics',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Chemistry',
                'level' => '1',
                'department_id' => 4
            ],
            [
                'name' => 'Computer Science',
                'level' => '1',
                'department_id' => 4
            ],
        ]);
    }
}
