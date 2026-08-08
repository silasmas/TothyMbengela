<!-- Main Header -->
<header class="main-header header-style-one">
    <div class="main-box">
        {{-- 3 zones : logo | menu | actions — espaces latéraux équilibrés --}}
        <div class="logo-box">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/logo/alliance-wordmark-ochre-on-white.png') }}?v=2" alt="Alliance — Ministère Tothy Mbengela" title="Alliance" class="alliance-logo-header">
                </a>
            </div>
        </div>

        <div class="nav-outer">
            <nav class="nav main-menu">
                <ul class="navigation">
                    <li class="{{ request()->is('/') ? 'current' : '' }}">
                        <a href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="{{ request()->is('a-propos') ? 'current' : '' }}">
                        <a href="{{ route('about') }}">À propos</a>
                    </li>
                    <li class="{{ request()->is('activites-pasteure*') ? 'current' : '' }}">
                        <a href="{{ route('pastor-activities.index') }}">Agenda</a>
                    </li>
                    <li class="dropdown {{ request()->is('contenus*') || request()->is('series*') ? 'current' : '' }}">
                        <a href="{{ route('contents.index') }}">Contenus</a>
                        <ul>
                            <li><a href="{{ route('contents.index') }}">Toutes les publications</a></li>
                            <li><a href="{{ route('contents.index', ['type' => 'video']) }}">Vidéos</a></li>
                            <li><a href="{{ route('contents.index', ['type' => 'audio']) }}">Audio</a></li>
                            <li><a href="{{ route('contents.index', ['type' => 'podcast']) }}">Podcasts</a></li>
                            <li><a href="{{ route('contents.index', ['type' => 'article']) }}">Articles</a></li>
                            <li><a href="{{ route('series.index') }}">Séries</a></li>
                        </ul>
                    </li>
                    <li class="{{ request()->is('boutique*') ? 'current' : '' }}">
                        <a href="{{ route('books.index') }}">Boutique</a>
                    </li>
                    {{-- Soutenir : bouton flottant (partials/alliance-float-actions) --}}
                    <li class="dropdown {{ request()->is('contact') ? 'current' : '' }}">
                        <a href="{{ route('contact.create') }}">Contact</a>
                        <ul>
                            <li><a href="{{ route('contact.create') }}">Nous écrire</a></li>
                            <li><a href="{{ url('/#prise-rendez-vous') }}">Prendre rendez-vous</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="outer-box alliance-header-outer-actions">
            <button type="button" class="ui-btn search-btn" title="Rechercher" aria-label="Rechercher">
                <span class="icon lnr lnr-icon-search"></span>
            </button>
            <div class="header-cart-wrap">
                <a href="#" class="ui-btn cart-btn" title="Panier" data-bs-toggle="modal" data-bs-target="#allianceCartModal">
                    <span class="icon fa fa-shopping-cart"></span>
                    <span class="cart-count-badge" aria-live="polite">0</span>
                </a>
            </div>
            @include('layouts.nav-account-toolbar', ['accountToolbarOnDark' => false])
            @guest
                <div class="alliance-header-auth-cluster" role="group" aria-label="Connexion et inscription">
                    <a href="{{ route('login') }}" class="alliance-header-auth-link">Connexion</a>
                    <a href="{{ route('register') }}" class="alliance-header-auth-cta">Inscription</a>
                </div>
            @else
                <a href="#" class="info-btn" data-bs-toggle="modal" data-bs-target="#donatePartnerModal" title="Faire un don">
                    <i class="icon fa fa-heart"></i>
                    <strong class="text">Faire un don</strong>
                </a>
            @endguest
            <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>

        <nav class="menu-box">
            <div class="upper-box">
                <div class="nav-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/logo/alliance-wordmark-ochre-on-white.png') }}?v=2" alt="Alliance" title="Alliance" class="alliance-logo-header">
                    </a>
                </div>
                <div class="close-btn"><i class="icon fa fa-times"></i></div>
            </div>

            <ul class="navigation clearfix">
                <!--  Menu injecté automatiquement par le JS du template -->
            </ul>

            <ul class="contact-list-one">
                <li>
                    <div class="contact-info-box">
                        <span class="icon lnr-icon-envelope1"></span>
                        <span class="title">E-mail</span>
                        <a href="mailto:{{ $siteSetting->email ?? 'contact@alliance-ministere.com' }}">{{ $siteSetting->email ?? 'contact@alliance-ministere.com' }}</a>
                    </div>
                </li>
                <li>
                    <div class="contact-info-box">
                        <span class="icon lnr-icon-clock"></span>
                        <span class="title">Horaires</span>
                        Lun – Sam : 8h00 – 18h00
                    </div>
                </li>
            </ul>

            <ul class="social-links">
                @if(!empty($siteSetting?->facebook_url))
                    <li><a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a></li>
                @endif
                @if(!empty($siteSetting?->youtube_url))
                    <li><a href="{{ $siteSetting->youtube_url }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a></li>
                @endif
                @if(!empty($siteSetting?->instagram_url))
                    <li><a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a></li>
                @endif
            </ul>
        </nav>
    </div>

    <!-- Header Search -->
    <div class="search-popup">
        <span class="search-back-drop"></span>
        <button class="close-search"><span class="fa fa-times"></span></button>

        <div class="search-inner" data-search-suggest-url="{{ route('search.suggest') }}">
            <form method="GET" action="{{ route('search') }}" id="header-search-form">
                <div class="form-group">
                    <input type="search" name="q" id="header-search-q" value="" autocomplete="off" placeholder="Rechercher contenus, livres, séries, agenda…" required>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
            <div id="search-live-results" class="search-live-results d-none" role="listbox" aria-label="Suggestions"></div>
        </div>
    </div>

    <!-- Sticky Header -->
    <div class="sticky-header">
        <div class="auto-container">
            <div class="inner-container">
                <div class="logo">
                    <a href="{{ route('home') }}" title="Alliance">
                        <img src="{{ asset('assets/logo/alliance-wordmark-ochre-on-white.png') }}?v=2" alt="Alliance" title="Alliance" class="alliance-logo-header">
                    </a>
                </div>

                <div class="nav-outer">
                    <nav class="main-menu">
                        <div class="navbar-collapse show collapse clearfix">
                            <ul class="navigation clearfix">
                                <!-- Menu injecté automatiquement par le JS du template -->
                            </ul>
                        </div>
                    </nav>

                    <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                </div>

                <div class="sticky-header-actions d-flex align-items-center">
                    <button type="button" class="ui-btn search-btn" title="Rechercher" aria-label="Rechercher">
                        <span class="icon lnr lnr-icon-search"></span>
                    </button>
                    <div class="header-cart-wrap">
                        <a href="#" class="ui-btn cart-btn" title="Panier" data-bs-toggle="modal" data-bs-target="#allianceCartModal">
                            <span class="icon fa fa-shopping-cart"></span>
                            <span class="cart-count-badge" aria-live="polite">0</span>
                        </a>
                    </div>
                    @include('layouts.nav-account-toolbar', ['accountToolbarOnDark' => true])
                    @guest
                        <div class="alliance-sticky-auth-cluster d-flex align-items-center gap-1 flex-shrink-0">
                            <a href="{{ route('login') }}" class="btn btn-sm alliance-sticky-auth-connexion py-2 px-2 px-sm-3">Connexion</a>
                            <a href="{{ route('register') }}" class="theme-btn btn-style-one btn-sm py-2 px-2 px-sm-3" style="white-space:nowrap;"><span class="btn-title">Inscription</span></a>
                        </div>
                    @else
                        <a href="#" class="theme-btn btn-style-one btn-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#donatePartnerModal" style="white-space:nowrap;">
                            <span class="btn-title"><i class="fa fa-heart"></i> Don</span>
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</header>
