<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        $categories = [
            ['name' => 'Face Primer', 'slug' => 'face-primer', 'description' => 'Primer products for smooth makeup application'],
            ['name' => 'Skin Care', 'slug' => 'skin-care', 'description' => 'Hydrating skin care essentials'],
            ['name' => 'Makeup Lipsticks', 'slug' => 'makeup-lipsticks', 'description' => 'Bold and long-lasting lip colors'],
            ['name' => 'Hair Care', 'slug' => 'hair-care', 'description' => 'Hair treatment and styling products'],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        $facePrimer = Category::where('slug', 'face-primer')->first();
        $skinCare = Category::where('slug', 'skin-care')->first();
        $lipsticks = Category::where('slug', 'makeup-lipsticks')->first();
        $hairCare = Category::where('slug', 'hair-care')->first();

        $products = [
            [
                'category_id' => $facePrimer?->id,
                'name' => 'Illuminating Face Primer',
                'slug' => 'illuminating-face-primer',
                'description' => 'Brightens and smooths skin for makeup prep.',
                'price' => 38.00,
                'compare_price' => 45.00,
                'stock_quantity' => 11,
                'sku' => 'PRM-012',
                'image' => 'https://images.unsplash.com/photo-1631730359585-38a4935cbec4?w=600&h=600&fit=crop',
                'gallery' => [],
                'status' => 'active',
                'featured' => true,
                'views' => 48,
            ],
            [
                'category_id' => $skinCare?->id,
                'name' => 'Hydrating Face Cream',
                'slug' => 'hydrating-face-cream',
                'description' => 'Deep hydration for all skin types.',
                'price' => 45.00,
                'compare_price' => 55.00,
                'stock_quantity' => 20,
                'sku' => 'SKC-009',
                'image' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&h=600&fit=crop',
                'gallery' => [],
                'status' => 'active',
                'featured' => false,
                'views' => 50,
            ],
            [
                'category_id' => $lipsticks?->id,
                'name' => 'Matte Liquid Lipstick',
                'slug' => 'matte-liquid-lipstick',
                'description' => 'Long-lasting matte finish with bold color.',
                'price' => 29.00,
                'compare_price' => 35.00,
                'stock_quantity' => 18,
                'sku' => 'LIP-011',
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=600&h=600&fit=crop',
                'gallery' => [],
                'status' => 'active',
                'featured' => false,
                'views' => 42,
            ],
            [
                'category_id' => $hairCare?->id,
                'name' => 'Volumizing Hair Cream',
                'slug' => 'volumizing-hair-cream',
                'description' => 'Adds volume and shine to hair.',
                'price' => 35.00,
                'compare_price' => 42.00,
                'stock_quantity' => 14,
                'sku' => 'HRC-010',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600&h=600&fit=crop',
                'gallery' => [],
                'status' => 'active',
                'featured' => false,
                'views' => 35,
            ],
        ];

        foreach ($products as $productData) {
            if (! $productData['category_id']) {
                continue;
            }

            Product::updateOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );
        }
    }
}
