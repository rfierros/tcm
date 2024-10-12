<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ciclista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
