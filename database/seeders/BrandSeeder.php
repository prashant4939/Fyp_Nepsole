<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'description' => 'Premium technology and consumer electronics',
            ],
            [
                'name' => 'Samsung',
                'description' => 'Global technology company specializing in electronics',
            ],
            [
                'name' => 'Nike',
                'description' => 'Athletic footwear, apparel, and sports equipment',
            ],
            [
                'name' => 'Adidas',
                'description' => 'Sports clothing and accessories',
            ],
            [
                'name' => 'Sony',
                'description' => 'Electronics, gaming, and entertainment',
            ],
            [
                'name' => 'LG',
                'description' => 'Home appliances and consumer electronics',
            ],
            [
                'name' => 'Zara',
                'description' => 'Fashion and clothing retail',
            ],
            [
                'name' => 'H&M',
                'description' => 'Fast fashion clothing and accessories',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['name' => $brand['name']],
                $brand
            );
        }

        $this->command->info('Brands seeded successfully!');
    }
}