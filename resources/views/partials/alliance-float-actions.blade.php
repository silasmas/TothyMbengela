{{-- Bouton flottant : Don / Partenaire (+ Agenda / Produits selon contexte) --}}
@php
    $hasAgenda = isset($pastorWelcomeModalActivities) && $pastorWelcomeModalActivities->isNotEmpty();
    $agendaCount = $hasAgenda ? $pastorWelcomeModalActivities->count() : 0;
    $hasProductsModal = !empty($productsWelcomeModalEnabled)
        && isset($featuredProducts)
        && $featuredProducts->isNotEmpty();
@endphp
<div
    class="alliance-float-actions{{ $hasAgenda ? ' has-agenda' : '' }}{{ $hasProductsModal ? ' has-products-ready' : '' }}"
    id="allianceFloatActions"
    data-open="0"
    data-products-modal="{{ $hasProductsModal ? '1' : '0' }}"
>
    <div class="alliance-float-actions__menu" id="allianceFloatActionsMenu" hidden>
        <button type="button" class="alliance-float-actions__item" data-bs-toggle="modal" data-bs-target="#donatePartnerModal">
            <i class="fa fa-heart" aria-hidden="true"></i>
            <span>Faire un don</span>
        </button>
        <button type="button" class="alliance-float-actions__item js-donate-modal-partner">
            <i class="fa fa-handshake" aria-hidden="true"></i>
            <span>Devenir partenaire</span>
        </button>
        @if($hasAgenda)
            <button
                type="button"
                class="alliance-float-actions__item alliance-float-actions__item--agenda"
                data-bs-toggle="modal"
                data-bs-target="#alliancePastorAgendaWelcomeModal"
            >
                <i class="fa fa-calendar-check" aria-hidden="true"></i>
                <span>Agenda</span>
                @if($agendaCount > 0)
                    <em class="alliance-float-actions__badge">{{ $agendaCount }}</em>
                @endif
            </button>
        @endif
        @if($hasProductsModal)
            <button
                type="button"
                class="alliance-float-actions__item alliance-float-actions__item--products"
                id="allianceFloatProductsBtn"
                data-bs-toggle="modal"
                data-bs-target="#allianceProductsWelcomeModal"
                hidden
            >
                <i class="fa fa-book-open" aria-hidden="true"></i>
                <span>Produits</span>
            </button>
        @endif
        <button type="button" class="alliance-float-actions__item alliance-float-actions__item--close" id="allianceFloatActionsClose" aria-label="Fermer le menu">
            <i class="fa fa-times" aria-hidden="true"></i>
            <span>Fermer</span>
        </button>
    </div>
    <button
        type="button"
        class="alliance-float-actions__toggle{{ $hasAgenda ? ' is-pulse-agenda' : '' }}"
        id="allianceFloatActionsToggle"
        aria-expanded="false"
        aria-controls="allianceFloatActionsMenu"
        title="Soutenir le ministère"
    >
        <i class="fa fa-hands-helping alliance-float-actions__icon" aria-hidden="true"></i>
        <span class="alliance-float-actions__label">Soutenir</span>
    </button>
</div>

@push('scripts')
<script>
(function () {
    /**
     * Ouvre / ferme le menu flottant Soutenir.
     *
     * @returns {void}
     */
    function initAllianceFloatActions() {
        var root = document.getElementById('allianceFloatActions');
        var toggle = document.getElementById('allianceFloatActionsToggle');
        var menu = document.getElementById('allianceFloatActionsMenu');
        if (!root || !toggle || !menu) {
            return;
        }

        /**
         * Ferme le menu flottant sans lancer d’action.
         *
         * @returns {void}
         */
        function closeMenu() {
            root.setAttribute('data-open', '0');
            toggle.setAttribute('aria-expanded', 'false');
            menu.hidden = true;
        }

        /**
         * Ouvre le menu flottant.
         *
         * @returns {void}
         */
        function openMenu() {
            root.setAttribute('data-open', '1');
            toggle.setAttribute('aria-expanded', 'true');
            menu.hidden = false;
        }

        /**
         * Affiche le bouton Produits dans le menu flottant.
         *
         * @returns {void}
         */
        function showProductsShortcut() {
            var btn = document.getElementById('allianceFloatProductsBtn');
            if (!btn) {
                return;
            }
            btn.hidden = false;
            btn.classList.remove('d-none');
            root.classList.add('has-products');
        }

        document.addEventListener('alliance:products-modal-dismissed', showProductsShortcut);

        try {
            if (
                root.getAttribute('data-products-modal') === '1'
                && (
                    sessionStorage.getItem('alliance_products_welcome_dismissed') === '1'
                    || localStorage.getItem('alliance_products_welcome_never') === '1'
                )
            ) {
                showProductsShortcut();
            }
        } catch (e) {}

        toggle.addEventListener('click', function () {
            if (root.getAttribute('data-open') === '1') {
                closeMenu();
            } else {
                openMenu();
            }
        });

        document.getElementById('allianceFloatActionsClose')?.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            closeMenu();
        });

        menu.querySelectorAll('.alliance-float-actions__item:not(.alliance-float-actions__item--close)').forEach(function (btn) {
            btn.addEventListener('click', function () {
                closeMenu();
            });
        });

        document.addEventListener('click', function (e) {
            if (!root.contains(e.target) && root.getAttribute('data-open') === '1') {
                closeMenu();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && root.getAttribute('data-open') === '1') {
                closeMenu();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllianceFloatActions);
    } else {
        initAllianceFloatActions();
    }
})();
</script>
@endpush
