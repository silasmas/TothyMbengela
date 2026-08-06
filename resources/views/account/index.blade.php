@extends('layouts.app')

@section('page_banner_title', 'Mon compte')

@section('content')
<section class="about-section" style="padding-top: 50px; padding-bottom: 80px;">
    <div class="auto-container">
        <div class="sec-title mb-4">
            <span class="sub-title">Espace personnel</span>
            <h2>Bonjour, {{ \Illuminate\Support\Str::limit(Auth::user()->name, 40) }}</h2>
            <p class="text-muted mb-0">Retrouvez vos achats, dons et engagements depuis ce tableau de bord.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('account.activity') }}" class="text-decoration-none d-block h-100 p-4 rounded shadow-sm" style="background:#fafafa;border:1px solid #eee;">
                    <i class="fa fa-list-alt fa-2x mb-3" style="color:#A86C3C;"></i>
                    <h4 class="text-dark mb-2">Historique des transactions</h4>
                    <p class="text-muted small mb-0">Vue chronologique de vos commandes, dons et partenariats.</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('account.purchases') }}" class="text-decoration-none d-block h-100 p-4 rounded shadow-sm" style="background:#fafafa;border:1px solid #eee;">
                    <i class="fa fa-shopping-bag fa-2x mb-3" style="color:#A86C3C;"></i>
                    <h4 class="text-dark mb-2">Mes achats</h4>
                    <p class="text-muted small mb-0">{{ $ordersCount }} commande(s) enregistrée(s).</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('account.donations') }}" class="text-decoration-none d-block h-100 p-4 rounded shadow-sm" style="background:#fafafa;border:1px solid #eee;">
                    <i class="fa fa-heart fa-2x mb-3" style="color:#A86C3C;"></i>
                    <h4 class="text-dark mb-2">Mes dons</h4>
                    <p class="text-muted small mb-0">{{ $donationsCount }} don(s) lié(s) à votre e-mail.</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('account.partnerships') }}" class="text-decoration-none d-block h-100 p-4 rounded shadow-sm" style="background:#fafafa;border:1px solid #eee;">
                    <i class="fa fa-handshake fa-2x mb-3" style="color:#A86C3C;"></i>
                    <h4 class="text-dark mb-2">Partenariats</h4>
                    <p class="text-muted small mb-0">{{ $partnersCount }} engagement(s).</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('profile.edit') }}" class="text-decoration-none d-block h-100 p-4 rounded shadow-sm" style="background:#fafafa;border:1px solid #eee;">
                    <i class="fa fa-user-cog fa-2x mb-3" style="color:#A86C3C;"></i>
                    <h4 class="text-dark mb-2">Profil &amp; paramètres</h4>
                    <p class="text-muted small mb-0">Modifier vos informations personnelles.</p>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
