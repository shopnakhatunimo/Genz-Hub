<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'general', 'key' => 'site_name', 'value' => 'E-Commerce', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_address', 'value' => 'ঢাকা, বাংলাদেশ', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_phone', 'value' => '+8801700000000', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_email', 'value' => 'info@example.com', 'type' => 'text'],
            ['group' => 'general', 'key' => 'facebook', 'value' => 'https://facebook.com', 'type' => 'text'],
            ['group' => 'general', 'key' => 'instagram', 'value' => 'https://instagram.com', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'সেরা অনলাইন শপিং এক্সপেরিয়েন্স', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'meta_keywords', 'value' => 'ecommerce, shopping, online store', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
