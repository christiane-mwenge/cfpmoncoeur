<div>
    <!-- Message flash -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Formations</h4>
                </div>
            </div>
        </div>

        <!-- Barre de recherche et bouton Ajouter -->
        <div class="row mb-3">
            <div class="col-12 d-flex flex-column flex-md-row gap-2">
                <input type="text" class="form-control"
                       placeholder="Rechercher une formation..."
                       wire:model.live.debounce.500ms="searchTerm">
                <button class="btn btn-primary" wire:click="resetFormAndOpen">
                    <i class="fas fa-plus-circle"></i> Ajouter une formation
                </button>
            </div>
        </div>

        <!-- Tableau des formations -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Liste des formations</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>PHOTO</th>
                                        <th>Titre</th>
                                        <th>Description</th>
                                        <th>Formateur</th>
                                        <th>Prix</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($formations as $formation)
                                        <tr>
                                            <td>{{ $formation->id }}</td>
                                            <td>
                                                @if($formation->photo)
                                                    <img src="{{ Storage::url($formation->photo) }}" 
                                                         alt="Photo de la formation" 
                                                         style="width:80px; height:60px; object-fit:cover; border-radius:5px;">
                                                @else
                                                    <span class="text-muted">Aucune photo</span>
                                                @endif
                                            </td>
                                            <td>{{ $formation->titre }}</td>
                                            <td>{{ Str::limit($formation->description, 50) }}</td>
                                            <td>
                                                {{ $formation->formateur->nom ?? '' }} 
                                                {{ $formation->formateur->prenom ?? '' }}
                                            </td>
                                            <td>{{ number_format($formation->prix, 2, ',', ' ') }} €</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning"
                                                        wire:click="editFormation({{ $formation->id }})"
                                                        title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <button class="btn btn-sm btn-danger ms-2"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer cette formation ?')"
                                                        wire:click="deleteFormation({{ $formation->id }})"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                                <p class="text-muted">Aucune formation trouvée</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $formations->links('livewire::bootstrap') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour ajouter / modifier -->
        <div class="modal fade" id="formationModal" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form wire:submit.prevent="{{ $editMode ? 'updateFormation' : 'addFormation' }}" 
                          enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ $editMode ? 'Modifier la formation' : 'Ajouter une formation' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Titre -->
                                <div class="mb-3 col-md-12">
                                    <label for="titre" class="form-label">Titre *</label>
                                    <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                           id="titre" wire:model.live="titre" 
                                           placeholder="Entrez le titre">
                                    @error('titre') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Objectif -->
                                <div class="mb-3 col-md-12">
                                    <label for="objectif" class="form-label">Objectif</label>
                                    <textarea class="form-control @error('objectif') is-invalid @enderror" 
                                              id="objectif" wire:model.live="objectif" 
                                              rows="3" placeholder="Entrez l'objectif"></textarea>
                                    @error('objectif') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">Description *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" wire:model.live="description" 
                                              rows="5" placeholder="Entrez la description"></textarea>
                                    @error('description') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Session -->
                                <div class="mb-3 col-md-6">
                                    <label for="session" class="form-label">Session</label>
                                    <input type="text" class="form-control @error('session') is-invalid @enderror" 
                                           id="session" wire:model.live="session" 
                                           placeholder="Entrez la session">
                                    @error('session') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Prérequis -->
                                <div class="mb-3 col-md-6">
                                    <label for="prerequis" class="form-label">Prérequis</label>
                                    <input type="text" class="form-control @error('prerequis') is-invalid @enderror" 
                                           id="prerequis" wire:model.live="prerequis" 
                                           placeholder="Entrez les prérequis">
                                    @error('prerequis') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Durée -->
                                <div class="mb-3 col-md-6">
                                    <label for="duree" class="form-label">Durée</label>
                                    <input type="text" class="form-control @error('duree') is-invalid @enderror" 
                                           id="duree" wire:model.live="duree" 
                                           placeholder="Ex: 2 jours, 30 heures">
                                    @error('duree') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date de début -->
                                <div class="mb-3 col-md-6">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" class="form-control @error('date_debut') is-invalid @enderror" 
                                           id="date_debut" wire:model.live="date_debut">
                                    @error('date_debut') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date de fin -->
                                <div class="mb-3 col-md-6">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" class="form-control @error('date_fin') is-invalid @enderror" 
                                           id="date_fin" wire:model.live="date_fin">
                                    @error('date_fin') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Lieu -->
                                <div class="mb-3 col-md-6">
                                    <label for="lieu" class="form-label">Lieu</label>
                                    <input type="text" class="form-control @error('lieu') is-invalid @enderror" 
                                           id="lieu" wire:model.live="lieu" 
                                           placeholder="Entrez le lieu">
                                    @error('lieu') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Prix -->
                                <div class="mb-3 col-md-6">
                                    <label for="prix" class="form-label">Prix (€) *</label>
                                    <input type="number" step="0.01" 
                                           class="form-control @error('prix') is-invalid @enderror" 
                                           id="prix" wire:model.live="prix" 
                                           placeholder="Ex: 299.99">
                                    @error('prix') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Photo -->
                                <div class="mb-3 col-md-6">
                                    <label for="photo" class="form-label">
                                        Photo @if($editMode && $photo_old) (Optionnel) @endif
                                    </label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                           id="photo" wire:model.live="photo" 
                                           accept="image/*">
                                    
                                    @if($editMode && $photo_old)
                                        <div class="mt-2">
                                            <small>Photo actuelle :</small><br>
                                            <img src="{{ Storage::url($photo_old) }}" 
                                                 alt="Photo actuelle" 
                                                 style="width:100px; height:auto;"
                                                 class="mt-1">
                                        </div>
                                    @endif
                                    
                                    @error('photo') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($photo)
                                        <div class="mt-2">
                                            <small>Aperçu :</small><br>
                                            <img src="{{ $photo->temporaryUrl() }}" 
                                                 alt="Aperçu" 
                                                 style="width:100px; height:auto;"
                                                 class="mt-1">
                                        </div>
                                    @endif
                                </div>

                                <!-- Vidéo -->
                                <div class="mb-3 col-md-6">
                                    <label for="video" class="form-label">Vidéo (URL)</label>
                                    <input type="text" class="form-control @error('video') is-invalid @enderror" 
                                           id="video" wire:model.live="video" 
                                           placeholder="Entrez l'URL de la vidéo">
                                    @error('video') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Formateur -->
                                <div class="mb-3 col-md-12">
                                    <label for="formateur_id" class="form-label">Formateur *</label>
                                    <select class="form-control @error('formateur_id') is-invalid @enderror" 
                                            wire:model.live="formateur_id">
                                        <option value="">Choisissez un formateur</option>
                                        @foreach ($formateurs as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nom }} {{ $item->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('formateur_id') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" 
                                    data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">
                                {{ $editMode ? 'Modifier' : 'Enregistrer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Ouvrir le modal
            Livewire.on('openModal', () => {
                const modal = new bootstrap.Modal(document.getElementById('formationModal'));
                modal.show();
            });
            
            // Fermer le modal
            Livewire.on('closeModal', () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('formationModal'));
                if (modal) modal.hide();
            });
        });
        
        // Fermer le modal avec la touche ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modal = bootstrap.Modal.getInstance(document.getElementById('formationModal'));
                if (modal) modal.hide();
            }
        });
        
        // Réinitialiser le formulaire quand le modal est fermé
        document.getElementById('formationModal').addEventListener('hidden.bs.modal', function () {
            Livewire.dispatch('resetForm');
        });
    </script>
    @endpush
</div>