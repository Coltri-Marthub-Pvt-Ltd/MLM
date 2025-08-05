<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Root categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'parent_id' => null,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing & Fashion',
            'slug' => 'clothing-fashion',
            'parent_id' => null,
        ]);

        $home = Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'parent_id' => null,
        ]);

        $sports = Category::create([
            'name' => 'Sports & Outdoors',
            'slug' => 'sports-outdoors',
            'parent_id' => null,
        ]);

        $books = Category::create([
            'name' => 'Books & Media',
            'slug' => 'books-media',
            'parent_id' => null,
        ]);

        // Electronics subcategories
        Category::create([
            'name' => 'Computers & Laptops',
            'slug' => 'computers-laptops',
            'parent_id' => $electronics->id,
        ]);

        Category::create([
            'name' => 'Smartphones & Tablets',
            'slug' => 'smartphones-tablets',
            'parent_id' => $electronics->id,
        ]);

        Category::create([
            'name' => 'Audio & Headphones',
            'slug' => 'audio-headphones',
            'parent_id' => $electronics->id,
        ]);

        Category::create([
            'name' => 'Gaming',
            'slug' => 'gaming',
            'parent_id' => $electronics->id,
        ]);

        // Clothing subcategories
        Category::create([
            'name' => 'Men\'s Clothing',
            'slug' => 'mens-clothing',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'name' => 'Women\'s Clothing',
            'slug' => 'womens-clothing',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'name' => 'Shoes & Accessories',
            'slug' => 'shoes-accessories',
            'parent_id' => $clothing->id,
        ]);

        // Home & Garden subcategories
        Category::create([
            'name' => 'Furniture',
            'slug' => 'furniture',
            'parent_id' => $home->id,
        ]);

        Category::create([
            'name' => 'Kitchen & Dining',
            'slug' => 'kitchen-dining',
            'parent_id' => $home->id,
        ]);

        Category::create([
            'name' => 'Garden & Outdoor',
            'slug' => 'garden-outdoor',
            'parent_id' => $home->id,
        ]);

        // Sports subcategories
        Category::create([
            'name' => 'Fitness Equipment',
            'slug' => 'fitness-equipment',
            'parent_id' => $sports->id,
        ]);

        Category::create([
            'name' => 'Outdoor Activities',
            'slug' => 'outdoor-activities',
            'parent_id' => $sports->id,
        ]);

        // Books subcategories
        Category::create([
            'name' => 'Fiction',
            'slug' => 'fiction',
            'parent_id' => $books->id,
        ]);

        Category::create([
            'name' => 'Non-Fiction',
            'slug' => 'non-fiction',
            'parent_id' => $books->id,
        ]);

        Category::create([
            'name' => 'Educational',
            'slug' => 'educational',
            'parent_id' => $books->id,
        ]);
    }
} 