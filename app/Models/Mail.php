<?php

namespace App\Models;

use App\Mail\ResponseMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Mail as FacadesMail;

class Mail extends Model
{
    use HasFactory;

    // public function user(): HasMany
    // {

    //     return $this->hasMany(Mail::class);
    // }


    protected $fillable = [
        'email',
        'message',

    ];
    // public function sendResponseMail()
    // {
    //     // Utilisation de la méthode Mail::send() pour envoyer le courriel
    //     Mail::to($this->email)->send(new ResponseMail($this));

    //     // Mettre à jour si l'envoi a été effectué avec succès
    //     $this->response_sent = true;
    //     $this->save();
    // }
}
