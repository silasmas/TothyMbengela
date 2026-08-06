{{-- Panier (localStorage) — modale (compatible Bootstrap 5.0) --}}
<div class="modal fade" id="allianceCartModal" tabindex="-1" aria-labelledby="allianceCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="allianceCartModalLabel"><i class="fa fa-shopping-cart me-2" style="color:#A86C3C;"></i> Panier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body d-flex flex-column" style="min-height:200px;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small text-muted">Devise d’affichage</span>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Devise">
                        <button type="button" class="btn btn-outline-secondary js-site-currency" data-currency="USD">USD</button>
                        <button type="button" class="btn btn-outline-secondary js-site-currency" data-currency="CDF">CDF</button>
                    </div>
                </div>
                <div id="alliance-cart-empty" class="text-muted py-4 text-center d-none">Votre panier est vide.</div>
                <ul class="list-unstyled flex-grow-1 mb-0" id="alliance-cart-list"></ul>
                <p class="fw-bold mb-0 mt-3 text-end" id="alliance-cart-total"></p>
            </div>
            <div class="modal-footer flex-column align-items-stretch gap-2">
                <button type="button" class="theme-btn btn-style-one w-100 text-center" id="alliance-checkout-open">
                    <span class="btn-title">Finaliser la commande</span>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm w-100" id="alliance-cart-clear">Vider le panier</button>
            </div>
        </div>
    </div>
</div>
