

<!-- Main Footer -->
<footer class="main-footer">
    <!-- Upper Box -->
    <div class="auto-container">
        <div class="upper-box">
            <div class="row">
                <div class="contact-info logo-box col-lg-4 col-md-12 wow fadeInUp text-center">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/logo/logo-alliance.png') }}" alt="Alliance — Ministère Tothy Mbengela">
                        </a>
                    </div>
                </div>

                <div class="contact-info col-lg-4 col-md-12 wow fadeInRight">
                    <div class="inner-box">
                        <h4 class="title">Écrivez-nous</h4>
                        <div class="text"><a href="mailto:contact@alliance-ministere.com">contact@alliance-ministere.com</a></div>
                    </div>
                </div>

                <div class="contact-info col-lg-4 col-md-12 wow fadeInLeft" data-wow-delay="600ms">
                    <div class="inner-box">
                        <h4 class="title">Rendez-vous</h4>
                        <div class="text"><a href="{{ url('/#prise-rendez-vous') }}">Prendre rendez-vous</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Widgets Section -->
    <div class="widgets-section">
        <div class="auto-container">
            <div class="row">
                <!-- À propos -->
                <div class="footer-column col-xl-5 col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-xl-7 col-lg-6 col-md-6">
                            <div class="footer-widget about-widget">
                                <h6 class="widget-title">À propos</h6>
                                <div class="text">Ministère de la Pasteure Tothy Mbengela — Prédications, enseignements et accompagnement spirituel pour l'édification de la foi.</div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-6">
                            <div class="footer-widget">
                                <h6 class="widget-title">Navigation</h6>
                                <ul class="user-links">
                                    <li><a href="{{ route('home') }}">Accueil</a></li>
                                    <li><a href="{{ route('about') }}">À propos</a></li>
                                    <li><a href="{{ route('contents.index') }}">Contenus</a></li>
                                    <li><a href="{{ route('series.index') }}">Séries</a></li>
                                    <li><a href="{{ route('books.index') }}">Boutique</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="footer-column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget contacts-widget">
                        <h6 class="widget-title">Services</h6>
                        <ul class="user-links">
                            <li><a href="{{ route('contact.create') }}">Nous contacter</a></li>
                            <li><a href="{{ url('/#prise-rendez-vous') }}">Prendre rendez-vous</a></li>
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#donatePartnerModal">Faire un don</a></li>
                            <li><a href="#" class="js-donate-modal-partner">Devenir partenaire</a></li>
                        </ul>
                        <ul class="social-icon-two">
                            <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="footer-column col-xl-4 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <h6 class="widget-title">Newsletter</h6>
                        <div class="widget-content">
                            <div class="subscribe-form">
                                <div class="text">Inscrivez-vous pour recevoir nos dernières publications et actualités.</div>
                                <form method="POST" action="{{ route('newsletter.store') }}" id="footer-newsletter-form">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" class="email" value="{{ old('email') }}" placeholder="Votre adresse e-mail" required>
                                        <button type="submit" class="theme-btn">
                                            <span class="btn-title"><i class="fa fa-paper-plane"></i></span>
                                        </button>
                                    </div>
                                    @error('email')
                                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                                    @enderror
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="auto-container">
            <div class="inner-container">
                <div class="copyright-text">
                    <p>&copy; {{ date('Y') }} <a href="{{ route('home') }}">Alliance</a> — Ministère Tothy Mbengela. Tous droits réservés.</p>
                    <p class="mb-0 mt-2" style="font-size:13px;opacity:0.85;">Designed by <a href="https://silasmas.com" target="_blank" rel="noopener noreferrer">Sdev</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
