<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Beds (category_id = 1)
            [
                'name' => 'Classic Wooden Bed',
                'description' => 'Solid oak frame with a timeless design.',
                'price' => 799,
                'discount_amount' => 50,
                'stock' => 5,
                'img' => 'products/bed1.jpeg',
                'category_id' => 1,
            ],
            [
                'name' => 'Modern Platform Bed',
                'description' => 'Sleek low-profile bed with upholstered headboard.',
                'price' => 899,
                'discount_amount' => 75,
                'stock' => 3,
                'img' => 'products/bed2.jpeg',
                'category_id' => 1,
            ],
            [
                'name' => 'Luxury King Bed',
                'description' => 'Spacious king bed with premium comfort.',
                'price' => 1299,
                'discount_amount' => 0,
                'stock' => 2,
                'img' => 'products/bed3.jpeg',
                'category_id' => 1,
            ],

            // Sofas (category_id = 2)
            [
                'name' => 'Leather Recliner Sofa',
                'description' => 'Three-seater recliner with plush leather.',
                'price' => 1499,
                'discount_amount' => 3,
                'stock' => 4,
                'img' => 'products/sofa1.jpeg',
                'category_id' => 2,
            ],
            [
                'name' => 'Fabric Sectional Sofa',
                'description' => 'L-shaped sectional with modern design.',
                'price' => 1199,
                'discount_amount' => 0,
                'stock' => 3,
                'img' => 'products/sofa2.jpeg',
                'category_id' => 2,
            ],
            [
                'name' => 'Minimalist Two-Seater',
                'description' => 'Compact sofa for small spaces.',
                'price' => 699,
                'discount_amount' => 50,
                'stock' => 6,
                'img' => 'products/sofa3.jpeg',
                'category_id' => 2,
            ],

            // Chairs (category_id = 3)
            [
                'name' => 'Ergonomic Office Chair',
                'description' => 'Adjustable chair for maximum comfort.',
                'price' => 299,
                'discount_amount' => 20,
                'stock' => 8,
                'img' => 'products/chair1.jpeg',
                'category_id' => 3,
            ],
            [
                'name' => 'Classic Wooden Chair',
                'description' => 'Handcrafted from premium hardwood.',
                'price' => 149,
                'discount_amount' => 10,
                'stock' => 10,
                'img' => 'products/chair2.jpeg',
                'category_id' => 3,
            ],
            [
                'name' => 'Modern Lounge Chair',
                'description' => 'Comfortable lounge chair with cushioned seat.',
                'price' => 399,
                'discount_amount' => 25,
                'stock' => 5,
                'img' => 'products/chair3.jpeg',
                'category_id' => 3,
            ],

            // Floor Lamps (category_id = 4)
            [
                'name' => 'Industrial Floor Lamp',
                'description' => 'Metal frame with exposed bulb style.',
                'price' => 199,
                'discount_amount' => 15,
                'stock' => 7,
                'img' => 'products/FL1.jpeg',
                'category_id' => 4,
            ],
            [
                'name' => 'Minimalist LED Lamp',
                'description' => 'Energy-efficient floor lamp with sleek design.',
                'price' => 149,
                'discount_amount' => 10,
                'stock' => 10,
                'img' => 'products/FL2.jpeg',
                'category_id' => 4,
            ],
            [
                'name' => 'Classic Reading Lamp',
                'description' => 'Adjustable arm for focused lighting.',
                'price' => 179,
                'discount_amount' => 15,
                'stock' => 8,
                'img' => 'products/FL3.jpeg',
                'category_id' => 4,
            ],

            // Buffets (category_id = 5)
            [
                'name' => 'Rustic Wooden Buffet',
                'description' => 'Solid wood with natural finish.',
                'price' => 899,
                'discount_amount' => 75,
                'stock' => 4,
                'img' => 'products/buffets1.jpeg',
                'category_id' => 5,
            ],
            [
                'name' => 'Modern Buffet Cabinet',
                'description' => 'Sleek design with ample storage.',
                'price' => 1099,
                'discount_amount' => 5,
                'stock' => 3,
                'img' => 'products/buffets2.jpeg',
                'category_id' => 5,
            ],

            // Bean Bags (category_id = 6)
            [
                'name' => 'Giant Bean Bag',
                'description' => 'Oversized bean bag for ultimate comfort.',
                'price' => 199,
                'discount_amount' => 20,
                'stock' => 12,
                'img' => 'products/bb1.jpeg',
                'category_id' => 6,
            ],
            [
                'name' => 'Round Bean Bag',
                'description' => 'Cozy bean bag for lounging.',
                'price' => 149,
                'discount_amount' => 15,
                'stock' => 10,
                'img' => 'products/bb2.jpeg',
                'category_id' => 6,
            ],
            [
                'name' => 'Outdoor Bean Bag',
                'description' => 'Weather-resistant bean bag for outdoor use.',
                'price' => 179,
                'discount_amount' => 15,
                'stock' => 8,
                'img' => 'products/bb3.jpeg',
                'category_id' => 6,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
