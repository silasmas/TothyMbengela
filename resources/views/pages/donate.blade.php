@extends('layouts.app')

@section('page_banner_title', 'Faire un don')

@section('page_banner_breadcrumbs')
    <li>Don</li>
@endsection

@section('content')

<div class="alliance-engagement-page-wrap">
    <section class="alliance-engagement-intro">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="sub-title">Votre générosité compte</span>
                <h2>Soutenez le ministère Alliance</h2>
                <div class="text mx-auto" style="max-width:640px;">Chaque don, petit ou grand, nous aide à poursuivre la mission : partager la Parole et accompagner des vies. Merci de votre confiance.</div>
            </div>
        </div>
    </section>

    <section class="contact-section alliance-engagement-contact">
        <div class="bg bg-pattern-6"></div>
        @include('partials.engagement-bg-image', ['filename' => 'mm.jpg.jpeg', 'alt' => 'Portrait — soutenir le ministère par un don'])
        <div class="auto-container">
            <div class="row">
                <div class="title-column col-lg-6 col-md-12">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">Agir avec nous</span>
                            <h2>Votre don fait la différence</h2>
                            <div class="text">Choisissez un don unique ou mensuel : en ligne (fenêtre sécurisée) ou via le formulaire ci-contre — chaque geste compte pour la mission.</div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-bolt"></i>
                                <h6 class="title">Don rapide</h6>
                                <div class="text">Paiement sécurisé par carte ou Mobile Money lorsque le service est activé sur le site.</div>
                            </div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-file-alt"></i>
                                <h6 class="title">Formulaire classique</h6>
                                <div class="text">Enregistrez votre intention de don sans paiement en ligne — nous vous recontacterons si besoin.</div>
                            </div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-envelope"></i>
                                <h6 class="title">Une question ?</h6>
                                <div class="text"><a href="{{ route('contact.create') }}">Contactez-nous</a></div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="button" class="theme-btn btn-style-one" data-bs-toggle="modal" data-bs-target="#donatePartnerModal">
                                <span class="btn-title"><i class="fa fa-bolt"></i> Don rapide (fenêtre sécurisée)</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        @if(session('success'))
                            <div class="alert alert-success mb-4" style="border-radius:8px;">
                                <i class="fa fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        <div class="contact-form wow fadeInLeft">
                            <h2 class="title">Confirmer mon don</h2>
                            <p class="text-center small text-muted mb-3">— Formulaire sans passage par la fenêtre de paiement —</p>

                            <form method="POST" action="{{ route('donate.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <label>Votre nom *</label>
                                        <input type="text" name="donor_name" value="{{ old('donor_name') }}" placeholder="Nom complet" required>
                                        @error('donor_name') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <label>E-mail *</label>
                                        <input type="email" name="donor_email" value="{{ old('donor_email') }}" placeholder="Adresse e-mail" required>
                                        @error('donor_email') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>Téléphone</label>
                                        <input type="text" name="donor_phone" value="{{ old('donor_phone') }}" placeholder="Numéro (optionnel)">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <label>Montant *</label>
                                        <input type="number" name="amount" value="{{ old('amount') }}" min="1" step="0.01" placeholder="Ex. 50" required>
                                        @error('amount') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <label>Devise *</label>
                                        <select name="currency" required>
                                            <option value="CDF" {{ old('currency', 'CDF') === 'CDF' ? 'selected' : '' }}>Franc congolais (CDF)</option>
                                        </select>
                                        @error('currency') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>Fréquence *</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="d-flex align-items-center justify-content-center gap-2 py-3 px-2 rounded w-100 h-100" style="border:2px solid {{ old('frequency', 'once') === 'once' ? '#C8922A' : '#ddd' }};cursor:pointer;{{ old('frequency', 'once') === 'once' ? 'background:#fdf8eb;' : '' }}">
                                                    <input type="radio" name="frequency" value="once" {{ old('frequency', 'once') === 'once' ? 'checked' : '' }}>
                                                    <strong class="small">Don unique</strong>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="d-flex align-items-center justify-content-center gap-2 py-3 px-2 rounded w-100 h-100" style="border:2px solid {{ old('frequency') === 'monthly' ? '#C8922A' : '#ddd' }};cursor:pointer;{{ old('frequency') === 'monthly' ? 'background:#fdf8eb;' : '' }}">
                                                    <input type="radio" name="frequency" value="monthly" {{ old('frequency') === 'monthly' ? 'checked' : '' }}>
                                                    <strong class="small">Don mensuel</strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label>Message (optionnel)</label>
                                        <textarea name="message" rows="3" placeholder="Un mot d’encouragement…">{{ old('message') }}</textarea>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <label class="d-flex align-items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                                            Don anonyme
                                        </label>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <button class="theme-btn btn-style-one hvr-dark" type="submit">
                                            <span class="btn-title"><i class="fa fa-heart"></i> Confirmer mon don</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
