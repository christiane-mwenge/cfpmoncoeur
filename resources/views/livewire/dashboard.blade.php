<div>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">TABLEAU DE BORD</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row g-3">
            <!-- Carte Formateurs -->
            <div class="col-lg-4 col-md-6">
                <div class="card text-white bg-primary">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">Total Formateurs</p>
                            <h4 class="mb-0">{{ $totalFormateurs ?? 0 }}</h4>
                        </div>
                        <i class="bx bxs-user bx-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Carte Formations -->
            <div class="col-lg-4 col-md-6">
                <div class="card text-white bg-success">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">Total Formations</p>
                            <h4 class="mb-0">{{ $totalFormations ?? 0 }}</h4>
                        </div>
                        <i class="bx bxs-book bx-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Carte Étudiants -->
            <div class="col-lg-4 col-md-6">
                <div class="card text-white bg-warning">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">Total Étudiants</p>
                            <h4 class="mb-0">{{ $totalEtudiants ?? 0 }}</h4>
                        </div>
                        <i class="bx bxs-graduation bx-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Carte Inscriptions -->
            <div class="col-lg-4 col-md-6">
                <div class="card text-white bg-danger">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">Total Inscriptions</p>
                            <h4 class="mb-0">{{ $totalInscriptions ?? 0 }}</h4>
                        </div>
                        <i class="bx bxs-notepad bx-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Carte Dons -->
            <div class="col-lg-4 col-md-6">
                <div class="card text-white bg-info">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">Total Dons</p>
                            <h4 class="mb-0">{{ $totalDons ?? 0 }}</h4>
                        </div>
                        <i class="bx bxs-wallet bx-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique ou autre section -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Visitors</h5>
                <div class="row text-center">
                    <div class="col-lg-12">
                        <div class="mt-4">
                            <p class="text-muted mb-1">Today</p>
                            <h5>1024</h5>
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="apex-charts" id="area-chart" dir="ltr"></div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
