<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories for assignment
        $categories = Category::all()->keyBy('slug');

        $products = [
            // Electronics - Computers & Laptops
            [
                'name' => 'MacBook Pro 16-inch',
                'description' => 'Apple MacBook Pro with M2 Pro chip, 16-inch Liquid Retina XDR display, 512GB SSD storage. Perfect for professionals and creatives.',
                'price' => 199999.00,
                'points' => 2000,
                'category_slug' => 'computers-laptops'
            ],
            [
                'name' => 'Dell XPS 13 Laptop',
                'description' => 'Ultra-thin and light laptop with 13.4-inch InfinityEdge display, Intel Core i7 processor, 16GB RAM, 512GB SSD.',
                'price' => 108999.00,
                'points' => 1090,
                'category_slug' => 'computers-laptops'
            ],
            [
                'name' => 'Gaming Desktop PC',
                'description' => 'High-performance gaming desktop with NVIDIA RTX 4070, AMD Ryzen 7 processor, 32GB DDR4 RAM, 1TB NVMe SSD.',
                'price' => 158999.00,
                'points' => 1590,
                'category_slug' => 'computers-laptops'
            ],

            // Electronics - Smartphones & Tablets
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with A17 Pro chip, Pro camera system, and titanium design. Available in multiple colors.',
                'price' => 134900.00,
                'points' => 1349,
                'category_slug' => 'smartphones-tablets'
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Premium Android smartphone with S Pen, 200MP camera, 6.8-inch Dynamic AMOLED display.',
                'price' => 124999.00,
                'category_slug' => 'smartphones-tablets'
            ],
            [
                'name' => 'iPad Air 5th Generation',
                'description' => '10.9-inch iPad Air with M1 chip, all-day battery life, and compatibility with Apple Pencil.',
                'price' => 54900.00,
                'category_slug' => 'smartphones-tablets'
            ],

            // Electronics - Audio & Headphones
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'description' => 'Industry-leading noise canceling wireless headphones with 30-hour battery life and premium sound quality.',
                'price' => 29990.00,
                'category_slug' => 'audio-headphones'
            ],
            [
                'name' => 'AirPods Pro 2nd Generation',
                'description' => 'Apple AirPods Pro with Active Noise Cancellation, Transparency mode, and spatial audio.',
                'price' => 26900.00,
                'category_slug' => 'audio-headphones'
            ],

            // Electronics - Gaming
            [
                'name' => 'PlayStation 5 Console',
                'description' => 'Next-gen gaming console with ultra-high speed SSD, ray tracing, and 4K gaming capabilities.',
                'price' => 54990.00,
                'category_slug' => 'gaming'
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Handheld gaming console with vibrant OLED screen, enhanced audio, and versatile play modes.',
                'price' => 37980.00,
                'category_slug' => 'gaming'
            ],

            // Clothing - Men's Clothing
            [
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'Soft, comfortable cotton t-shirt in classic fit. Available in multiple colors and sizes.',
                'price' => 1299.00,
                'category_slug' => 'mens-clothing'
            ],
            [
                'name' => 'Slim Fit Denim Jeans',
                'description' => 'Modern slim-fit jeans made from premium denim with stretch for comfort and style.',
                'price' => 2999.00,
                'category_slug' => 'mens-clothing'
            ],

            // Clothing - Women's Clothing
            [
                'name' => 'Elegant Summer Dress',
                'description' => 'Flowing summer dress perfect for casual outings or special occasions. Lightweight and breathable fabric.',
                'price' => 3499.00,
                'category_slug' => 'womens-clothing'
            ],
            [
                'name' => 'Professional Blazer',
                'description' => 'Tailored blazer perfect for office wear or business meetings. Available in navy, black, and gray.',
                'price' => 5999.00,
                'category_slug' => 'womens-clothing'
            ],

            // Home & Garden - Furniture
            [
                'name' => 'Modern Office Chair',
                'description' => 'Ergonomic office chair with lumbar support, adjustable height, and breathable mesh back.',
                'price' => 12999.00,
                'category_slug' => 'furniture'
            ],
            [
                'name' => 'Scandinavian Dining Table',
                'description' => 'Beautiful solid wood dining table that seats 6 people. Perfect for modern homes.',
                'price' => 45999.00,
                'category_slug' => 'furniture'
            ],

            // Home & Garden - Kitchen & Dining
            [
                'name' => 'Stainless Steel Cookware Set',
                'description' => 'Professional-grade 12-piece cookware set with non-stick coating and heat-resistant handles.',
                'price' => 8999.00,
                'category_slug' => 'kitchen-dining'
            ],
            [
                'name' => 'Smart Coffee Maker',
                'description' => 'Wi-Fi enabled coffee maker with programmable brewing, temperature control, and mobile app.',
                'price' => 6999.00,
                'category_slug' => 'kitchen-dining'
            ],

            // Sports & Outdoors - Fitness Equipment
            [
                'name' => 'Adjustable Dumbbells Set',
                'description' => 'Space-saving adjustable dumbbells with weight range from 5-50 lbs per dumbbell.',
                'price' => 15999.00,
                'category_slug' => 'fitness-equipment'
            ],

            // Books & Media - Fiction
            [
                'name' => 'The Great Adventure Novel',
                'description' => 'Bestselling adventure novel that takes readers on an epic journey across mysterious lands.',
                'price' => 599.00,
                'category_slug' => 'fiction'
            ],
        ];

        foreach ($products as $productData) {
            $categorySlug = $productData['category_slug'];
            unset($productData['category_slug']);
            
            $category = $categories->get($categorySlug);
            
            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'points' => $productData['points'] ?? 0,
                'category_id' => $category ? $category->id : null,
                'image' => null, // We'll add placeholder images later if needed
            ]);
        }
    }
} 