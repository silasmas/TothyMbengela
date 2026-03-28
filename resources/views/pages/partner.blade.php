@extends('layouts.app')

@section('page_banner_title', 'Devenir partenaire')

@section('page_banner_breadcrumbs')
    <li>Partenariat</li>
@endsection

@section('content')

<div class="alliance-engagement-page-wrap">
    <section class="alliance-engagement-intro">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="sub-title">Engagement</span>
                <h2>Devenez partenaire du ministère</h2>
                <div class="text mx-auto" style="max-width:640px;">Engagez-vous à soutenir régulièrement Alliance et participez activement à sa mission d’enseignement et d’accompagnement.</div>
            </div>
        </div>
    </section>

    <section class="contact-section alliance-engagement-contact">
        <div class="bg bg-pattern-6"></div>
        @include('partials.engagement-bg-image', ['filename' => 'mm.jpg.jpeg', 'alt' => 'Portrait — devenir partenaire du ministère'])
        <div class="auto-container">
            <div class="row">
                <div class="title-column col-lg-6 col-md-12">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">Pourquoi nous rejoindre</span>
                            <h2>Ensemble, allons plus loin</h2>
                            <div class="text">Les partenaires jouent un rôle clé dans la diffusion des enseignements et la vie du ministère Alliance.</div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-star"></i>
                                <h6 class="title">Proximité</h6>
                                <div class="text">Accès privilégié aux événements et temps forts du ministère.</div>
                            </div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-newspaper"></i>
                                <h6 class="title">Informations</h6>
                                <div class="text">Actualités et contenus réservés aux partenaires.</div>
                            </div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-hands-helping"></i>
                                <h6 class="title">Impact</h6>
                                <div class="text">Votre engagement mensuel soutient concrètement la mission sur le terrain.</div>
                            </div>
                        </div>

                        @auth
                        <div class="text-center mt-4">
                            <button type="button" class="theme-btn btn-style-one js-donate-modal-partner">
                                <span class="btn-title"><i class="fa fa-bolt"></i> Souscrire (fenêtre sécurisée)</span>
                            </button>
                            <p class="small text-muted mt-2 mb-0">Ouvre l’onglet « Devenir partenaire » dans la fenêtre de soutien.</p>
                        </div>
                        @endauth
                    </div>
                </div>

                <div class="form-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        @if(session('success'))
                            <div class="alert alert-success mb-4" style="border-radius:8px;">
                                <i class="fa fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        @auth
                        <div class="contact-form wow fadeInLeft">
                            <h2 class="title">Votre engagement</h2>
                            <p class="text-center small text-muted mb-3">— Formulaire sans passage par la fenêtre de paiement —</p>

                            <form method="POST" action="{{ route('partner.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <label>Montant mensuel *</label>
                                        <input type="number" name="monthly_amount" value="{{ old('monthly_amount') }}" min="1" step="0.01" placeholder="Ex. 25" required>
                                        @error('monthly_amount') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <label>Devise *</label>
                                        <select name="currency" required>
                                            <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                                            <option value="EUR" {{ old('currency', 'USD') === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                            <option value="CDF" {{ old('currency', 'USD') === 'CDF' ? 'selected' : '' }}>CDF (FC)</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>Message (optionnel)</label>
                                        <textarea name="message" rows="3" placeholder="Un mot pour le ministère…">{{ old('message') }}</textarea>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <button class="theme-btn btn-style-one hvr-dark" type="submit">
                                            <span class="btn-title"><i class="fa fa-handshake"></i> Devenir partenaire</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else
                        <div class="contact-form wow fadeInLeft">
                            <h2 class="title">Espace partenaires</h2>
                            <p class="text-center text-muted">Vous devez être connecté pour enregistrer un engagement partenaire avec votre compte.</p>
                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="theme-btn btn-style-one me-2 mb-2"><span class="btn-title">Se connecter</span></a>
                                <a href="{{ route('register') }}" class="theme-btn btn-style-two mb-2"><span class="btn-title">Créer un compte</span></a>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
