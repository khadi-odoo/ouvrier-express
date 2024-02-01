<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commentaire extends Model
{
    use HasFactory;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function prestation(): BelongsTo
    {
        return $this->belongsTo(Prestation::class);
    }

    protected $fillable = [
        'client_id',
        'prestation_id',
        'statut_evaluation',
        'estArchive',
    ];
}
