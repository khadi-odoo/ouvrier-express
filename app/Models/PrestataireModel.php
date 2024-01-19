<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestataireModel extends Model
{
    use HasFactory;



    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
    }


    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }


    public function comment(): BelongsTo
    {

        return $this->belongsTo(Commentaire::class);
    }



    protected $fillable = [];
}
