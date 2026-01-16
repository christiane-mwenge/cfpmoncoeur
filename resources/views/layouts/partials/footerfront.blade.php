<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Liens rapides</h4>
                <div class="d-flex flex-column">
                    <a class="btn btn-link text-light text-decoration-none mb-2 p-0" href="/about">À propos</a>
                    <a class="btn btn-link text-light text-decoration-none mb-2 p-0" href="/contact">Nous contacter</a>
                    <a class="btn btn-link text-light text-decoration-none mb-2 p-0" href="/privacy">Politique de confidentialité</a>
                    <a class="btn btn-link text-light text-decoration-none mb-2 p-0" href="/terms">Conditions générales</a>
                    <a class="btn btn-link text-light text-decoration-none mb-2 p-0" href="/faq">FAQ & Aide</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Contact</h4>
                <div class="d-flex flex-column">
                    <p class="mb-2 d-flex align-items-center">
                        <i class="fa fa-map-marker-alt me-3"></i>
                        <span>Goma, RDC</span>
                    </p>
                    <p class="mb-2 d-flex align-items-center">
                        <i class="fa fa-phone-alt me-3"></i>
                        <span>0000000000</span>
                    </p>
                    <p class="mb-2 d-flex align-items-center">
                        <i class="fa fa-envelope me-3"></i>
                        <span>cfpmoncoeur@gmail.org</span>
                    </p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social rounded-circle me-2" href="#" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="btn btn-outline-light btn-social rounded-circle me-2" href="#" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="btn btn-outline-light btn-social rounded-circle me-2" href="#" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href="#" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Galerie</h4>
                <div class="row g-2 pt-2">
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1 rounded" src="{{ asset('assets_frontend/img/course-1.jpg') }}" alt="Image de cours 1">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1 rounded" src="{{ asset('assets_frontend/img/course-2.jpg') }}" alt="Image de cours 2">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1 rounded" src="{{ asset('assets_frontend/img/course-3.jpg') }}" alt="Image de cours 3">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1 rounded" src="{{ asset('assets_frontend/img/course-4.jpg') }}" alt="Image de cours 4">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1 rounded" src="{{ asset('assets_frontend/img/course-5.jpg') }}" alt="Image de cours 5">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1 rounded" src="{{ asset('assets_frontend/img/course-6.jpg') }}" alt="Image de cours 6">
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Newsletter</h4>
                <p>Inscrivez-vous pour recevoir nos dernières actualités et offres.</p>
                <form action="#" method="post" class="position-relative mx-auto" style="max-width: 400px;">
                    @csrf
                    <div class="input-group">
                        <input class="form-control border-0 py-3 ps-4" type="email" name="email" placeholder="Votre email" required aria-label="Votre adresse email">
                        <button type="submit" class="btn btn-primary py-3 px-4">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container border-top border-secondary py-4">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-2">&copy; {{ date('Y') }} <a class="text-light text-decoration-none" href="/">CFP MON COEUR</a>. Tous droits réservés.</p>
                <p class="mb-0">Développé par <a class="text-light text-decoration-none" href="#">Christiane MWENGE</a></p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="footer-menu">
                    <a href="/" class="text-light text-decoration-none me-3">Accueil</a>
                    <a href="/cookies" class="text-light text-decoration-none me-3">Cookies</a>
                    <a href="/help" class="text-light text-decoration-none me-3">Aide</a>
                    <a href="/faq" class="text-light text-decoration-none">FAQ</a>
                </div>
            </div>
        </div>
    </div>
</div>