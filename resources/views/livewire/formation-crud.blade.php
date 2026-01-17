<div>
    <!-- Message flash -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid">
        <!-- Boutons pour changer le mode d'affichage -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-size-18">Formations</h4>
                    
                    <div class="btn-group" role="group">
                        <button wire:click="$set('displayMode', 'grid')" 
                                class="btn {{ $displayMode === 'grid' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-th-large me-1"></i> Vue Grille
                        </button>
                        <button wire:click="$set('displayMode', 'admin')" 
                                class="btn {{ $displayMode === 'admin' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-list me-1"></i> Vue Tableau
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de recherche -->
        <div class="row mb-3">
            <div class="col-12 d-flex flex-column flex-md-row gap-2">
                <input type="text" class="form-control"
                       placeholder="Rechercher une formation..."
                       wire:model.live.debounce.500ms="searchTerm">
                <button class="btn btn-primary" wire:click="resetFormAndOpen">
                    <i class="fas fa-plus-circle"></i> Ajouter
                </button>
            </div>
        </div>

        @if($displayMode === 'grid')
            <!-- MODE GRID -->
            <div class="row g-4">
                @forelse ($formations as $formation)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 course-card shadow-sm border-0">
                            <div class="position-relative">
                                <!-- Photo de la formation -->
                                @if($formation->photo)
                                    @php
                                        $photoUrl = Storage::disk('public')->exists($formation->photo) 
                                            ? asset('storage/' . $formation->photo) 
                                            : null;
                                    @endphp
                                    @if($photoUrl)
                                        <img src="{{ $photoUrl }}" 
                                             class="card-img-top" 
                                             alt="{{ $formation->titre }}"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                                    </div>
                                @endif
                                
                                <!-- Badge de prix -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success fs-6">
                                        @if($formation->prix == 0 || $formation->prix == null)
                                            GRATUIT
                                        @else
                                            {{ number_format($formation->prix, 0, ',', ' ') }} FC
                                        @endif
                                    </span>
                                </div>
                                
                                @if($formation->session)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-info">Session {{ $formation->session }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title mb-3">{{ $formation->titre }}</h5>
                                
                                <p class="card-text text-muted mb-3" style="min-height: 60px;">
                                    {{ Str::limit($formation->description, 100) }}
                                </p>
                                
                                @if($formation->objectif)
                                    <p class="card-text small mb-3">
                                        <strong>Objectif :</strong> {{ Str::limit($formation->objectif, 80) }}
                                    </p>
                                @endif
                                
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-user-tie me-1"></i>
                                            {{ $formation->formateur->nom ?? 'N/A' }}
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $formation->duree ?? 'N/A' }}
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            @if($formation->date_debut)
                                                {{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ Str::limit($formation->lieu ?? 'N/A', 15) }}
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <button class="btn btn-outline-primary btn-sm"
                                            wire:click="editFormation({{ $formation->id }})">
                                        <i class="fas fa-edit me-1"></i> Modifier
                                    </button>
                                    
                                    <button class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette formation ?')"
                                            wire:click="deleteFormation({{ $formation->id }})">
                                        <i class="fas fa-trash me-1"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Aucune formation trouvée</h4>
                            <button class="btn btn-primary" wire:click="resetFormAndOpen">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter une formation
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        @else
            <!-- MODE TABLEAU -->
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
                                                        @php
                                                            $photoUrl = Storage::disk('public')->exists($formation->photo) 
                                                                ? asset('storage/' . $formation->photo) 
                                                                : null;
                                                        @endphp
                                                        @if($photoUrl)
                                                            <img src="{{ $photoUrl }}" 
                                                                 alt="Photo" 
                                                                 style="width:80px; height:60px; object-fit:cover; border-radius:5px;">
                                                        @else
                                                            <span class="text-muted">Aucune photo</span>
                                                        @endif
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
                                                <td>{{ number_format($formation->prix, 0, ',', ' ') }} FC</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning"
                                                            wire:click="editFormation({{ $formation->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    
                                                    <button class="btn btn-sm btn-danger ms-2"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer cette formation ?')"
                                                            wire:click="deleteFormation({{ $formation->id }})">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Pagination -->
        @if($formations->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $formations->links('livewire::bootstrap') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal -->
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
                                <div class="mb-3 col-md-12">
                                    <label for="titre" class="form-label">Titre *</label>
                                    <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                           id="titre" wire:model.live="titre">
                                    @error('titre') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="objectif" class="form-label">Objectif</label>
                                    <textarea class="form-control @error('objectif') is-invalid @enderror" 
                                              id="objectif" wire:model.live="objectif" 
                                              rows="3"></textarea>
                                    @error('objectif') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">Description *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" wire:model.live="description" 
                                              rows="5"></textarea>
                                    @error('description') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="session" class="form-label">Session</label>
                                    <input type="text" class="form-control @error('session') is-invalid @enderror" 
                                           id="session" wire:model.live="session">
                                    @error('session') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prerequis" class="form-label">Prérequis</label>
                                    <input type="text" class="form-control @error('prerequis') is-invalid @enderror" 
                                           id="prerequis" wire:model.live="prerequis">
                                    @error('prerequis') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="duree" class="form-label">Durée</label>
                                    <input type="text" class="form-control @error('duree') is-invalid @enderror" 
                                           id="duree" wire:model.live="duree">
                                    @error('duree') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" class="form-control @error('date_debut') is-invalid @enderror" 
                                           id="date_debut" wire:model.live="date_debut">
                                    @error('date_debut') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" class="form-control @error('date_fin') is-invalid @enderror" 
                                           id="date_fin" wire:model.live="date_fin">
                                    @error('date_fin') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="lieu" class="form-label">Lieu</label>
                                    <input type="text" class="form-control @error('lieu') is-invalid @enderror" 
                                           id="lieu" wire:model.live="lieu">
                                    @error('lieu') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prix" class="form-label">Prix (FC) *</label>
                                    <input type="number" step="0.01" 
                                           class="form-control @error('prix') is-invalid @enderror" 
                                           id="prix" wire:model.live="prix">
                                    @error('prix') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

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
                                            @php
                                                $oldPhotoUrl = Storage::disk('public')->exists($photo_old) 
                                                    ? asset('storage/' . $photo_old) 
                                                    : null;
                                            @endphp
                                            @if($oldPhotoUrl)
                                                <img src="{{ $oldPhotoUrl }}" 
                                                     alt="Photo actuelle" 
                                                     style="width:100px; height:auto;"
                                                     class="mt-1">
                                            @endif
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

                                <div class="mb-3 col-md-6">
                                    <label for="video" class="form-label">Vidéo (URL)</label>
                                    <input type="text" class="form-control @error('video') is-invalid @enderror" 
                                           id="video" wire:model.live="video">
                                    @error('video') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

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