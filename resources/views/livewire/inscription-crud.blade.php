<div>

    <div class="alert alert-info">
        Nombre d'inscription : {{ $inscriptions->count() }}
    </div>

    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Inscriptions</h4>
                </div>
            </div>
        </div>

        <!-- Liste -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Liste des inscriptions</h5>

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
                                        <th>Etudiant_id</th>
                                        <th>Inscription_id</th>
                                        <th>date_inscription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($inscriptions as $inscription)
                                        <tr>
                                            <td>{{ $inscriptions->id }}</td>
                                            <td>{{ $inscriptions->etudiant_id }}</td>
                                            <td>{{ $inscritpions->formation_id }}</td>
                                            <td>{{ $inscriptions->date_inscription }}</td>
                                           
                                            <td>
                                                <button class="btn btn-sm btn-danger"
                                                        wire:click="deleteInscription({{ $inscription->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                Aucune inscription trouvé
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $inscriptions->links('livewire::bootstrap') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
