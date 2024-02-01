<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mail extends Model
{
    use HasFactory;

    public function user(): HasMany
    {

        return $this->hasMany(Mail::class);
    }


    protected $fillable = [
        'to',
        'from',
        'sujet',
        'corps',
        'date_mail',
        'estArchive',
    ];
}
