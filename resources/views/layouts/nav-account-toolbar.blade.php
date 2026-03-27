{{-- Avatar + menu Bootstrap : à placer à côté du panier ($accountToolbarOnDark = true sur sticky) --}}
@php
    $accountToolbarOnDark = $accountToolbarOnDark ?? false;
@endphp
@auth
    <div class="dropdown alliance-toolbar-account{{ $accountToolbarOnDark ? ' alliance-toolbar-account-dark' : '' }}">
        <button type="button" class="btn btn-sm rounded-circle alliance-toolbar-avatar-btn{{ $accountToolbarOnDark ? ' text-white' : '' }}" data-bs-toggle="dropdown" aria-expanded="false" title="Mon compte" aria-label="Mon compte">
            @include('layouts.partials.nav-user-avatar', ['navAvatarSize' => 38])
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width: 260px;">
            <li>
                <h6 class="dropdown-header alliance-toolbar-dropdown-header mb-0 text-wrap">
                    <span class="d-block fw-bold text-dark">{{ Auth::user()->name }}</span>
                    <small class="text-muted fw-normal">{{ Auth::user()->email }}</small>
                </h6>
            </li>
            <li><a class="dropdown-item" href="{{ route('account.index') }}"><i class="fa fa-home me-2 text-muted"></i> Mon compte</a></li>
            <li><a class="dropdown-item" href="{{ route('account.activity') }}"><i class="fa fa-list-alt me-2 text-muted"></i> Historique des transactions</a></li>
            <li><a class="dropdown-item" href="{{ route('account.purchases') }}"><i class="fa fa-shopping-bag me-2 text-muted"></i> Mes achats</a></li>
            <li><a class="dropdown-item" href="{{ route('account.donations') }}"><i class="fa fa-heart me-2 text-muted"></i> Mes dons</a></li>
            <li><a class="dropdown-item" href="{{ route('account.partnerships') }}"><i class="fa fa-handshake me-2 text-muted"></i> Partenariats</a></li>
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa fa-cog me-2 text-muted"></i> Paramètres du profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="px-3 pb-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm w-100">Déconnexion</button>
                </form>
            </li>
        </ul>
    </div>
@endauth
