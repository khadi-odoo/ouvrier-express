<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class client extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
    }

    public function comment(): HasMany
    {

        return $this->hasMany(Commentaire::class);
    }

    protected $fillable = [

        'user_id',

    ];
}
