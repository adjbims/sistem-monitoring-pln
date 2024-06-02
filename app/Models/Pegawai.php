<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'tipe',
        'min_transaksi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
