{{-- Bouton flottant : Don / Partenaire (+ Agenda si programme) --}}
@php
    $hasAgenda = isset($pastorWelcomeModalActivities) && $pastorWelcomeModalActivities->isNotEmpty();
    $agendaCount = $hasAgenda ? $pastorWelcomeModalActivities->count() : 0;
@endphp
<div
    class="alliance-float-actions{{ $hasAgenda ? ' has-agenda' : '' }}"
    id="allianceFloatActions"
    data-open="0"
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

        toggle.addEventListener('click', function () {
            var open = root.getAttribute('data-open') === '1';
            root.setAttribute('data-open', open ? '0' : '1');
            toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
            menu.hidden = open;
        });

        menu.querySelectorAll('.alliance-float-actions__item').forEach(function (btn) {
            btn.addEventListener('click', function () {
                root.setAttribute('data-open', '0');
                toggle.setAttribute('aria-expanded', 'false');
                menu.hidden = true;
            });
        });

        document.addEventListener('click', function (e) {
            if (!root.contains(e.target) && root.getAttribute('data-open') === '1') {
                root.setAttribute('data-open', '0');
                toggle.setAttribute('aria-expanded', 'false');
                menu.hidden = true;
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
