<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('universities')->insert([
            [
                'name' => 'Administration',
            ],
            [
                'name' => 'Hadhramaut University',
            ],
            [
                'name' => 'Al-Arab University',
            ]

        ]);
    }
}
