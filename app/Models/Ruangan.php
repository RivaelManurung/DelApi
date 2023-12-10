<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ruangan',
    ];


    /**
     * Get the bookings for the ruangan.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
