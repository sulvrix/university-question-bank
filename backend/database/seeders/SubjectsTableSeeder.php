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
                'name' => 'Introduction to medicine and emergency',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Human and environment',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Computer Science',
                'level' => '1',
                'department_id' => 4
            ],
            [
                'name' => 'Data Structure',
                'level' => '1',
                'department_id' => 4
            ],
        ]);
    }
}
