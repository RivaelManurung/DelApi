<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_ktp',
        'nim',
        'nama_lengkap',
        'nomor_handphone',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }

    public function izinkeluar(): HasMany
    {
        return $this->hasMany(IzinKeluar::class);
    }
    public function baak()
    {
        return $this->hasOne(Baak::class);
    }
    public function izinBermalam(): HasMany
    {
        return $this->hasMany(IzinBermalam::class);
    }

    public function pembelian_kaos(): HasMany
    {
        return $this->hasMany(pembelian_kaos::class);
    }
    
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
