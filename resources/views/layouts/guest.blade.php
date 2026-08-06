<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Alliance') }} — Connexion</title>

        <link rel="shortcut icon" href="{{ asset('assets/logo/logo-alliance-mark.png') }}" type="image/png">
        <link rel="icon" href="{{ asset('assets/logo/logo-alliance-mark.png') }}" type="image/png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/fontawesome.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/alliance-brand.css') }}?v=1" rel="stylesheet">

        <style>
            body.alliance-auth-body {
                min-height: 100vh;
                margin: 0;
                background: linear-gradient(165deg, #FBF7F1 0%, #F0E4D8 40%, #F7F1E8 100%);
            }
            .alliance-auth-shell {
                min-height: 100vh;
            }
            .alliance-auth-logo img {
                max-height: 88px;
                width: auto;
                display: block;
                margin: 0 auto;
                background: transparent !important;
            }
            .alliance-auth-card {
                border-radius: 14px !important;
                box-shadow: 0 18px 50px rgba(30, 20, 10, 0.08) !important;
                border: 1px solid rgba(168, 108, 60, 0.22) !important;
            }
            .alliance-auth-card .block {
                width: 100%;
            }
            .alliance-auth-card label,
            .alliance-auth-card .text-gray-600,
            .alliance-auth-card .text-sm {
                color: #4a4338 !important;
            }
            .alliance-auth-card input[type="email"],
            .alliance-auth-card input[type="text"],
            .alliance-auth-card input[type="password"] {
                width: 100% !important;
                border-radius: 8px !important;
                border: 1px solid #e0dcd4 !important;
                padding: 0.65rem 0.9rem !important;
                min-height: 48px;
                background: #fdfcfa !important;
            }
            .alliance-auth-card input:focus {
                border-color: #A86C3C !important;
                box-shadow: 0 0 0 3px rgba(200, 146, 42, 0.2) !important;
                outline: none !important;
            }
            .alliance-auth-card button.inline-flex,
            .alliance-auth-card .inline-flex.items-center.px-4 {
                background: linear-gradient(180deg, #d4a84a 0%, #A86C3C 100%) !important;
                color: #fff !important;
                border: none !important;
                border-radius: 8px !important;
                padding: 0.65rem 1.25rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                font-size: 0.75rem !important;
            }
            .alliance-auth-card button.inline-flex:hover,
            .alliance-auth-card .inline-flex.items-center.px-4:hover {
                filter: brightness(1.05);
            }
            .alliance-auth-card button.inline-flex:disabled {
                opacity: 0.65;
            }
            .alliance-auth-card a.text-gray-600,
            .alliance-auth-card a.underline {
                color: #8a7a62 !important;
            }
            .alliance-auth-foot a {
                color: #a67c2a;
                font-weight: 600;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="alliance-auth-body">
        <div class="alliance-auth-shell d-flex flex-column align-items-center justify-content-center py-4 py-md-5 px-3">
            <a href="{{ route('home') }}" class="alliance-auth-logo text-center text-decoration-none mb-3 mb-md-4">
                <img src="{{ asset('assets/logo/logo-alliance.png') }}" alt="Alliance — Ministère Tothy Mbengela" width="280" height="100" decoding="async">
            </a>

            <div class="alliance-auth-card bg-white p-4 p-md-5 w-100" style="max-width: 440px;">
                {{ $slot }}
            </div>

            <p class="alliance-auth-foot mt-4 mb-0 text-center small text-muted">
                <a href="{{ route('home') }}">← Retour à l’accueil</a>
            </p>
        </div>
    </body>
</html>
