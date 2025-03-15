<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faculties')->insert([
            [
                'name' => 'Administration',
                'university_id' => '1',
            ],
            [
                'name' => 'Faculty of Medicine',
                'university_id' => '2',
            ],
            [
                'name' => 'Faculty of Engineering',
                'university_id' => '2',
            ],

        ]);
    }
}
