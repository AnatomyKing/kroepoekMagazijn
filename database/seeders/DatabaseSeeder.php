<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Borrowing;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Maak eerst rollen en admin/user (via RoleSeeder)
        $this->call(RoleSeeder::class);

        // Maak 20 items
        Item::factory(20)->create();

        // Maak 50 reserveringen (koppelt zich aan bestaande users en items)
        Borrowing::factory(50)->create();
    }
}
