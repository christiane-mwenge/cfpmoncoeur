<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Formation;
use App\Models\Formateur;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class FormationCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $searchTerm = '';
    public $editMode = false;
    public $formationId;

    // Champs du formulaire
    public $titre;
    public $description;
    public $objectif;
    public $session;
    public $prerequis;
    public $duree;
    public $date_debut;
    public $date_fin;
    public $lieu;
    public $prix;
    public $photo, $photo_old;
    public $video;
    public $formateur_id;

    protected function rules()
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'objectif' => 'nullable|string',
            'session' => 'nullable|string|max:255',
            'prerequis' => 'nullable|string',
            'duree' => 'nullable|string|max:255',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'lieu' => 'nullable|string|max:255',
            'prix' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpg,png,webp|max:15360',
            'video' => 'nullable|string|max:255',
            'formateur_id' => 'required|exists:formateurs,id',
        ];
    }

    public function render()
    {
        $formateurs = Formateur::all();

        $formations = Formation::with('formateur')
            ->when($this->searchTerm, function ($query) {
                $query->where('titre', 'like', "%{$this->searchTerm}%");
            })
            ->latest()
            ->paginate(5);

        return view('livewire.formation-crud', compact('formations', 'formateurs'))
            ->layout('layouts.defaultbackend', ['title' => 'Formations']);
    }

    public function addFormation()
    {
        $this->validate();

        $photoPath = $this->photo
            ? $this->photo->store('photoformations', 'public')
            : null;

        Formation::create([
            'titre' => $this->titre,
            'description' => $this->description,
            'objectif' => $this->objectif,
            'session' => $this->session,
            'prerequis' => $this->prerequis,
            'duree' => $this->duree,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'lieu' => $this->lieu,
            'prix' => $this->prix,
            'photo' => $photoPath,
            'video' => $this->video,
            'formateur_id' => $this->formateur_id,
        ]);

        $this->resetForm();
        session()->flash('message', 'Formation ajoutée avec succès.');
    }

    public function editFormation($id)
    {
        $formation = Formation::findOrFail($id);

        $this->formationId = $formation->id;
        $this->titre = $formation->titre;
        $this->description = $formation->description;
        $this->objectif = $formation->objectif;
        $this->session = $formation->session;
        $this->prerequis = $formation->prerequis;
        $this->duree = $formation->duree;
        $this->date_debut = $formation->date_debut;
        $this->date_fin = $formation->date_fin;
        $this->lieu = $formation->lieu;
        $this->prix = $formation->prix;
        $this->photo_old = $formation->photo;
        $this->video = $formation->video;
        $this->formateur_id = $formation->formateur_id;

        $this->editMode = true;
        $this->dispatch('openModal');
    }

    public function updateFormation()
    {
        $this->validate();

        $formation = Formation::findOrFail($this->formationId);

        $photoPath = $formation->photo;
        if ($this->photo) {
            if ($formation->photo && Storage::disk('public')->exists($formation->photo)) {
                Storage::disk('public')->delete($formation->photo);
            }
            $photoPath = $this->photo->store('photoformations', 'public');
        }

        $formation->update([
            'titre' => $this->titre,
            'description' => $this->description,
            'objectif' => $this->objectif,
            'session' => $this->session,
            'prerequis' => $this->prerequis,
            'duree' => $this->duree,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'lieu' => $this->lieu,
            'prix' => $this->prix,
            'photo' => $photoPath,
            'video' => $this->video,
            'formateur_id' => $this->formateur_id,
        ]);

        $this->resetForm();
        session()->flash('message', 'Formation modifiée avec succès.');
    }

    public function deleteFormation($id)
    {
        LivewireAlert::title('Suppression')
            ->text('Voulez-vous vraiment supprimer cette formation ?')
            ->asConfirm()
            ->onConfirm('deleteItem', ['id' => $id])
            ->show();
    }

    public function deleteItem($data)
    {
        $formation = Formation::find($data['id']);

        if ($formation) {
            if ($formation->photo && Storage::disk('public')->exists($formation->photo)) {
                Storage::disk('public')->delete($formation->photo);
            }
            $formation->delete();
        }

        LivewireAlert::success('Succès', 'Formation supprimée avec succès')
            ->timer(3000)
            ->show();
    }

    private function resetForm()
    {
        $this->reset([
            'formationId',
            'titre',
            'description',
            'objectif',
            'session',
            'prerequis',
            'duree',
            'date_debut',
            'date_fin',
            'lieu',
            'prix',
            'photo',
            'video',
            'formateur_id',
            'editMode',
        ]);
    }
}
