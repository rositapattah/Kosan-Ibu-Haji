<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'nomor_kamar',
        'status_kamar',
    ];

    public function laporan() {
        return $this->hasMany(laporan::class);
    }

    public function user() {
        return $this->hasOne(User::class, 'kamar_id', 'id');
    }
}
