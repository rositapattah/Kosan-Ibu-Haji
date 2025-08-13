<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\kamar;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $kamar = new Kamar();
            $kamar->nomor_kamar = $i + 1;
            $kamar->status_kamar = 'tersedia';
            $kamar->save();
        }
    }
}
