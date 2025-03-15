<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Sultan Salah',
                'username' => 'Sulvrix17',
                'email' => 'sultanbamarhool@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'admin',
                'status' => 'active',
                'department_id' => 1,
                'subject_id' => null,
            ],
            [
                'name' => 'Ahmed Qaraa',
                'username' => 'Ahmed17',
                'email' => 'ahmedqaraah2@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'staff',
                'status' => 'active',
                'department_id' => '2',
                'subject_id' => null,
            ],
            [
                'name' => 'Salem Maher',
                'username' => 'Salem',
                'email' => 'saloom1434@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'staff',
                'status' => 'active',
                'department_id' => '4',
                'subject_id' => null,
            ],
            [
                'name' => 'Ahmed Hussien',
                'username' => 'ahmed16',
                'email' => 'a.h.a.alaaji2000@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'staff',
                'status' => 'active',
                'department_id' => '5',
                'subject_id' => null,
            ],
            [
                'name' => 'Mazen Bahashwan',
                'username' => 'mazen17',
                'email' => 'mazen@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'teacher',
                'status' => 'active',
                'department_id' => '3',
                'subject_id' => '20',
            ],

        ]);
    }
}
