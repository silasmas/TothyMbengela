@if(!empty($productsWelcomeModalEnabled) && isset($featuredProducts) && $featuredProducts->isNotEmpty())
{{-- Modale d’accueil : présentation des produits de la Pasteure --}}
<div
    class="modal fade alliance-products-welcome-modal"
    id="allianceProductsWelcomeModal"
    tabindex="-1"
    aria-labelledby="allianceProductsWelcomeModalLabel"
    aria-hidden="true"
    data-alliance-products-modal="1"
>
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <div class="modal-header alliance-products-welcome-header border-0 py-3 px-4">
                <div>
                    <p class="text-uppercase small mb-1 alliance-products-welcome-eyebrow">Boutique Alliance</p>
                    <h2 class="modal-title h4 mb-0" id="allianceProductsWelcomeModalLabel">Les produits de la Pasteure</h2>
                    <p class="text-muted small mb-0 mt-1">Livres, Flash USB + bracelet et packs à découvrir</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body px-4 pb-2">
                <div class="row g-3">
                    @foreach($featuredProducts as $product)
                        @php
                            $cartItem = $product->toCartItem();
                            $canBuy = $product->isPurchasable();
                        @endphp
                        <div class="col-md-6">
                            <article class="alliance-products-welcome-card h-100">
                                <a href="{{ route('books.show', $product->slug) }}" class="alliance-products-welcome-cover">
                                    <img src="{{ $product->cover_url }}" alt="{{ $product->title }}" loading="lazy">
                                </a>
                                <div class="alliance-products-welcome-body">
                                    <span class="alliance-products-welcome-type">{{ $product->product_type_label }}</span>
                                    <h3 class="alliance-products-welcome-title">
                                        <a href="{{ route('books.show', $product->slug) }}">{{ $product->title }}</a>
                                    </h3>
                                    <p class="alliance-products-welcome-price mb-2">
                                        {{ number_format((float) $product->price, 0, ',', ' ') }} {{ $product->currency ?? 'USD' }}
                                    </p>
                                    @if($product->description)
                                        <p class="alliance-products-welcome-text">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 100) }}</p>
                                    @endif
                                    <div class="alliance-products-welcome-actions">
                                        @if($canBuy)
                                            <button
                                                type="button"
                                                class="theme-btn btn-style-one btn-sm js-add-to-cart"
                                                data-item='@json($cartItem)'
                                            ><span class="btn-title"><i class="fa fa-cart-plus"></i> Panier</span></button>
                                            <button
                                                type="button"
                                                class="theme-btn btn-style-two btn-sm js-buy-now"
                                                data-item='@json($cartItem)'
                                                data-bs-dismiss="modal"
                                            ><span class="btn-title">Acheter</span></button>
                                        @else
                                            <a href="{{ route('books.show', $product->slug) }}" class="theme-btn btn-style-two btn-sm"><span class="btn-title">Voir</span></a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer alliance-products-welcome-footer flex-column align-items-stretch gap-3 border-0 px-4 pb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="allianceProductsWelcomeNever">
                    <label class="form-check-label" for="allianceProductsWelcomeNever">
                        Ne plus afficher automatiquement cette fenêtre (vous pourrez toujours la rouvrir via le bouton flottant)
                    </label>
                </div>
                <div class="d-flex flex-wrap gap-2 justify-content-between">
                    <a href="{{ route('books.index') }}" class="theme-btn btn-style-two" data-bs-dismiss="modal"><span class="btn-title">Toute la boutique</span></a>
                    <button type="button" class="theme-btn btn-style-one" data-bs-dismiss="modal"><span class="btn-title">Continuer la visite</span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.alliance-products-welcome-header {
    background: linear-gradient(135deg, #141414 0%, #3d2a1c 50%, #A86C3C 160%);
    color: #fff;
}
.alliance-products-welcome-header .btn-close { filter: invert(1); opacity: .85; }
.alliance-products-welcome-eyebrow {
    letter-spacing: .14em;
    color: rgba(255,255,255,.75);
    font-weight: 600;
}
.alliance-products-welcome-header .modal-title { color: #fff; }
.alliance-products-welcome-header .text-muted { color: rgba(255,255,255,.7) !important; }
.alliance-products-welcome-card {
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 12px;
    overflow: hidden;
    background: #faf8f5;
    display: flex;
    flex-direction: column;
}
.alliance-products-welcome-cover {
    display: block;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: #2a2118;
}
.alliance-products-welcome-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
}
.alliance-products-welcome-card:hover .alliance-products-welcome-cover img {
    transform: scale(1.04);
}
.alliance-products-welcome-body { padding: 14px 16px 16px; flex: 1; display: flex; flex-direction: column; }
.alliance-products-welcome-type {
    display: inline-block;
    font-size: 11px;
    letter-spacing: .08em;
    text-transform: uppercase;
    font-weight: 700;
    color: #A86C3C;
    margin-bottom: 6px;
}
.alliance-products-welcome-title {
    font-size: 1.05rem;
    margin: 0 0 6px;
    line-height: 1.3;
}
.alliance-products-welcome-title a { color: inherit; text-decoration: none; }
.alliance-products-welcome-price { font-weight: 700; color: #1a1410; }
.alliance-products-welcome-text {
    font-size: .9rem;
    color: #6b635a;
    margin-bottom: 12px;
    flex: 1;
}
.alliance-products-welcome-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.alliance-products-welcome-actions .theme-btn { margin: 0; }
.alliance-slide-product-type {
    text-transform: uppercase;
    letter-spacing: .08em;
    font-weight: 700;
}
.alliance-slide-product-actions .theme-btn {
    margin: 0;
}
</style>

@push('scripts')
<script>
(function () {
    var STORAGE_NEVER = 'alliance_products_welcome_never';
    var STORAGE_SESSION = 'alliance_products_welcome_shown_session';
    var STORAGE_DISMISSED = 'alliance_products_welcome_dismissed';

    /**
     * Mémorise la fermeture de la modale (session).
     *
     * @returns {void}
     */
    function markProductsModalDismissed() {
        try {
            sessionStorage.setItem(STORAGE_DISMISSED, '1');
        } catch (e) {}
    }

    /**
     * Ouvre la modale produits (auto, une fois par session sauf « ne plus afficher »).
     *
     * @param {HTMLElement} el Élément modale Bootstrap
     * @returns {void}
     */
    function maybeAutoOpenProductsWelcomeModal(el) {
        var delayMs = 700;
        setTimeout(function () {
            try {
                if (localStorage.getItem(STORAGE_NEVER) === '1') {
                    return;
                }
                if (sessionStorage.getItem(STORAGE_SESSION) === '1') {
                    return;
                }
            } catch (e2) {
                return;
            }
            try {
                sessionStorage.setItem(STORAGE_SESSION, '1');
            } catch (e3) {}
            bootstrap.Modal.getOrCreateInstance(el, { keyboard: true }).show();
        }, delayMs);
    }

    /**
     * Initialise la modale produits (auto-ouverture ; réouverture via bouton flottant).
     *
     * @returns {void}
     */
    function initProductsWelcomeModal() {
        var el = document.getElementById('allianceProductsWelcomeModal');
        if (!el || typeof bootstrap === 'undefined' || !bootstrap.Modal) {
            return;
        }

        el.addEventListener('hidden.bs.modal', function () {
            var cb = document.getElementById('allianceProductsWelcomeNever');
            try {
                if (cb && cb.checked) {
                    localStorage.setItem(STORAGE_NEVER, '1');
                }
            } catch (e4) {}
            markProductsModalDismissed();
        });

        maybeAutoOpenProductsWelcomeModal(el);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProductsWelcomeModal);
    } else {
        initProductsWelcomeModal();
    }
})();
</script>
@endpush
@endif
