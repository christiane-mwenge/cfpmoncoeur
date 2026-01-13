<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Formateur;
use App\Models\Formation;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Don;

class Dashboard extends Component
{
    public $totalFormateurs;
    public $totalFormations;
    public $totalEtudiants;
    public $totalInscriptions;
    public $totalDons;

    public function render()
    {
        // $this->totalFormateurs   = Formateur::count();
        // $this->totalFormations   = Formation::count();
        // $this->totalEtudiants    = Etudiant::count();
        // $this->totalInscriptions = Inscription::count();
        // $this->totalDons         = Don::count();

        return view('livewire.dashboard')
            ->layout('layouts.defaultbackend', ['title' => 'Dashboard']);
    }
}
