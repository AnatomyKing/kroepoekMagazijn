<?php

namespace Database\Seeders;

use App\Models\Borrowing;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    public function run(): void
    {
        Borrowing::insert([
            [
                'user_id' => 1,
                'item_id' => 3,
                'borrow_date' => now()->subDays(10),
                'end_date' => now()->addDays(5),
                'late' => false,
                'borrowing' => 1,
                'commentary' => 'Borrowed for project work.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}