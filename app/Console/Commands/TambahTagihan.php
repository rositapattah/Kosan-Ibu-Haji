<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Tagihan;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonthlyPaymentMail;

class TambahTagihan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tambah-tagihan ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menambahkan tagihan baru untuk setiap user tiap bulan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('role', 'user')
                    ->whereNotNull('kamar_id')
                    ->get();
        
        foreach ($users as $index => $user) {
            // Create the payment record
            $tagihan = Tagihan::create([
                'bulan_tagih' => now()->format('Y-m-d'),
                'jumlah_tagihan' => rand(100000, 1000000),
                'status' => 'belum bayar',
                'user_id' => $user->id,
            ]);
            
            // Send email notification
            try {
                Mail::to($user->email)
                    ->later(now()->addSeconds($index * 5),
                    new MonthlyPaymentMail($user, $tagihan));
                    
                $this->info("Email sent to: {$user->email}");
            } catch (\Exception $e) {
                $this->error("Failed to send email to {$user->email}: " . $e->getMessage());
            }
            $this->info("Tagihan untuk user {$user->name} telah ditambahkan.");
    }
}
}
