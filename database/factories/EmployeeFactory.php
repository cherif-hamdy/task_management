<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'employee']),
            'manager_id' => Manager::factory()->create(),
            'department_id' => Department::factory(),
            'salary' => fake()->numberBetween(10000, 20000)
        ];
    }
}
