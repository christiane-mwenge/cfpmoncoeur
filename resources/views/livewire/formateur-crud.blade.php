<div>
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Formateurs</h4>
                </div>
            </div>
        </div>

        <!-- Barre de recherche et bouton Ajouter -->
        <div class="row mb-3">
            <div class="col-12 d-flex flex-column flex-md-row gap-2">
                <input type="text" class="form-control"
                       placeholder="Rechercher un formateur..."
                       wire:model.debounce.300ms="searchTerm">
                <button class="btn btn-primary" wire:click="$set('editMode', false)" data-bs-toggle="modal" data-bs-target="#formateurModal">
                    <i class="fas fa-plus-circle"></i> Ajouter un formateur
                </button>
            </div>
        </div>

        <!-- Tableau des formateurs -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Liste des formateurs</h5>
                        
                        <!-- Messages de succès/erreur -->
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>PHOTO</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Domaine</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($formateurs as $formateur)
                                        <tr>
                                            <td>{{ $formateur->id }}</td>
                                            <td>
                                                @if($formateur->photo)
                                                    <img src="{{ asset('storage/' . $formateur->photo) }}" 
                                                         alt="Photo du formateur" 
                                                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                                @else
                                                    <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user" style="color: #6c757d;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $formateur->nom }}</td>
                                            <td>{{ $formateur->prenom }}</td>
                                            <td>{{ $formateur->domaine }}</td>
                                            <td>{{ $formateur->contact }}</td>
                                            <td>{{ $formateur->email }}</td>
                                            <td>
                                                @if($formateur->status == 'active')
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-danger">Inactif</span> <!-- Corrigé ici -->
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm btn-warning"
                                                            wire:click="editFormateur({{ $formateur->id }})"
                                                            data-bs-toggle="modal" data-bs-target="#formateurModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger"
                                                            wire:click="confirmDelete({{ $formateur->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Aucun formateur trouvé</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination corrigée -->
                            @if($formateurs->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $formateurs->links('livewire::bootstrap') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour ajouter / modifier -->
        <div class="modal fade" id="formateurModal" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form wire:submit.prevent="{{ $editMode ? 'updateFormateur' : 'addFormateur' }}" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $editMode ? 'Modifier le formateur' : 'Ajouter un formateur' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Nom -->
                                <div class="mb-3 col-md-6">
                                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom"
                                           wire:model="nom" placeholder="Entrez le nom">
                                    @error('nom') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Prénom -->
                                <div class="mb-3 col-md-6">
                                    <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom"
                                           wire:model="prenom" placeholder="Entrez le prénom">
                                    @error('prenom') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Domaine -->
                                <div class="mb-3 col-md-6">
                                    <label for="domaine" class="form-label">Domaine <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('domaine') is-invalid @enderror" id="domaine"
                                           wire:model="domaine" placeholder="Entrez le domaine">
                                    @error('domaine') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Contact -->
                                <div class="mb-3 col-md-6">
                                    <label for="contact" class="form-label">Contact <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact"
                                           wire:model="contact" placeholder="Entrez le numéro de téléphone">
                                    @error('contact') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                           wire:model="email" placeholder="Entrez l'email">
                                    @error('email') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mot de passe -->
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">
                                        Mot de passe {!! !$editMode ? '<span class="text-danger">*</span>' : '' !!}
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                           wire:model="password" 
                                           placeholder="{{ $editMode ? 'Laisser vide pour ne pas changer' : 'Entrez le mot de passe' }}">
                                    @error('password') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($editMode)
                                        <small class="text-muted">Laissez vide pour garder le mot de passe actuel</small>
                                    @endif
                                </div>

                                <!-- Adresse -->
                                <div class="mb-3 col-md-12">
                                    <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse"
                                           wire:model="adresse" placeholder="Entrez l'adresse">
                                    @error('adresse') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date de naissance -->
                                <div class="mb-3 col-md-6">
                                    <label for="date_naissance" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance"
                                           wire:model="date_naissance" max="{{ date('Y-m-d') }}">
                                    @error('date_naissance') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sexe -->
                                <div class="mb-3 col-md-6">
                                    <label for="sexe" class="form-label">Sexe <span class="text-danger">*</span></label>
                                    <select class="form-control @error('sexe') is-invalid @enderror" id="sexe" wire:model="sexe">
                                        <option value="">Sélectionnez le sexe</option>
                                        <option value="homme">Masculin</option>
                                        <option value="femme">Féminin</option>
                                    </select>
                                    @error('sexe') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Statut -->
                                <div class="mb-3 col-md-6">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" wire:model="status">
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option> <!-- Corrigé ici -->
                                    </select>
                                    @error('status') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Photo -->
                                <div class="mb-3 col-md-12">
                                    <label for="photo" class="form-label">Photo</label>
                                    
                                    @if($editMode && $photo_old)
                                        <div class="mb-2">
                                            <p class="mb-1">Photo actuelle :</p>
                                            <img src="{{ asset('storage/' . $photo_old) }}" 
                                                 alt="Photo actuelle" 
                                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                            <button type="button" class="btn btn-sm btn-outline-danger ms-2" 
                                                    wire:click="$set('photo_old', null)">
                                                Supprimer
                                            </button>
                                        </div>
                                    @endif
                                    
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo"
                                           wire:model="photo" accept="image/*">
                                    <small class="text-muted">Formats acceptés : JPG, PNG, WEBP (max 15MB)</small>
                                    
                                    @if ($photo && !$photo->getError())
                                        <div class="mt-2">
                                            <p class="mb-1">Aperçu de la nouvelle photo :</p>
                                            <img src="{{ $photo->temporaryUrl() }}" 
                                                 alt="Aperçu photo" 
                                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                        </div>
                                    @endif
                                    
                                    @error('photo') 
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">
                                @if($editMode)
                                    <i class="fas fa-save"></i> Modifier
                                @else
                                    <i class="fas fa-plus"></i> Enregistrer
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            // Réinitialiser le formulaire quand le modal est fermé
            const modalElement = document.getElementById('formateurModal');
            if (modalElement) {
                modalElement.addEventListener('hidden.bs.modal', function () {
                    @this.dispatch('cancel');
                });
            }
        });
        
        // Gestion de la suppression avec confirmation
        window.addEventListener('livewire:init', () => {
            Livewire.on('confirmDelete', (event) => {
                if (confirm('Voulez-vous vraiment supprimer ce formateur ?')) {
                    // Appeler la méthode deleteFormateur directement
                    @this.call('deleteFormateur', event.id);
                }
            });
            
            Livewire.on('showAlert', (event) => {
                // Créer une alerte Bootstrap
                const alertHtml = `
                    <div class="alert alert-${event.type} alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999; max-width: 400px;" role="alert">
                        ${event.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                document.body.insertAdjacentHTML('beforeend', alertHtml);
                
                // Supprimer automatiquement après 3 secondes
                setTimeout(() => {
                    const alert = document.querySelector('.alert.position-fixed');
                    if (alert) {
                        alert.remove();
                    }
                }, 3000);
            });
        });
    </script>
    @endpush
</div>