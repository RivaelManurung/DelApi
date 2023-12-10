<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_kegiatan',
        'rencana_peminjaman',
        'rencana_berakhir',
        'ruangan_id',
    ];

    protected $casts = [
        'rencana_peminjaman' => 'datetime',
        'rencana_berakhir' => 'datetime',
    ];

    // Definisi relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definisi relasi dengan ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
