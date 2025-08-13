<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'tagihan_id',
        'user_id',
        'tanggal_bayar',
        'total_harga',
        'metode_pembayaran',
        'status',
        'order_id', // Tambahkan ini untuk menyimpan ID transaksi Midtrans
        'snap_token', // Tambahkan ini untuk menyimpan token SNAP
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'total_harga' => 'decimal:2', // Pastikan total_harga adalah desimal dengan 2 angka di belakang koma
    ];

    // Relasi ke Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
