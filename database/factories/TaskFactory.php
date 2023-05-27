<?php

namespace Database\Factories;

use App\Enums\RepetetionTypeEnum;
use App\Enums\TaskTypeEnum;
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
            'user_id' => 1,
            'group' => null,
            'title' => 'Test Task',
            'description' => 'Test Description',
            'repetetion_type' => RepetetionTypeEnum::daily->value,
            'task_type' => TaskTypeEnum::dates->value,
            'no_of_iterations' => 1,
            'selected_days' => [],
            'selected_month' => null,
            'selected_date' => null,
            'from_date' => $this->faker->date('Y-m-d', '27-05-2023'),
            'to_date' => $this->faker->date('Y-m-d', '28-05-2023'),
            'completed' => false,
        ];
    }
}
