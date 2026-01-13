<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inscription;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class InscriptionCrud extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $editMode = false;
    public $InscritpionId;
    

    // Champs du formulaire
    public $etudiant_id = '';
    public $formation_id = '';
    public $date_inscription = '';
    

    protected $rules = [
        'etudiant_id' => 'required|string|max:255',
        'formation_id' => 'required|string|max:255',
        'date_inscription' => 'required|string|max:255',
       
    ];

    public function render()
    {
        $query = Inscription::query();

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('etudiant_id', 'like', '%'.$this->searchTerm.'%')
                  ->orWhere('formation_id', 'like', '%'.$this->searchTerm.'%')
                  ->orWhere('date_inscription', 'like', '%'.$this->searchTerm.'%');
            });
        }

        return view('livewire.inscription-crud', [
            'inscriptions' => $query->orderBy('id', 'desc')->paginate(10)
        ])->layout('layouts.defaultbackend', ['title' => 'Inscriptions']);
    }

    public function addInscription()
    {
        $this->validate();

        Inscription::create([
            'etudiant_id' => $this->etudiant_id,
            'formation_id' => $this->formation_id,
            'date_inscription' => $this->date_inscription,
           
        ]);

        $this->resetForm();
        session()->flash('message', 'Formation ajouté avec succès.');
    }

    public function editInscription($id)
    {
        $inscription = Inscription::findOrFail($id);

        $this->inscriptionId = $id;
        $this->etudiant_id = $inscription->etudiant_id;
        $this->formation_id = $inscription->formation_id;
        $this->date_inscription= $inscription->date_inscription;
       

        $this->editMode = true;
        $this->dispatch('openModal');
    }

    public function updateInscription()
    {
        $this->validate();

        Formation::findOrFail($this->formationId)->update([
            'etudiant_id' => $this->titre,
            'formation_id' => $this->description,
            'date_inscription' => $this->idformateur,
            
        ]);

        $this->resetForm();
        session()->flash('message', 'inscription modifié avec succès.');
    }

    public function deleteInscription($id)
    {
        LivewireAlert::title('Suppression Inscription')
            ->text('Êtes-vous sûr de vouloir supprimer ?')
            ->asConfirm()
            ->onConfirm('deleteItem', ['id' => $id])
            ->show();
    }

    public function deleteItem($data)
    {
        Inscription::find($data['id'])->delete();

        LivewireAlert::success('Succès', 'inscription supprimé avec succès')
            ->timer(4000)
            ->show();
    }

    private function resetForm()
    {
        $this->reset([
        'formation_id',
        'etudiant_id',
        'date_inscription',
        'editMode'
        ]);
    }
}
