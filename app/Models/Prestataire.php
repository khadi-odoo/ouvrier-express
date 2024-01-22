<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class prestataire extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
    }

    public function prestation(): BelongsTo
    {

        return $this->belongsTo(PrestationService::class);
    }
}
