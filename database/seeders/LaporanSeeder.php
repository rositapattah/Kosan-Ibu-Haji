<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\laporan;
use App\Models\User;
use Nette\Utils\Random;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_count = User::count();
        for($i = 1; $i<=$user_count; $i++){
            laporan::create([
                'media' => null,
                'keterangan' => Random::generate(20, 'A-Za-z0-9'),
                'tanggal_laporan' => now(),
                'status' => 'diproses',
                'user_id' => $i,
            ]);
        }
    }
}
