<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategorieService extends Model
{
    use HasFactory;

    public function service (): BelongsTo {
        return $this->belongsTo(Service::class);
    }

    protected $fillable = [
        'libelle',
    ];
}
