@extends('layouts.app')

@section('page_banner_title', 'Mon profil')

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('account.index') }}">Mon compte</a></li>
    <li>Profil</li>
@endsection

@section('content')

<div class="alliance-engagement-page-wrap alliance-profile-page">
    <section class="alliance-engagement-intro">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="sub-title">Paramètres du compte</span>
                <h2>Bonjour, {{ \Illuminate\Support\Str::limit($user->name, 40) }}</h2>
                <div class="text mx-auto" style="max-width:640px;">Mettez à jour vos informations, votre mot de passe ou accédez rapidement à vos activités sur le site.</div>
            </div>
        </div>
    </section>

    <section class="contact-section alliance-engagement-contact">
        <div class="bg bg-pattern-6"></div>
        @include('partials.engagement-bg-image', ['filename' => 'alliance-engagement-profile.png', 'alt' => 'Portrait — espace personnel Alliance'])
        <div class="auto-container">
            <div class="row">
                <div class="title-column col-lg-6 col-md-12">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">Espace personnel</span>
                            <h2>Votre compte Alliance</h2>
                            <div class="text"><strong>{{ $user->email }}</strong></div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-user-circle"></i>
                                <h6 class="title">Tableau de bord</h6>
                                <div class="text"><a href="{{ route('account.index') }}">Vue d’ensemble du compte</a></div>
                            </div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-shopping-bag"></i>
                                <h6 class="title">Achats</h6>
                                <div class="text"><a href="{{ route('account.purchases') }}">Mes commandes livres</a></div>
                            </div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-heart"></i>
                                <h6 class="title">Dons & partenariat</h6>
                                <div class="text">
                                    <a href="{{ route('account.donations') }}">Mes dons</a>
                                    · <a href="{{ route('account.partnerships') }}">Partenariats</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-info-block">
                            <div class="inner">
                                <i class="icon fa fa-envelope"></i>
                                <h6 class="title">Besoin d’aide ?</h6>
                                <div class="text"><a href="{{ route('contact.create') }}">Nous contacter</a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success mb-4" style="border-radius:8px;">
                                <i class="fa fa-check-circle"></i> Profil enregistré.
                            </div>
                        @endif
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success mb-4" style="border-radius:8px;">
                                <i class="fa fa-check-circle"></i> Mot de passe mis à jour.
                            </div>
                        @endif

                        <div class="contact-form wow fadeInLeft mb-4">
                            <h2 class="title">Informations du profil</h2>
                            <p class="text-center small text-muted mb-3">Nom et adresse e-mail utilisés pour la connexion et les commandes.</p>

                            <form method="post" action="{{ route('profile.update') }}">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Nom complet <span class="text-muted">(obligatoire)</span></label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                                        @error('name') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Adresse e-mail <span class="text-muted">(obligatoire)</span></label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                        @error('email') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <button class="theme-btn btn-style-one hvr-dark" type="submit">
                                            <span class="btn-title">Enregistrer le profil</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="contact-form wow fadeInLeft mb-4">
                            <h2 class="title">Mot de passe</h2>
                            <p class="text-center small text-muted mb-3">Choisissez un mot de passe long et unique.</p>

                            <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Mot de passe actuel</label>
                                        <input type="password" name="current_password" autocomplete="current-password">
                                        @error('current_password', 'updatePassword')
                                            <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Nouveau mot de passe</label>
                                        <input type="password" name="password" autocomplete="new-password">
                                        @error('password', 'updatePassword')
                                            <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Confirmer le mot de passe</label>
                                        <input type="password" name="password_confirmation" autocomplete="new-password">
                                        @error('password_confirmation', 'updatePassword')
                                            <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <button class="theme-btn btn-style-one hvr-dark" type="submit">
                                            <span class="btn-title">Mettre à jour le mot de passe</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="contact-form wow fadeInLeft border border-danger border-opacity-25" style="box-shadow:0 10px 40px rgba(220,53,69,.08);">
                            <h2 class="title text-danger">Zone sensible</h2>
                            <p class="small text-muted text-center mb-3">La suppression du compte est définitive (commandes liées peuvent rester tracées côté administration).</p>
                            <div class="text-center">
                                <button type="button" class="theme-btn btn-style-two" style="border-color:#dc3545;color:#dc3545;" data-bs-toggle="modal" data-bs-target="#profileDeleteModal">
                                    <span class="btn-title">Supprimer mon compte</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modale suppression compte (Bootstrap, sans Alpine) --}}
<div class="modal fade" id="profileDeleteModal" tabindex="-1" aria-labelledby="profileDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="profileDeleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <p class="text-muted small">Cette action est irréversible. Saisissez votre mot de passe pour confirmer.</p>
                    <label class="form-label small fw-bold">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="Votre mot de passe actuel" required autocomplete="current-password">
                    @error('password', 'userDeletion')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if ($errors->userDeletion->isNotEmpty())
    var el = document.getElementById('profileDeleteModal');
    if (el && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(el).show();
    }
    @endif
});
</script>
@endpush
