<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Accueil' }} — Alliance | Ministère Tothy Mbengela</title>
        <meta name="description" content="{{ $metaDescription ?? 'Alliance — Le ministère de la Pasteure Tothy Mbengela. Prédications, enseignements, livres et ressources spirituelles.' }}">

        <link rel="shortcut icon" href="{{ asset('assets/logo/logo-alliance-mark.png') }}" type="image/png">
        <link rel="icon" href="{{ asset('assets/logo/logo-alliance-mark.png') }}" type="image/png">

        <!-- Charte Alliance — polices -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Great+Vibes&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Stylesheets -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/revolution/css/settings.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/plugins/revolution/css/layers.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/plugins/revolution/css/navigation.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/alliance-brand.css') }}?v=4" rel="stylesheet">
        <link href="{{ asset('assets/css/alliance-engagement-pages.css') }}?v=6" rel="stylesheet">
        <link href="{{ asset('assets/css/pastor-activities.css') }}?v=8" rel="stylesheet">

        <!-- Alliance overrides -->
        <style>
            /* Logo PNG transparent : aucun fond noir derrière l’image */
            .main-header .logo img,
            .sticky-header .logo img,
            .mobile-menu .nav-logo img,
            .main-footer .logo img {
                background: transparent !important;
                background-color: transparent !important;
            }

            /* Logo header (fond blanc) : version foncée, plus grande */
            .main-header .logo img,
            .main-header .logo img.alliance-logo-header {
                max-height: 104px;
                width: auto;
            }

            /* Logo sticky */
            .sticky-header .logo img {
                max-height: 78px;
                width: auto;
            }

            /* Logo menu mobile */
            .mobile-menu .nav-logo img {
                max-height: 80px;
                width: auto;
            }

            /* Logo footer : agrandi */
            .main-footer .logo img {
                max-height: 140px;
                width: auto;
            }

            /* Cards boutique accueil : titre court, couverture plus visible, prix lisible */
            .home5-features-section .feature-block-home5 .image-box {
                padding-bottom: 8px;
            }
            .home5-features-section .feature-block-home5 .image-box .image img {
                height: 400px;
                object-fit: cover;
            }
            .home5-features-section .feature-block-home5 .info-box {
                padding: 10px 40px 10px 70px;
            }
            .home5-features-section .feature-block-home5 .info-box .icon {
                height: 44px;
                width: 44px;
                font-size: 18px;
                top: -22px;
                left: 14px;
            }
            .home5-features-section .feature-block-home5 .image-box > .info-box .title {
                font-size: 13px;
                line-height: 1.2;
                margin-bottom: 6px;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                max-width: 100%;
            }
            .home5-features-section .feature-block-home5 .read-more {
                top: 12px;
                right: 10px;
                height: 28px;
                width: 28px;
                font-size: 14px;
            }
            .home5-features-section .book-price-tag,
            .book-price-tag {
                display: inline-block !important;
                background: #A86C3C !important;
                color: #ffffff !important;
                -webkit-text-fill-color: #ffffff !important;
                font-weight: 700 !important;
                font-size: 14px !important;
                line-height: 1.2 !important;
                padding: 6px 14px !important;
                border-radius: 999px !important;
                margin-top: 0;
                opacity: 1 !important;
            }

            /* Preloader : fond noir charte + logo or */
            .preloader.alliance-preloader {
                background-color: #141414 !important;
            }
            .preloader.alliance-preloader::after,
            .preloader.alliance-preloader::before {
                display: none !important;
                content: none !important;
                background-image: none !important;
            }
            .alliance-preloader-inner {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -52%);
                width: min(88vw, 340px);
                text-align: center;
                background: transparent;
            }
            .alliance-preloader-inner img {
                display: block;
                width: 100%;
                max-height: 110px;
                height: auto;
                object-fit: contain;
                margin: 0 auto;
                background: transparent !important;
            }
            .alliance-preloader-label {
                display: block;
                margin-top: 1.1rem;
                color: #a67c2a;
                font-weight: 700;
                font-size: 11px;
                letter-spacing: 0.14em;
                text-transform: uppercase;
            }

            /* Livres : cadre image */
            .home5-features-section .feature-block-home5 .image-box .image {
                overflow: hidden;
            }

            /* Contenus à la une (carousel) : images carrées 1:1 */
            .news-section-two .news-block .image-box .image {
                overflow: hidden;
            }
            .news-section-two .news-block .image-box .image img {
                width: 100%;
                height: 350px;
                object-fit: cover;
            }

            /* À la une : flèches du carrousel sur la zone des cartes, pas sur le bouton « Tous les contenus » */
            .news-section-two .title-column .inner-column {
                position: relative;
                z-index: 2;
            }
            .news-section-two .carousel-column .carousel-outer {
                position: relative;
            }
            .news-section-two .news-carousel .owl-nav {
                left: auto !important;
                right: 12px;
                bottom: 16px !important;
                margin: 0 !important;
                z-index: 4;
            }
            @media (max-width: 991px) {
                .news-section-two .news-carousel .owl-nav {
                    position: static !important;
                    justify-content: center;
                    margin-top: 20px !important;
                    padding-bottom: 8px;
                }
            }

            /* Rubrique Soutenir : boutons empilés, moins de hauteur / marge sous l’image */
            .alliance-support-section {
                padding: 72px 0 44px !important;
            }
            .alliance-support-section .content-column {
                margin-bottom: 28px !important;
            }
            .alliance-support-section .image-column {
                margin-bottom: 28px !important;
            }
            .alliance-support-section .row {
                align-items: stretch;
            }
            .alliance-support-section .image-column {
                display: flex;
            }
            .alliance-support-section .image-column .inner-column {
                margin-right: 0 !important;
                padding-left: 0 !important;
                flex: 1;
                display: flex;
                flex-direction: column;
                width: 100%;
                min-height: 280px;
            }
            @media (min-width: 1200px) {
                .alliance-support-section .image-column .inner-column {
                    margin-right: -140px !important;
                    padding-left: 10px !important;
                }
            }
            /* Remplit la hauteur de la colonne (comme le bloc texte à gauche), sans bande blanche sous la photo */
            .alliance-support-section .alliance-support-image-box {
                position: relative;
                flex: 1;
                min-height: 320px;
            }
            .alliance-support-section .alliance-support-image-box .image {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                margin: 0 !important;
                overflow: hidden;
            }
            .alliance-support-section .alliance-support-image-box .image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
                display: block;
                max-height: none;
            }
            .alliance-support-section .image-column .float-text {
                position: absolute;
                z-index: 2;
                top: 50%;
                left: -150px;
                transform: translateY(-50%) rotate(-90deg);
            }
            @media (max-width: 1199px) {
                .alliance-support-section .image-column .inner-column {
                    min-height: 340px;
                }
                .alliance-support-section .alliance-support-image-box {
                    min-height: 340px;
                }
                .alliance-support-section .image-column .float-text {
                    left: 8px;
                    top: auto;
                    bottom: 12px;
                    transform: none;
                    writing-mode: horizontal-tb;
                    width: auto;
                    padding: 10px 16px;
                }
            }
            .alliance-support-section .content-column .btn-box {
                display: flex;
                flex-direction: column;
                align-items: stretch;
                gap: 14px;
                max-width: 360px;
            }
            .alliance-support-section .content-column .btn-box .theme-btn {
                margin-left: 0 !important;
                width: 100%;
                text-align: center;
            }

            .contact-form-home4 label.field-label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: #333;
                margin-bottom: 6px;
            }
            .contact-form-home4 .field-hint {
                font-weight: 400;
                color: #888;
                font-size: 12px;
            }

            /* Section rendez-vous (fond sombre) : texte contact + libellés formulaire lisibles */
            .contact-section-three .contact-info-box-two .text {
                color: rgba(255, 255, 255, 0.9) !important;
            }
            .contact-section-three .contact-info-box-two .text a {
                color: #ffffff !important;
                font-weight: 600;
                text-decoration: underline;
                text-underline-offset: 3px;
            }
            .contact-section-three .contact-info-box-two .text a:hover {
                color: #f5d78c !important;
            }
            .contact-section-three .contact-form-home4 label.field-label {
                color: #ffffff !important;
            }
            .contact-section-three .contact-form-home4 .field-hint {
                color: rgba(255, 236, 200, 0.92) !important;
            }
            .contact-section-three .contact-form-home4 .text-danger {
                color: #ffc9c9 !important;
            }

            /* Panier séparé du bouton don + visible au scroll (sticky) */
            .header-cart-wrap {
                display: inline-flex;
                align-items: center;
                position: relative;
                padding-right: 16px;
                margin-right: 8px;
                border-right: 1px solid rgba(0, 0, 0, 0.08);
            }
            .header-cart-wrap .cart-btn {
                position: relative;
                font-size: 20px;
                color: #333;
                padding: 8px 10px;
                line-height: 1;
            }
            /* Badge sur le bord du cercle (pastille qui chevauche l’anneau), pas au centre */
            .header-cart-wrap .cart-count-badge {
                display: none;
                position: absolute;
                top: -4px;
                right: -2px;
                background: #A86C3C;
                color: #fff;
                font-size: 11px;
                font-weight: 700;
                min-width: 20px;
                height: 20px;
                line-height: 16px;
                text-align: center;
                border-radius: 50%;
                padding: 0 4px;
                border: 2px solid #fff;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
                z-index: 2;
                pointer-events: none;
            }
            .sticky-header .header-cart-wrap {
                border-right-color: rgba(255, 255, 255, 0.2);
            }
            .sticky-header .header-cart-wrap .cart-btn {
                color: #fff;
            }
            .sticky-header .auto-container {
                padding-left: clamp(14px, 2.8vw, 52px);
                padding-right: clamp(14px, 2.8vw, 52px);
            }
            .sticky-header .inner-container {
                display: flex;
                align-items: center;
                flex-wrap: nowrap;
                justify-content: space-between;
                width: 100%;
                gap: 0.5rem;
            }
            .sticky-header .nav-outer {
                flex: 1;
                min-width: 0;
            }
            .sticky-header .main-menu .navigation {
                display: flex;
                flex-wrap: nowrap;
                align-items: center;
            }
            .sticky-header .main-menu .navigation > li {
                flex-shrink: 0;
            }
            .sticky-header-actions {
                display: flex;
                align-items: center;
                flex-shrink: 0;
                flex-wrap: nowrap;
                gap: 8px;
                margin-left: 8px;
            }
            @media (min-width: 992px) and (max-width: 1699px) {
                .sticky-header .main-menu .navigation > li {
                    margin-left: 20px !important;
                }
            }
            @media (min-width: 992px) and (max-width: 1399px) {
                .sticky-header .main-menu .navigation > li {
                    margin-left: 14px !important;
                }
                .sticky-header .main-menu .navigation > li > a {
                    font-size: 12px;
                }
            }
            /* Header principal (haut de page) : pas de retour à la ligne du bloc menu + actions */
            @media (min-width: 1200px) {
                .main-header.header-style-one .main-box {
                    padding-left: clamp(18px, 3.5vw, 96px);
                    padding-right: clamp(18px, 3.5vw, 96px);
                }
                .main-header.header-style-one .main-menu .navigation {
                    display: flex;
                    flex-wrap: nowrap;
                }
                .main-header.header-style-one .main-menu .navigation > li {
                    flex-shrink: 0;
                }
            }
            @media (min-width: 1200px) and (max-width: 1599px) {
                .main-header.header-style-one .main-box .main-menu .navigation > li {
                    margin-right: 22px !important;
                }
            }
            /* Header principal : espace entre panier, avatar et « Faire un don » */
            .main-header .outer-box.alliance-header-outer-actions {
                gap: 6px 20px;
                flex-wrap: nowrap;
            }
            /* Loupe à côté du panier (pas près du logo) */
            .main-header .outer-box.alliance-header-outer-actions .search-btn,
            .sticky-header-actions .search-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 44px;
                height: 44px;
                margin: 0;
                padding: 0;
                border: none;
                background: transparent;
                color: #A86C3C;
                font-size: 20px;
                flex-shrink: 0;
            }
            .main-header .outer-box.alliance-header-outer-actions .search-btn:hover,
            .sticky-header-actions .search-btn:hover {
                color: #8a552e;
            }
            .main-header .outer-box.alliance-header-outer-actions .header-cart-wrap {
                margin-right: 0;
                padding-right: 20px;
            }
            .sticky-header-actions .search-btn {
                margin-right: 8px;
            }
            .main-header .outer-box.alliance-header-outer-actions .alliance-toolbar-account {
                margin-left: 0 !important;
                margin-right: 4px;
            }
            .main-header .outer-box.alliance-header-outer-actions .info-btn {
                margin-left: 8px;
            }
            .alliance-donate-modal .nav-pills .nav-link {
                color: #555;
                border: 1px solid #e8e8e8;
            }
            .alliance-donate-modal .nav-pills .nav-link.active {
                background: #A86C3C;
                border-color: #A86C3C;
                color: #fff;
            }

            /* Modale don : backdrop plus léger + formulaire lisible (Bootstrap 5.0) */
            .modal-backdrop.show {
                opacity: 0.38 !important;
            }
            .alliance-donate-modal .modal-content {
                background: #fff;
            }
            .alliance-donate-modal .modal-body {
                background: #fff;
                color: #212529;
            }
            .alliance-donate-modal .tab-content {
                color: #212529;
            }
            .alliance-donate-modal .form-label,
            .alliance-donate-modal .form-control,
            .alliance-donate-modal .form-select {
                color: #212529;
            }

            /* Panier : contraste fort (header + sticky) */
            .header-cart-wrap .cart-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: rgba(200, 146, 42, 0.18);
                border: 2px solid #A86C3C;
                color: #1a1a1a !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            }
            .main-header.fixed-header .header-cart-wrap .cart-btn {
                background: rgba(200, 146, 42, 0.25);
                color: #fff !important;
                border-color: #e5ab2e;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            }
            .sticky-header .header-cart-wrap .cart-btn {
                background: rgba(200, 146, 42, 0.35);
                border-color: #e5ab2e;
                color: #fff !important;
            }

            .alliance-toolbar-account .dropdown-menu {
                z-index: 1085;
            }
            .alliance-toolbar-avatar-btn {
                width: 42px;
                height: 42px;
                padding: 0;
                line-height: 0;
                border: 2px solid rgba(200, 146, 42, 0.5);
                overflow: hidden;
                flex-shrink: 0;
            }
            .alliance-toolbar-account-dark .alliance-toolbar-avatar-btn {
                border-color: rgba(255, 255, 255, 0.45);
            }
            .alliance-toolbar-avatar-btn .alliance-nav-avatar-img,
            .alliance-toolbar-avatar-btn .alliance-nav-avatar-fallback {
                width: 100% !important;
                height: 100% !important;
                border: none !important;
                border-radius: 50%;
            }
            .sticky-header .alliance-toolbar-dropdown-header {
                white-space: normal;
                text-align: center;
            }

            .alliance-site-toast {
                position: fixed;
                top: 1rem;
                left: 50%;
                transform: translateX(-50%) translateY(-120%);
                z-index: 1090;
                max-width: min(90vw, 420px);
                padding: 0.75rem 1.25rem;
                border-radius: 10px;
                font-size: 0.95rem;
                font-weight: 600;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
                transition: transform 0.35s ease;
                pointer-events: none;
            }
            .alliance-site-toast.show {
                transform: translateX(-50%) translateY(0);
            }
            /* Toast au-dessus de la modale agenda (z-index modale ~10060) */
            .alliance-site-toast.agenda-modal-toast {
                z-index: 10120;
                pointer-events: none;
            }
            .alliance-site-toast.success {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }
            .alliance-site-toast.error {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
            .alliance-site-toast.info {
                background: #d1ecf1;
                color: #0c5460;
                border: 1px solid #bee5eb;
            }

            /* Avatar (partiel nav + toolbar panier) */
            .alliance-nav-avatar-img {
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid rgba(200, 146, 42, 0.45);
                vertical-align: middle;
            }
            .alliance-nav-avatar-fallback {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: linear-gradient(145deg, #A86C3C, #a87622);
                color: #fff;
                font-weight: 700;
                font-size: 15px;
                border: 2px solid rgba(255, 255, 255, 0.35);
                flex-shrink: 0;
            }

            .btn-dark.alliance-submit-loading .spinner-border {
                color: #fff;
            }
            .btn.text-white.alliance-submit-loading .spinner-border {
                color: #fff;
            }

            /* Boutique : bouton panier dans .product-block (thème prévoit des <a>) */
            .product-block .icon-box button.ui-btn {
                border: none;
                padding: 0;
                font: inherit;
            }

            /* Boutique : sur mobile / tactile, les icônes (fiche + panier) restent visibles (pas seulement au survol) */
            @media (max-width: 991.98px) {
                .alliance-books-shop .product-block .icon-box {
                    opacity: 1 !important;
                    visibility: visible !important;
                    top: 14px !important;
                    right: 14px !important;
                    z-index: 8;
                    pointer-events: auto;
                }
                .alliance-books-shop .product-block .icon-box .ui-btn {
                    pointer-events: auto;
                    touch-action: manipulation;
                    -webkit-tap-highlight-color: rgba(200, 146, 42, 0.35);
                }
            }

            /* Suggestions sous la barre de recherche (popup header) */
            .search-live-results {
                margin-top: 1rem;
                max-height: min(52vh, 420px);
                overflow-y: auto;
                text-align: left;
                background: #fff;
                border-radius: 8px;
                border: 1px solid #e1e6dc;
                box-shadow: 0 14px 45px rgba(0, 0, 0, 0.18);
            }
            .search-live-results .search-live-section-title {
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                color: #888;
                padding: 0.65rem 0.85rem 0.35rem;
                margin: 0;
                border-bottom: 1px solid #f0f0f0;
                background: #fafafa;
            }
            .search-live-results a {
                display: block;
                padding: 0.55rem 0.85rem;
                color: #333;
                text-decoration: none;
                border-bottom: 1px solid #f5f5f5;
                font-size: 15px;
                line-height: 1.35;
            }
            .search-live-results a:hover,
            .search-live-results a:focus {
                background: rgba(200, 146, 42, 0.12);
                color: #1a1a1a;
            }
            .search-live-results .search-live-meta {
                display: block;
                font-size: 12px;
                color: #999;
                margin-top: 2px;
            }
            .search-live-results .search-live-empty,
            .search-live-results .search-live-hint {
                padding: 0.85rem;
                color: #666;
                font-size: 14px;
                margin: 0;
            }
            .search-live-results .search-live-loading {
                padding: 0.85rem;
                color: #888;
                font-size: 14px;
            }

            /* Faire un don + Devenir partenaire : alignés, padding réduit pour tenir sur une ligne */
            .alliance-donate-partner-row {
                display: inline-flex !important;
                flex-wrap: wrap;
                align-items: center;
                gap: 8px 10px;
            }
            .main-slider .btn-box.alliance-donate-partner-row {
                display: inline-flex !important;
            }
            .alliance-donate-partner-row .theme-btn.btn-style-one,
            .alliance-donate-partner-row .theme-btn.alliance-btn-partner {
                padding: 9px 18px !important;
                line-height: 22px !important;
                font-size: 11px !important;
                letter-spacing: 0.07em !important;
                margin-left: 0 !important;
                white-space: nowrap;
            }
            @media (max-width: 1023px) {
                .call-to-action-home4 .content-box .alliance-donate-partner-row {
                    margin-top: 1rem;
                }
            }

            /* Bouton « Devenir partenaire » : mêmes métriques que .btn-style-one (padding, typo) + style noir / or */
            .theme-btn.alliance-btn-partner {
                position: relative;
                font-size: 14px;
                line-height: 30px;
                padding: 15px 55px;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                overflow: hidden;
                background: #141414 !important;
                color: #e5ab2e !important;
                border: 2px solid #A86C3C !important;
                box-shadow: none !important;
            }
            .theme-btn.alliance-btn-partner .btn-title,
            .theme-btn.alliance-btn-partner i {
                color: #e5ab2e !important;
            }
            .theme-btn.alliance-btn-partner:hover,
            .theme-btn.alliance-btn-partner:focus {
                background: #A86C3C !important;
                color: #141414 !important;
                border-color: #e5ab2e !important;
            }
            .theme-btn.alliance-btn-partner:hover .btn-title,
            .theme-btn.alliance-btn-partner:hover i,
            .theme-btn.alliance-btn-partner:focus .btn-title,
            .theme-btn.alliance-btn-partner:focus i {
                color: #141414 !important;
            }

            /* Loader sur le bouton d’envoi (formulaires AJAX) */
            .theme-btn.is-loading {
                position: relative;
                pointer-events: none;
                cursor: wait !important;
                opacity: 0.92;
            }
            .theme-btn.is-loading .btn-title {
                visibility: hidden;
            }
            .theme-btn.is-loading::after {
                content: "";
                position: absolute;
                left: 50%;
                top: 50%;
                width: 22px;
                height: 22px;
                margin: -11px 0 0 -11px;
                border: 3px solid rgba(255, 255, 255, 0.35);
                border-top-color: #fff;
                border-radius: 50%;
                animation: alliance-spin 0.65s linear infinite;
            }
            .theme-btn.btn-style-one.is-loading::after,
            .theme-btn.hvr-dark.is-loading::after {
                border-color: rgba(200, 146, 42, 0.35);
                border-top-color: #A86C3C;
            }
            .theme-btn.alliance-btn-partner.is-loading::after {
                border-color: rgba(229, 171, 46, 0.3);
                border-top-color: #e5ab2e;
            }
            @keyframes alliance-spin {
                to { transform: rotate(360deg); }
            }

            /* Page À propos : collage 2 images (superposition type maquette) */
            .alliance-about-collage .image-column .image-box {
                padding-bottom: 160px;
                padding-right: 45px;
                min-height: 440px;
            }
            .alliance-about-collage .image-column .image-1 {
                margin-left: auto;
                display: block;
                width: 100%;
                max-width: 500px;
                position: relative;
                z-index: 1;
            }
            .alliance-about-collage .image-column .image-1 img {
                width: 100%;
                min-height: 420px;
                max-height: 540px;
                object-fit: cover;
                object-position: center 20%;
                display: block;
                box-shadow: 0 28px 60px rgba(0, 0, 0, 0.14);
            }
            .alliance-about-collage .image-column .image-2 {
                width: 52%;
                min-width: 220px;
                max-width: 310px;
                z-index: 3;
                overflow: hidden;
                border: 5px solid #fff;
                box-shadow: 0 22px 50px rgba(0, 0, 0, 0.2);
                left: 0;
                bottom: 24px;
            }
            .alliance-about-collage .image-column .image-2 img {
                width: 100%;
                min-height: 270px;
                max-height: 360px;
                object-fit: cover;
                object-position: center top;
                display: block;
            }
            .alliance-about-collage .image-column .icon-box.icon-one {
                z-index: 5;
                left: 72px;
                top: -22px;
            }
            .alliance-about-collage .image-column .icon-box.icon-two {
                z-index: 5;
                left: -18px;
                bottom: 12px;
            }
            .alliance-about-collage .image-column .image-box .icon-dots-one {
                z-index: 0;
                right: 8%;
                bottom: 28%;
                opacity: 0.9;
            }
            @media only screen and (max-width: 1199px) {
                .alliance-about-collage .image-column .image-2 {
                    padding-left: 0;
                }
            }
            @media only screen and (max-width: 1023px) {
                .alliance-about-collage .image-column .image-box {
                    padding-left: 0;
                    padding-bottom: 150px;
                }
                .alliance-about-collage .image-column .image-2 {
                    bottom: 40px;
                    top: auto !important;
                }
            }
            @media only screen and (max-width: 767px) {
                .alliance-about-collage .image-column .image-2 {
                    display: block !important;
                    width: 56%;
                    min-width: 180px;
                    max-width: 260px;
                    bottom: 16px;
                }
                .alliance-about-collage .image-column .image-1 img {
                    min-height: 320px;
                    max-height: 420px;
                }
                .alliance-about-collage .image-column .icon-box {
                    display: flex !important;
                }
            }

            /* À propos : liste + bouton à gauche, encadré « années d’expérience » à droite (sans barre de progression) */
            .alliance-about-collage .content-column .inner-column {
                position: relative;
            }
            .alliance-about-collage .alliance-about-cta-row {
                margin-top: 8px;
            }
            .alliance-about-collage .alliance-about-cta-row .list-style-one {
                margin-bottom: 22px;
            }
            .alliance-about-collage .alliance-about-exp-static {
                position: relative !important;
                right: auto !important;
                bottom: auto !important;
                left: auto !important;
                top: auto !important;
                min-width: unset;
                width: 100%;
                max-width: 300px;
                margin-left: auto;
                margin-right: auto;
                padding: 32px 28px;
                box-shadow: 0 24px 55px rgba(0, 0, 0, 0.08);
            }
            .alliance-about-collage .alliance-about-exp-static:before {
                border-color: var(--border-theme-color2, #A86C3C);
            }
            .alliance-about-collage .alliance-about-exp-static .count {
                padding-left: 88px;
            }
            .alliance-about-collage .alliance-about-exp-static .count .icon {
                color: var(--theme-color2, #A86C3C);
            }
            @media only screen and (max-width: 991px) {
                .alliance-about-collage .alliance-about-exp-static {
                    margin-top: 28px;
                    max-width: 100%;
                }
            }

            /* À propos — bloc vidéo : visuel vernissage centré, pas étiré (contain) */
            .alliance-about-video-section .video-box > .bg.alliance-about-video-bg-outer {
                background-color: #e6e6e6 !important;
            }
            .alliance-about-video-section .video-box .bg.alliance-about-video-bg-inner {
                background-size: contain !important;
                background-repeat: no-repeat !important;
                background-position: center center !important;
            }

            /* Bandeau pages (banner.blade) : pas d’étirement, image centrée, ratio conservé */
            .page-title.alliance-site-banner {
                background-size: contain !important;
                background-repeat: no-repeat !important;
                background-position: center center !important;
                background-color: #1f1f1f !important;
            }
            .page-title.alliance-site-banner:before {
                opacity: 0.42 !important;
            }
            .page-title.alliance-site-banner .title,
            .page-title.alliance-site-banner .page-breadcrumb,
            .page-title.alliance-site-banner .page-breadcrumb a {
                text-shadow: 0 1px 10px rgba(0, 0, 0, 0.5);
            }
            /* À propos : bandes latérales / haut-bas en doré */
            .page-title.alliance-site-banner.alliance-banner-about-bg {
                background-color: #d4a012 !important;
            }
            .page-title.alliance-site-banner.alliance-banner-about-bg:before {
                opacity: 0.28 !important;
            }

        </style>

        @stack('styles')
    </head>
    <body>
        <div class="page-wrapper">
            <div class="preloader alliance-preloader" role="status" aria-live="polite" aria-busy="true" aria-label="Chargement">
                <div class="alliance-preloader-inner">
                    <img src="{{ asset('assets/logo/logo-alliance-dark.png') }}" alt="Alliance" width="320" height="120" decoding="async" fetchpriority="high">
                    <span class="alliance-preloader-label">Chargement…</span>
                </div>
            </div>

            @include('layouts.navigation')

            @if(session('newsletter_pending'))
                <div class="auto-container px-3 pt-3">
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        {{ session('newsletter_pending') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                </div>
            @endif
            @if(session('newsletter_error'))
                <div class="auto-container px-3 pt-3">
                    <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                        {{ session('newsletter_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                </div>
            @endif

            @if(request()->routeIs('home'))
                @include('layouts.slide')
            @else
                @include('layouts.banner')
            @endif

            @yield('content')

            @include('partials.section-appointment-before-footer')

            @include('layouts.footer')
        </div>

        {{-- Modales hors de .page-wrapper : le thème met page-wrapper en z-index:99 alors que le backdrop Bootstrap est sur body (z-index ~1050), ce qui plaçait l’overlay AU-DESSUS de la modale et bloquait les clics. --}}
        @include('layouts.cart-offcanvas')
        @include('layouts.donate-modal')
        @include('partials.products-welcome-modal')
        @include('partials.pastor-welcome-modal')

        @stack('modals')

        @if(session('newsletter_success'))
        <div class="modal fade alliance-newsletter-ok-modal" id="allianceNewsletterOkModal" tabindex="-1" aria-labelledby="allianceNewsletterOkModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 16px;">
                    <div class="modal-body text-center px-4 py-5">
                        <div class="alliance-newsletter-ok-icon text-success mb-3" aria-hidden="true">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <h4 class="modal-title fw-bold mb-2" id="allianceNewsletterOkModalLabel">Inscription confirmée</h4>
                        <p class="text-muted mb-4 px-sm-2">{{ session('newsletter_success') }}</p>
                        <button type="button" class="btn btn-lg text-white px-5 fw-semibold" style="background: #A86C3C; border: none;" data-bs-dismiss="modal">Parfait</button>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .alliance-newsletter-ok-modal .alliance-newsletter-ok-icon {
                font-size: 4.25rem;
                line-height: 1;
            }
            .alliance-newsletter-ok-modal .modal-content {
                background: #fff;
            }
        </style>
        @endif

        @php
            $shipCfg = \App\Models\ShippingSetting::instance();
            $allianceShippingConfigPayload = [
                'enabled' => (bool) $shipCfg->is_active,
                'domesticCode' => strtoupper((string) ($shipCfg->domestic_country_code ?: 'CD')),
                'domestic' => (float) $shipCfg->price_domestic,
                'international' => (float) $shipCfg->price_international,
                'currency' => (string) ($shipCfg->currency ?: 'USD'),
            ];
            $shopCfg = $shopSetting ?? \App\Models\ShopSetting::instance();
            $allianceShopCurrencyPayload = [
                'rate' => (float) ($shopCfg->usd_to_cdf_rate ?? 2850),
                'default' => (string) ($shopCfg->default_currency ?? 'USD'),
                'allowSwitch' => (bool) ($shopCfg->allow_currency_switch ?? true),
            ];
        @endphp
        <script>
            window.allianceFlexPayEnabled = @json((bool) config('services.flexpay.enabled'));
            window.allianceAuthUser = @json(auth()->check() ? ['id' => auth()->id(), 'name' => auth()->user()->name, 'email' => auth()->user()->email] : null);
            window.allianceShippingConfig = @json($allianceShippingConfigPayload);
            window.allianceShopCurrency = @json($allianceShopCurrencyPayload);
            window.allianceRoutes = {
                loginSend: @json(route('login.send-code')),
                loginVerify: @json(route('login.verify')),
                registerSend: @json(route('register.send-code')),
                registerVerify: @json(route('register.verify')),
                orderInit: @json(route('shop.order.init')),
                paymentProcess: @json(route('payment.process')),
                paymentCheck: @json(route('payment.check')),
            };
        </script>

        <div id="alliance-site-toast" class="alliance-site-toast" role="status" aria-live="polite"></div>

        @include('layouts.scripts')
        @include('layouts.checkout-modal')
        @include('partials.alliance-otp-auth-modal')
        @include('partials.alliance-content-likes-wiring')
        @if(session('newsletter_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById('allianceNewsletterOkModal');
                if (!el || typeof bootstrap === 'undefined' || !bootstrap.Modal) {
                    return;
                }
                var modal = new bootstrap.Modal(el);
                modal.show();
            });
        </script>
        @endif
        @stack('scripts')
    </body>
</html>
