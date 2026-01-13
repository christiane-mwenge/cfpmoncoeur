<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Etudiant;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class EtudiantCrud extends Component
{
    use WithPagination;

    public $searchTerm = '';

    public function render()
    {
        $query = Etudiant::query();

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('nom', 'like', '%'.$this->searchTerm.'%')
                  ->orWhere('prenom', 'like', '%'.$this->searchTerm.'%')
                  ->orWhere('email', 'like', '%'.$this->searchTerm.'%');
            });
        }

        return view('livewire.etudiant-crud', [
            'etudiants' => $query->orderBy('id', 'desc')->paginate(10)
        ])->layout('layouts.defaultbackend', ['title' => 'Étudiants']);
    }

    public function deleteEtudiant($id)
    {
        LivewireAlert::title('Suppression Étudiant')
            ->text('Êtes-vous sûr de vouloir supprimer cet étudiant ?')
            ->asConfirm()
            ->onConfirm('deleteItem', ['id' => $id])
            ->show();
    }

    public function deleteItem($data)
    {
        Etudiant::findOrFail($data['id'])->delete();

        LivewireAlert::success('Succès', 'Étudiant supprimé avec succès')
            ->timer(4000)
            ->show();
    }
}
