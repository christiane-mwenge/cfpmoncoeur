<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Formateur;
use Illuminate\Support\Facades\Storage;

class FormateurCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $searchTerm = '';
    public $editMode = false;
    public $formateurId;

    public $nom = '';
    public $prenom = '';
    public $domaine = '';
    public $contact = '';
    public $email = '';
    public $adresse = '';
    public $date_naissance = '';
    public $sexe = '';
    public $photo, $photo_old;
    public $status = 'active';
    public $password = '';

    protected $queryString = ['searchTerm']; // Pour garder la recherche dans l'URL

    public function rules()
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'domaine' => 'required|string|max:255',
            'contact' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:formateurs,email',
            'adresse' => 'required|string|max:255',
            'date_naissance' => 'required|date|before:today',
            'sexe' => 'required|in:homme,femme',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
            'status' => 'nullable|in:active,inactive',
        ];

        // Règle unique pour l'email sauf en mode édition
        if ($this->editMode) {
            $rules['email'] = 'required|email|max:255|unique:formateurs,email,' . $this->formateurId;
        }

        // Règle mot de passe seulement pour l'ajout
        if (!$this->editMode) {
            $rules['password'] = 'required|string|min:6';
        } else {
            $rules['password'] = 'nullable|string|min:6';
        }

        return $rules;
    }

    public function render()
    {
        $query = Formateur::query();

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('nom', 'like', "%{$this->searchTerm}%")
                  ->orWhere('prenom', 'like', "%{$this->searchTerm}%")
                  ->orWhere('domaine', 'like', "%{$this->searchTerm}%")
                  ->orWhere('email', 'like', "%{$this->searchTerm}%")
                  ->orWhere('contact', 'like', "%{$this->searchTerm}%");
            });
        }

        return view('livewire.formateur-crud', [
            'formateurs' => $query->latest()->paginate(10)
        ])->layout('layouts.defaultbackend', ['title' => 'Formateurs']);
    }

    public function addFormateur()
    {
        $validatedData = $this->validate();

        $photoPath = $this->photo
            ? $this->photo->store('photoformateurs', 'public')
            : null;

        Formateur::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'domaine' => $this->domaine,
            'contact' => $this->contact,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'date_naissance' => $this->date_naissance,
            'sexe' => $this->sexe,
            'photo' => $photoPath,
            'status' => $this->status,
            'password' => bcrypt($this->password),
        ]);

        $this->resetForm();
        $this->dispatch('closeModal');
        
        // Déclencher une alerte
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Formateur ajouté avec succès.'
        ]);
    }

    public function editFormateur($id)
    {
        $formateur = Formateur::findOrFail($id);

        $this->formateurId = $formateur->id;
        $this->nom = $formateur->nom;
        $this->prenom = $formateur->prenom;
        $this->domaine = $formateur->domaine;
        $this->contact = $formateur->contact;
        $this->email = $formateur->email;
        $this->adresse = $formateur->adresse;
        $this->date_naissance = $formateur->date_naissance;
        $this->sexe = $formateur->sexe;
        $this->status = $formateur->status;
        $this->photo_old = $formateur->photo;

        $this->editMode = true;
        $this->dispatch('openModal');
    }

    public function updateFormateur()
    {
        $validatedData = $this->validate();

        $formateur = Formateur::findOrFail($this->formateurId);

        $photoPath = $formateur->photo;
        if ($this->photo) {
            if ($formateur->photo && Storage::disk('public')->exists($formateur->photo)) {
                Storage::disk('public')->delete($formateur->photo);
            }
            $photoPath = $this->photo->store('photoformateurs', 'public');
        }

        $updateData = [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'domaine' => $this->domaine,
            'contact' => $this->contact,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'date_naissance' => $this->date_naissance,
            'sexe' => $this->sexe,
            'photo' => $photoPath,
            'status' => $this->status,
        ];

        // Mettre à jour le mot de passe seulement s'il est fourni
        if (!empty($this->password)) {
            $updateData['password'] = bcrypt($this->password);
        }

        $formateur->update($updateData);

        $this->resetForm();
        $this->dispatch('closeModal');
        
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Formateur modifié avec succès.'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->formateurId = $id;
        
        // Déclencher un événement JavaScript pour la confirmation
        $this->dispatch('confirmDelete', [
            'id' => $id
        ]);
    }

    public function deleteFormateur($id = null)
    {
        // Utiliser l'ID passé en paramètre ou celui stocké
        $formateurId = $id ?? $this->formateurId;
        
        $formateur = Formateur::find($formateurId);

        if ($formateur) {
            if ($formateur->photo && Storage::disk('public')->exists($formateur->photo)) {
                Storage::disk('public')->delete($formateur->photo);
            }
            $formateur->delete();

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Formateur supprimé avec succès.'
            ]);
        }

        $this->formateurId = null;
    }

    private function resetForm()
    {
        $this->reset([
            'formateurId',
            'nom',
            'prenom',
            'domaine',
            'contact',
            'email',
            'adresse',
            'date_naissance',
            'sexe',
            'photo',
            'photo_old',
            'status',
            'password',
            'editMode',
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function cancel()
    {
        $this->resetForm();
        $this->dispatch('closeModal');
    }
}