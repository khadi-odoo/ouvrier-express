<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrestationService extends Model
{
    use HasFactory;

    public function categorie(): HasMany
    {

        return $this->hasMany(categorieService::class);
    }

    public function prestataire(): HasMany
    {

        return $this->hasMany(prestataire::class);
    }

    public function comment(): BelongsTo
    {

        return $this->belongsTo(Commentaire::class);
    }

    protected $fillable = [

        'nomService',
        'image',
        'presentation',
        'disponibilite',
        'experience',
        'competence',
        'motivation',
        'prestataire_id',
        'categorie_id',
        'estArchive',
    ];
}
