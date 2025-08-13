<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\tagihan;

class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=10; $i++) {
            tagihan::create([
                'bulan_tagih' => now()->subMonths($i)->format('Y-m'),
                'jumlah_tagihan' => rand(100000, 1000000),
                'user_id' => 2, // Assuming you have 10 users
            ]);
        }
    }
}
