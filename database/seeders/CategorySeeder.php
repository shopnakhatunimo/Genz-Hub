<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'ইলেকট্রনিক্স', 'slug' => 'electronics', 'description' => 'সব ধরনের ইলেকট্রনিক্স পণ্য', 'order' => 1, 'featured' => true, 'status' => true],
            ['name' => 'ফ্যাশন', 'slug' => 'fashion', 'description' => 'পুরুষ ও মহিলাদের ফ্যাশন', 'order' => 2, 'featured' => true, 'status' => true],
            ['name' => 'হোম অ্যান্ড লিভিং', 'slug' => 'home-living', 'description' => 'ঘরের জন্য প্রয়োজনীয় সবকিছু', 'order' => 3, 'featured' => true, 'status' => true],
            ['name' => 'স্মার্ট ফোন', 'slug' => 'smartphones', 'description' => 'সব ধরনের স্মার্ট ফোন', 'order' => 4, 'featured' => true, 'status' => true],
            ['name' => 'বিউটি অ্যান্ড পার্সোনাল কেয়ার', 'slug' => 'beauty', 'description' => 'বিউটি প্রোডাক্ট', 'order' => 5, 'featured' => false, 'status' => true],
            ['name' => 'স্পোর্টস', 'slug' => 'sports', 'description' => 'স্পোর্টস সরঞ্জাম', 'order' => 6, 'featured' => false, 'status' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
