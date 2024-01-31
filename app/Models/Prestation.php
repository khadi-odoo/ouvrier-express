<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestation extends Model
{
    use HasFactory;

    public function client(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Commentaire::class);
    }

    protected $fillable = [
        'client_id',
        'prestation_id',
        'prestation_demande',
        'estArchive',
    ];
}
