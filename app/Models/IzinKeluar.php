<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IzinKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'rencana_berangkat',
        'rencana_kembali',
        'approved',
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function baak()
    {
        return $this->belongsTo(Baak::class);
    }
}
