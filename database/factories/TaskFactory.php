<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory()->create()->id,
            'manager_id' => Manager::factory()->create()->id,
            'title' => fake()->name(),
            'description' => fake()->text(),
            'status' => fake()->randomElement(['to do', 'in progress', 'done'])
        ];
    }
}
