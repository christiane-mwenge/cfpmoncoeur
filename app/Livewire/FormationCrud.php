<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Formation;
use App\Models\Formateur;
use Illuminate\Support\Facades\Storage;

class FormationCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $searchTerm = '';
    public $editMode = false;
    public $formationId;
    public $displayMode = 'grid';

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

    protected $rules = [
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
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
        'video' => 'nullable|string|max:255',
        'formateur_id' => 'required|exists:formateurs,id',
    ];

    protected $messages = [
        'titre.required' => 'Le titre est obligatoire.',
        'description.required' => 'La description est obligatoire.',
        'prix.required' => 'Le prix est obligatoire.',
        'prix.numeric' => 'Le prix doit être un nombre.',
        'formateur_id.required' => 'Le formateur est obligatoire.',
        'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
    ];

    public function render()
    {
        $formateurs = Formateur::all();

        $query = Formation::with('formateur')
            ->when($this->searchTerm, function ($query) {
                $query->where('titre', 'like', "%{$this->searchTerm}%")
                      ->orWhere('description', 'like', "%{$this->searchTerm}%")
                      ->orWhere('objectif', 'like', "%{$this->searchTerm}%")
                      ->orWhereHas('formateur', function ($q) {
                          $q->where('nom', 'like', "%{$this->searchTerm}%")
                            ->orWhere('prenom', 'like', "%{$this->searchTerm}%");
                      });
            });

        if (in_array($this->displayMode, ['grid', 'list'])) {
            $query->where(function ($q) {
                $q->whereNull('date_fin')
                  ->orWhere('date_fin', '>=', now());
            })->orderBy('date_debut', 'asc');
            $perPage = $this->displayMode === 'grid' ? 9 : 10;
        } else {
            $query->orderBy('created_at', 'desc');
            $perPage = 10;
        }

        $formations = $query->paginate($perPage);

        return view('livewire.formation-crud', compact('formations', 'formateurs'))
            ->layout('layouts.defaultbackend', ['title' => 'Formations']);
    }

    // Méthode pour obtenir l'URL complète de la photo
    public function getPhotoUrl($path)
    {
        if (!$path) return null;
        
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        
        // Utiliser asset() pour les fichiers stockés
        if (Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }
        
        return null;
    }

    public function resetFormAndOpen()
    {
        $this->resetForm();
        $this->dispatch('openModal');
    }

    public function addFormation()
    {
        $this->validate();

        $photoPath = null;
        if ($this->photo) {
            // Stocker dans un sous-dossier par année/mois
            $photoPath = $this->photo->store('formations/' . date('Y/m'), 'public');
        }

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
        $this->dispatch('closeModal');
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
            // Supprimer l'ancienne photo
            if ($formation->photo && Storage::disk('public')->exists($formation->photo)) {
                Storage::disk('public')->delete($formation->photo);
            }
            // Stocker la nouvelle photo
            $photoPath = $this->photo->store('formations/' . date('Y/m'), 'public');
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
        $this->dispatch('closeModal');
    }

    public function deleteFormation($id)
    {
        $formation = Formation::find($id);

        if ($formation) {
            // Supprimer la photo
            if ($formation->photo && Storage::disk('public')->exists($formation->photo)) {
                Storage::disk('public')->delete($formation->photo);
            }
            
            $formation->delete();
            session()->flash('message', 'Formation supprimée avec succès.');
        }
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
            'photo_old',
            'video',
            'formateur_id',
            'editMode',
        ]);
        $this->resetErrorBag();
    }
}