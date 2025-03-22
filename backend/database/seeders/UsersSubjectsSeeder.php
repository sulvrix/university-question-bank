<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_subject')->insert([
            [
                'user_id' => 6,
                'subject_id' => 20,
            ],
            [
                'user_id' => 7,
                'subject_id' => 21,
            ],
            [
                'user_id' => 8,
                'subject_id' => 22,
            ],
            [
                'user_id' => 9,
                'subject_id' => 23,
            ],
        ]);
    }
}
