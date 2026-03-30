<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices, gadgets, and accessories',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Clothing, shoes, and fashion accessories',
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home decor, furniture, and garden supplies',
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
            ],
            [
                'name' => 'Books & Media',
                'description' => 'Books, movies, music, and educational materials',
            ],
            [
                'name' => 'Health & Beauty',
                'description' => 'Health products, cosmetics, and personal care',
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Toys, games, and entertainment for all ages',
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car parts, accessories, and automotive supplies',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}