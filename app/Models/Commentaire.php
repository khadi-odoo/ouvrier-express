<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commentaire extends Model
{
    use HasFactory;

    public function client(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function prestation(): HasMany
    {
        return $this->hasMany(PrestationService::class);
    }

    protected $fillable = [
        'statut_evaluation',
        'estArchive',
    ];
}
