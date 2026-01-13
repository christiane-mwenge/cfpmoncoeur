<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Formation;
use Livewire\WithPagination;

class Index extends Component
{
     use WithPagination;
    public function render()
    {
         // On récupère tous les cours, tu peux ajouter un ordre si besoin
        $cours = Formation::with('formateur')->paginate(3);
        return view('livewire.front.index', [
            'cours' => $cours,
        ]) ->layout('layouts.defaultfrontend', ['title' => 'Acceuil']);
    }
}
