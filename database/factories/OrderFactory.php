<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            'iPhone 15 Pro', 'Samsung Galaxy S24', 'MacBook Pro', 'iPad Air', 'Dell XPS 13',
            'Sony WH-1000XM5', 'AirPods Pro', 'Nintendo Switch', 'PlayStation 5', 'Xbox Series X',
            'Coffee Maker', 'Dining Table', 'Office Chair', 'Cotton T-Shirt', 'Denim Jeans',
            'Summer Dress', 'Professional Blazer', 'Cookware Set', 'Dumbbells Set', 'Novel Book'
        ];

        $areas = [
            'Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Kolkata', 'Pune', 'Hyderabad',
            'Ahmedabad', 'Surat', 'Jaipur', 'Lucknow', 'Kanpur', 'Nagpur', 'Indore',
            'Thane', 'Bhopal', 'Visakhapatnam', 'Pimpri', 'Patna', 'Vadodara'
        ];

        $suppliers = [
            'TechCorp India', 'Electronics Hub', 'Fashion Forward', 'Home Essentials',
            'Digital Solutions', 'Smart Devices Co', 'Quality Products Ltd', 'Premium Goods',
            'Retail Masters', 'Supply Chain Pro', 'Wholesale Direct', 'Import Export Co'
        ];

        $marketingPersons = [
            'Rahul Kumar', 'Priya Sharma', 'Amit Patel', 'Sneha Gupta', 'Vikram Singh',
            'Pooja Jain', 'Rajesh Verma', 'Kavita Rao', 'Suresh Nair', 'Meera Desai'
        ];

        $salesPersons = [
            'Arjun Mehta', 'Ritu Agarwal', 'Karan Thakur', 'Nisha Reddy', 'Rohit Bansal',
            'Sanya Kapoor', 'Deepak Joshi', 'Tanya Malhotra', 'Vishal Gupta', 'Shweta Iyer'
        ];

        $clients = [
            'ABC Electronics', 'XYZ Corporation', 'Tech Solutions Ltd', 'Global Enterprises',
            'Metro Mall', 'City Center', 'Digital World', 'Smart Store', 'Fashion Hub',
            'Home Depot', 'Office Mart', 'Super Market', 'Retail Chain', 'Shopping Plaza'
        ];

        return [
            'date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'mkt_person' => $this->faker->randomElement($marketingPersons),
            'sales_person' => $this->faker->randomElement($salesPersons),
            'partner_id' => 'P' . $this->faker->numberBetween(1000, 9999),
            'client' => $this->faker->randomElement($clients),
            'area' => $this->faker->randomElement($areas),
            'product' => $this->faker->randomElement($products),
            'qty' => $this->faker->numberBetween(1, 50),
            'rate' => $this->faker->randomFloat(2, 500, 50000),
            'transport' => $this->faker->optional(0.7)->randomFloat(2, 50, 2000),
            'supplier' => $this->faker->randomElement($suppliers),
            'partner_commission' => $this->faker->optional(0.6)->randomFloat(2, 100, 5000),
        ];
    }
}
