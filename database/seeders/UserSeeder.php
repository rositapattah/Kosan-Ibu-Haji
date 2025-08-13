<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\kamar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua kamar ID & shuffle
        $kamarList = Kamar::where('status_kamar', '!=', 'penuh')
            ->inRandomOrder()
            ->limit(10)
            ->pluck('id')
            ->toArray();

        foreach (range(1, 5) as $i) {
            if (empty($kamarList)) {
                break; // Berhenti kalau tidak ada kamar tersisa
            }

            // Ambil kamar acak & hapus dari list agar tidak dobel
            $kamar_id = array_pop($kamarList);

            // Buat user baru
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '08123456789' . $i,
                'role' => 'user',
                'kamar_id' => $kamar_id,
            ]);

            // Update status kamar jadi penuh
            Kamar::where('id', $kamar_id)->update([
                'status_kamar' => 'penuh',
            ]);
        }
    }
}
