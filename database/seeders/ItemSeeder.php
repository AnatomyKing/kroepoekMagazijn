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
                'description' => 'Microcontroller board',

                'category' => null,
                'image' => null,

                'quantity_total' => 10,
                'quantity_available' => 10,

                'status' => 'available',
                'video_link' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Raspberry Pi 5',
                'description' => 'Single board computer',

                'category' => null,
                'image' => null,

                'quantity_total' => 5,
                'quantity_available' => 5,

                'status' => 'available',
                'video_link' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => '3D Printer',
                'description' => 'Ender 3 printer',

                'category' => null,
                'image' => null,

                'quantity_total' => 1,
                'quantity_available' => 0,

                'status' => 'unavailable',
                'video_link' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}