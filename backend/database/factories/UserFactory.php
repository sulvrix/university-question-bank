<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123123'), // Default password
            'role' => 'staff', // Default role
            'status' => 'active',
            'department_id' => Department::inRandomOrder()->first()->id,
            'subject_id' => null,
        ];
    }

    public function admin(): static
    {
        return $this->state([
            'role' => 'admin',
            'department_id' => Department::where('id', 1)->first()->id,
        ]);
    }

    public function staff(): static
    {
        return $this->state([
            'role' => 'staff',
        ]);
    }

    public function commissioner(): static
    {
        return $this->state([
            'role' => 'commissioner',
        ]);
    }

    public function teacher(): static
    {
        return $this->state([
            'role' => 'teacher',
            'subject_id' => Subject::inRandomOrder()->first()->id,
        ]);
    }
}
