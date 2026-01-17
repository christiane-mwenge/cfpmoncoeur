<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Formation;
use App\Models\Formateur;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public function render()
    {
        // Récupérer les formations avec pagination
        $cours = Formation::with('formateur')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        
        // Récupérer les formateurs (limite à 4)
        $formateurs = Formateur::limit(4)->get();
        
        return view('livewire.front.index', [
            'cours' => $cours,
            'formateurs' => $formateurs, // IMPORTANT : Ajoutez cette ligne
        ])->layout('layouts.defaultfrontend', ['title' => 'Accueil']);
    }
}