<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 30 tasks with varied data
        Task::factory(30)->create();
        
        $this->command->info('Task seeder completed successfully!');
        $this->command->info('30 tasks created with test data');
    }
}
