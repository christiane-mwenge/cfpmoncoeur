<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>CFP MON COEUR | Centre de Formation Professionnelle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CFP MON COEUR est un centre de formation professionnelle offrant des formations de qualité pour le développement des compétences techniques et professionnelles des jeunes et adultes.">
    <meta name="author" content="CFP MON COEUR, Christiane Mwenge" />
    <meta name="keywords" content="CFP MON COEUR, Centre de formation professionnelle, Formation, Compétences, Jeunes, Adultes, Éducation, Développement professionnel" />
    <meta name="robots" content="index, follow">

    <!-- Favicon Icon -->
  <link rel="icon" type="image/png" href="{{ asset('assets_backend/images/favicon.png?v=1') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets_backend/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets_backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets_backend/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    @livewireStyles
</head>

<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">   
        @include('layouts.partials.header')

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            @include('layouts.partials.sidebar')
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                {{ $slot}}
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © CFP MON COEUR.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Développé par Christiane Mwenge | Centre de Formation Professionnelle
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets_backend/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_backend/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets_backend/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets_backend/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets_backend/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard blog init -->
    <script src="{{ asset('assets_backend/js/pages/dashboard-blog.init.js') }}"></script>

    <script src="{{ asset('assets_backend/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
