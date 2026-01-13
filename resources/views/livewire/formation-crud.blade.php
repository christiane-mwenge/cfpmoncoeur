<div>
    <!-- Message flash -->
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
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
                       wire:model.live="searchTerm">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formationModal">
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($formations as $formation)
                                        <tr>
                                            <td>{{ $formation->id }}</td>
                                            <td>
                                                @if($formation->photo)
                                                    <img src="{{ asset($formation->photo) }}" alt="Photo de la formation" style="width:100px; height:auto;">
                                                @endif
                                            </td>
                                            <td>{{ $formation->titre }}</td>
                                            <td>{{ $formation->description }}</td>
                                            <td>{{ $formation->formateur->nom ?? '' }} {{ $formation->formateur->prenom ?? '' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning"
                                                        wire:click="editFormation({{ $formation->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <button class="btn btn-sm btn-danger"
                                                        wire:click="deleteFormation({{ $formation->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Aucune formation trouvée</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $formations->links('livewire::bootstrap') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour ajouter / modifier -->
        <div class="modal fade" id="formationModal" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form wire:submit.prevent="{{ $editMode ? 'updateFormation' : 'addFormation' }}">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $editMode ? 'Modifier la formation' : 'Ajouter une formation' }}</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Titre -->
                                <div class="mb-3 col-md-12">
                                    <label for="titre" class="form-label">Titre</label>
                                    <input type="text" class="form-control" id="titre"
                                           wire:model.live="titre" placeholder="Entrez le titre">
                                    @error('titre') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
<!-- Objectif -->
                                <div class="mb-3 col-md-12">
                                    <label for="objectif" class="form-label">Objectif</label>
                                    <textarea class="form-control" id="objectif" wire:model.live="objectif" placeholder="Entrez l'objectif"></textarea>
                                    @error('objectif') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <!-- Description -->
                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" wire:model.live="description" placeholder="Entrez la description"
                                    rows="20"></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>


                                <!-- Session -->
                                <div class="mb-3 col-md-6">
                                    <label for="session" class="form-label">Session</label>
                                    <input type="text" class="form-control" id="session"
                                           wire:model.live="session" placeholder="Entrez la session">
                                    @error('session') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Prérequis -->
                                <div class="mb-3 col-md-6">
                                    <label for="prerequis" class="form-label">Prérequis</label>
                                    <input type="text" class="form-control" id="prerequis"
                                           wire:model.live="prerequis" placeholder="Entrez les prérequis">
                                    @error('prerequis') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Durée -->
                                <div class="mb-3 col-md-6">
                                    <label for="duree" class="form-label">Durée</label>
                                    <input type="text" class="form-control" id="duree"
                                           wire:model.live="duree" placeholder="Entrez la durée">
                                    @error('duree') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Date de début -->
                                <div class="mb-3 col-md-6">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" class="form-control" id="date_debut"
                                           wire:model.live="date_debut">
                                    @error('date_debut') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Date de fin -->
                                <div class="mb-3 col-md-6">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" class="form-control" id="date_fin"
                                           wire:model.live="date_fin">
                                    @error('date_fin') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Lieu -->
                                <div class="mb-3 col-md-6">
                                    <label for="lieu" class="form-label">Lieu</label>
                                    <input type="text" class="form-control" id="lieu"
                                           wire:model.live="lieu" placeholder="Entrez le lieu">
                                    @error('lieu') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Photo -->
                                <div class="mb-3 col-md-6">
                                    <label for="photo" class="form-label">Photo</label>
                                    <input type="file" class="form-control" id="photo"
                                           wire:model.live="photo" placeholder=" choisissez la photo">
                                            {{-- @if ($photo)
                                            Photo Preview:
                                            <img src="{{ $photo->temporaryUrl() }}" width="100px;" height="100px;">
                                        @endif --}}
                                    @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Vidéo -->
                                <div class="mb-3 col-md-6">
                                    <label for="video" class="form-label">Vidéo (URL)</label>
                                    <input type="text" class="form-control" id="video"
                                           wire:model.live="video" placeholder="Entrez l'URL de la vidéo">
                                    @error('video') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Formateur -->
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Formateur</label>
                                    <select class="form-control" wire:model.live="formateur_id">
                                        <option> Choisissez le nom du formateur</option>
                                        <option value="">Sélectionnez un formateur</option>
                                        @foreach ($formateurs as $item)
                                            <option value="{{ $item->id }}">{{ $item->nom }} {{ $item->prenom }}</option>
                                        @endforeach
                                    </select>
                                    @error('formateur_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button class="btn btn-primary" type="submit">{{ $editMode ? 'Modifier' : 'Enregistrer' }}</button>
                        </div>
                                                    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('formationAdded', () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('formationModal'));
                if (modal) modal.hide();
            });

            Livewire.on('formationUpdated', () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('formationModal'));
                if (modal) modal.hide();
            });

            Livewire.on('openModal', () => {
                const modal = new bootstrap.Modal(document.getElementById('formationModal'));
                modal.show();
            });
        });
    </script>
    @endpush
</div>
