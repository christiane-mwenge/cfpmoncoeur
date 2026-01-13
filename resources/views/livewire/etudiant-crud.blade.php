<div>

    <div class="alert alert-info">
        Nombre d'étudiants : {{ $etudiants->count() }}
    </div>

    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Étudiants</h4>
                </div>
            </div>
        </div>

        <!-- Liste -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Liste des étudiants</h5>

                        <div class="d-flex flex-column flex-md-row gap-2 mb-3">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Rechercher un étudiant..."
                                   wire:model.live="searchTerm">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Sexe</th>
                                        <th>Date de naissance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($etudiants as $etudiant)
                                        <tr>
                                            <td>{{ $etudiant->id }}</td>
                                            <td>{{ $etudiant->nom }}</td>
                                            <td>{{ $etudiant->prenom }}</td>
                                            <td>{{ $etudiant->contact }}</td>
                                            <td>{{ $etudiant->email }}</td>
                                            <td>{{ $etudiant->sexe }}</td>
                                            <td>{{ $etudiant->date_naissance }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger"
                                                        wire:click="deleteEtudiant({{ $etudiant->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                Aucun étudiant trouvé
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $etudiants->links('livewire::bootstrap') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
