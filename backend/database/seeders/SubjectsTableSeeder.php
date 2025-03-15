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
            //Human Medecine
            // Level 1 Subjects
            [
                'name' => 'Introduction to Medicine and Emergency',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Human and Environment',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Motherhood and Childhood',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Arabic Language (1)',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Arabic Language (2)',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'English Language (1)',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'English Language (2)',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Computer Skills',
                'level' => '1',
                'department_id' => 2
            ],
            [
                'name' => 'Communication Skills',
                'level' => '1',
                'department_id' => 2
            ],

            // Level 2 Subjects
            [
                'name' => 'Infection, Inflammation, and Tumors',
                'level' => '2',
                'department_id' => 2
            ],
            [
                'name' => 'Blood Disorders, Immunity, and the Lymphatic System',
                'level' => '2',
                'department_id' => 2
            ],
            [
                'name' => 'Circulatory and Respiratory Systems (Specialization)',
                'level' => '2',
                'department_id' => 2
            ],
            [
                'name' => 'Community Medicine and Field Research Project',
                'level' => '2',
                'department_id' => 2
            ],
            [
                'name' => 'Islamic Culture (1)',
                'level' => '2',
                'department_id' => 2
            ],
            [
                'name' => 'Islamic Culture (2)',
                'level' => '2',
                'department_id' => 2
            ],

            // Level 3 Subjects
            [
                'name' => 'Digestive and Motor Systems',
                'level' => '3',
                'department_id' => 2
            ],
            [
                'name' => 'Nervous System',
                'level' => '3',
                'department_id' => 2
            ],
            [
                'name' => 'Urinary System and Endocrinology',
                'level' => '3',
                'department_id' => 2
            ],
            [
                'name' => 'Community Medicine and Field Research Project (2)',
                'level' => '3',
                'department_id' => 2
            ],

            //Computer Engineering
            [
                'name' => 'Microprocessors Systems',
                'level' => '3',
                'department_id' => 4
            ],
        ]);
    }
}
