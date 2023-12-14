<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Baak extends Model implements Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,AuthenticatableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
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

    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }

    public function izinkeluar(): HasMany
    {
        return $this->hasMany(IzinKeluar::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class); // Example relationship to User model
    }
    
}
