<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'contact',
        'email',
        'adresse',
        'date_naissance',
        'sexe',
        'user_id',
    ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

     public function users()
    {
        return $this->belongsTo(User::class);
    }
    
}
