<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 sample orders using the factory
        Order::factory(20)->create();

        $this->command->info('OrderSeeder completed successfully!');
        $this->command->info('Created 20 sample orders.');
    }
}
