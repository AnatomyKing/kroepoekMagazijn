<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::insert([
            [
                'item_name' => 'Arduino Uno',
                'availability' => true,
                'description' => 'Microcontroller board',
                'category' => 'Electronics',
                'image' => 'arduino.jpg',
                'status' => 'available',
                'video_link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Raspberry Pi 5',
                'availability' => true,
                'description' => 'Single board computer',
                'category' => 'Computing',
                'image' => 'rpi5.jpg',
                'status' => 'available',
                'video_link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => '3D Printer',
                'availability' => false,
                'description' => 'Ender 3 printer',
                'category' => 'Manufacturing',
                'image' => 'ender3.jpg',
                'status' => 'borrowed',
                'video_link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}