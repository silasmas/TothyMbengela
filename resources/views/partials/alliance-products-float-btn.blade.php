{{-- Bouton flottant dédié : rouvrir la modale produits --}}
@php
    $showProductsFloat = !empty($productsWelcomeModalEnabled)
        && isset($featuredProducts)
        && $featuredProducts->isNotEmpty();
@endphp
@if($showProductsFloat)
<button
    type="button"
    class="alliance-products-float-btn"
    id="allianceProductsFloatBtn"
    data-bs-toggle="modal"
    data-bs-target="#allianceProductsWelcomeModal"
    title="Voir les produits de la Pasteure"
    aria-label="Ouvrir la modale des produits"
>
    <i class="fa fa-book-open" aria-hidden="true"></i>
    <span class="alliance-products-float-btn__label">Produits</span>
</button>
@endif
