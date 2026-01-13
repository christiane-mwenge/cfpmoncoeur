<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'titre',
        'description',
         'objectif',
        'session',
        'prerequis',
        'duree',
        'date_debut',
        'date_fin',
        'lieu',
        'photo',
        'video',
        'formateur_id',
        'prix'
    ];

    public function formateur()
    {
        return $this->belongsTo(Formateur::class,'formateur_id');
    }
}
