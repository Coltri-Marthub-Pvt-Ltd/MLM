<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
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
        $taskTitles = [
            'Complete monthly sales report',
            'Update customer database',
            'Prepare presentation for client meeting',
            'Review and approve marketing materials',
            'Conduct team performance evaluations',
            'Organize office inventory',
            'Update project documentation',
            'Schedule team building activities',
            'Research new software tools',
            'Follow up with pending customers',
            'Prepare budget analysis report',
            'Update company handbook',
            'Review vendor contracts',
            'Coordinate with IT department',
            'Plan quarterly meeting agenda',
            'Update social media content',
            'Analyze competitor pricing',
            'Prepare training materials',
            'Review quality control processes',
            'Update safety protocols'
        ];

        $completed = $this->faker->boolean(70); // 70% chance of being completed
        
        return [
            'title' => $this->faker->randomElement($taskTitles),
            'description' => $this->faker->optional(0.8)->paragraph(2), // 80% chance of description
            'completed' => $completed,
            'due_date' => $this->faker->optional(0.7)->dateTimeBetween('-1 month', '+2 months'), // 70% have due dates
            'completed_at' => $completed ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'assigned_to' => User::inRandomOrder()->first()?->id,
            'assigned_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
