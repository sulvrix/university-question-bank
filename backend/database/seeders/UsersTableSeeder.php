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
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'admin',
                'status' => 'active',
                'department_id' => '1',
            ],
            [
                'name' => 'Sultan Salah',
                'username' => 'Sulvrix17',
                'email' => 'sultanbamarhool@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'admin',
                'status' => 'active',
                'department_id' => 1,
            ],
            [
                'name' => 'Ahmed Qaraa',
                'username' => 'Ahmed17',
                'email' => 'ahmedqaraah2@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'staff',
                'status' => 'active',
                'department_id' => 2,
            ],
            [
                'name' => 'Salem Maher',
                'username' => 'Salem',
                'email' => 'saloom1434@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'staff',
                'status' => 'active',
                'department_id' => 4,
            ],
            [
                'name' => 'Ahmed Hussien',
                'username' => 'ahmed16',
                'email' => 'a.h.a.alaaji2000@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'staff',
                'status' => 'active',
                'department_id' => 4,
            ],
            [
                'name' => 'Mazen Bahashwan',
                'username' => 'mazen17',
                'email' => 'mazen@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'teacher',
                'status' => 'active',
                'department_id' => 4,
            ],
            [
                'name' => 'Rasha Bin Thalaab',
                'username' => 'rasha',
                'email' => 'rasha@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'teacher',
                'status' => 'active',
                'department_id' => 4,
            ],
            [
                'name' => 'Makarem Bamatraf',
                'username' => 'makarem',
                'email' => 'makarem@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'teacher',
                'status' => 'active',
                'department_id' => 4,
            ],
            [
                'name' => 'Wadhah Alssabti',
                'username' => 'wadhah',
                'email' => 'wadah@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'teacher',
                'status' => 'active',
                'department_id' => 4,
            ],
            [
                'name' => 'Computer Engineering Staff',
                'username' => 'staff1',
                'email' => 'staff1@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'staff',
                'status' => 'active',
                'department_id' => 4,
            ],
            [
                'name' => 'Medicine Staff',
                'username' => 'staff2',
                'email' => 'staff2@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'staff',
                'status' => 'active',
                'department_id' => 2,
            ],
            [
                'name' => 'Computer Engineering Commissioner',
                'username' => 'com1',
                'email' => 'com1@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'commissioner',
                'status' => 'active',
                'department_id' => 4,
            ],
            [
                'name' => 'Medicine Commissioner',
                'username' => 'com2',
                'email' => 'com2@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123123'),
                'role' => 'commissioner',
                'status' => 'active',
                'department_id' => 2,
            ],
        ]);
    }
}
