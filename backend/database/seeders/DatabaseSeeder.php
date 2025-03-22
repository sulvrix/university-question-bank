<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UniversitiesTableSeeder::class);
        $this->call(FacultiesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(UsersSubjectsSeeder::class);


        // // Create 1 admin user
        // User::factory()
        //     ->admin()
        //     ->create();

        // // Create 10 staff users, each with a unique department
        // $departments = Department::all();
        // for ($i = 1; $i < 9; $i++) {
        //     User::factory()
        //         ->staff()
        //         ->state([
        //             'department_id' => $departments[$i % $departments->count()]->id,
        //         ])
        //         ->create();
        // }

        // // Create 10 commissioners, sharing the same departments as staff
        // for ($i = 1; $i < 9; $i++) {
        //     User::factory()
        //         ->commissioner()
        //         ->state([
        //             'department_id' => $departments[$i % $departments->count()]->id,
        //         ])
        //         ->create();
        // }

        // // Create 20 teachers, 2 in each department with different subjects
        // $subjects = Subject::all();
        // for ($i = 0; $i < 20; $i++) {
        //     User::factory()
        //         ->teacher()
        //         ->state([
        //             'department_id' => $departments[$i % $departments->count()]->id,
        //             'subject_id' => $subjects[$i % $subjects->count()]->id,
        //         ])
        //         ->create();
        // }
    }
}
