@if(isset($pastorWelcomeModalActivities) && $pastorWelcomeModalActivities->isNotEmpty())
@php
    $agendaSpotEmbedUrl = function (?string $url): ?string {
        if (! is_string($url) || $url === '') {
            return null;
        }
        if (preg_match('~(?:youtube\.com/watch\?(?:[^&]*&)*v=|youtu\.be/|youtube\.com/embed/|youtube\.com/shorts/)([A-Za-z0-9_-]{11})~i', $url, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1].'?rel=0&modestbranding=1';
        }
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~i', $url, $m)) {
            return 'https://player.vimeo.com/video/'.$m[1];
        }

        return null;
    };
@endphp
<div
    class="modal fade alliance-agenda-welcome-modal"
    id="alliancePastorAgendaWelcomeModal"
    tabindex="-1"
    aria-labelledby="alliancePastorAgendaWelcomeModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down alliance-agenda-welcome-dialog">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <div class="modal-header alliance-agenda-welcome-header border-0 py-3 px-4">
                <div>
                    <h2 class="modal-title h5 mb-0" id="alliancePastorAgendaWelcomeModalLabel">Agenda — semaine en cours</h2>
                    <p class="text-muted small mb-0 mt-1">Activités du jour et de la semaine</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-0 bg-dark text-white position-relative">
                <div id="alliancePastorAgendaCarousel" class="carousel slide carousel-fade" data-bs-ride="false" data-bs-interval="0" data-bs-touch="false">
                    @if($pastorWelcomeModalActivities->count() > 1)
                        <div class="carousel-indicators alliance-agenda-carousel-indicators">
                            @foreach($pastorWelcomeModalActivities as $activity)
                                <button
                                    type="button"
                                    data-bs-target="#alliancePastorAgendaCarousel"
                                    data-bs-slide-to="{{ $loop->index }}"
                                    class="{{ $loop->first ? 'active' : '' }}"
                                    aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-label="Diapositive {{ $loop->iteration }}"
                                ></button>
                            @endforeach
                        </div>
                    @endif
                    <div class="carousel-inner alliance-agenda-carousel-inner">
                        @foreach($pastorWelcomeModalActivities as $activity)
                            @php
                                $shareUrl = route('pastor-activities.show', $activity);
                                $shareText = $activity->title.' — Alliance | Ministère Tothy Mbengela';
                                $poster = $activity->posterDisplayUrl() ?? $activity->spotImageDisplayUrl();
                                $spotUrl = $activity->spot_url;
                                $spotEmbed = $spotUrl ? $agendaSpotEmbedUrl($spotUrl) : null;
                                $shareUrlFb = 'https://www.facebook.com/sharer/sharer.php?u='.rawurlencode($shareUrl);
                                $shareUrlX = 'https://x.com/intent/tweet?url='.rawurlencode($shareUrl).'&text='.rawurlencode($shareText);
                                $shareUrlWa = 'https://wa.me/?text='.rawurlencode($shareText.' '.$shareUrl);
                                $shareUrlLi = 'https://www.linkedin.com/sharing/share-offsite/?url='.rawurlencode($shareUrl);
                            @endphp
                            <div class="carousel-item alliance-agenda-slide {{ $loop->first ? 'active' : '' }}">
                                <div class="alliance-agenda-slide-visual-wrap">
                                    <div class="alliance-agenda-slide-visual" @if($poster) style="background-image:url('{{ e($poster) }}')" @endif>
                                        <div class="alliance-agenda-slide-overlay"></div>
                                        @if($spotUrl)
                                            <button
                                                type="button"
                                                class="alliance-agenda-play-spot"
                                                title="Voir le spot"
                                                aria-label="Lire le spot vidéo"
                                                data-spot-embed="{{ e($spotEmbed ?? '') }}"
                                                data-spot-fallback="{{ e($spotUrl) }}"
                                            >
                                                <span class="alliance-agenda-play-spot-ring" aria-hidden="true">
                                                    <i class="fa fa-play alliance-agenda-play-spot-icon" aria-hidden="true"></i>
                                                </span>
                                                <span class="alliance-agenda-play-spot-label">Voir le spot</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="alliance-agenda-slide-content">
                                    @if($activity->overlapsToday())
                                        <span class="alliance-agenda-badge-today">Aujourd’hui</span>
                                    @else
                                        <span class="alliance-agenda-badge-week">Cette semaine</span>
                                    @endif
                                    <h3 class="alliance-agenda-slide-title">{{ $activity->title }}</h3>
                                    <p class="alliance-agenda-slide-meta">
                                        {{ $activity->starts_at->translatedFormat('l d F Y — H:i') }}
                                        @if($activity->ends_at)
                                            → {{ $activity->ends_at->translatedFormat('H:i') }}
                                        @endif
                                        @if($activity->location)
                                            <br><span class="alliance-agenda-location"><i class="fa fa-map-marker-alt" aria-hidden="true"></i> {{ $activity->location }}</span>
                                        @endif
                                    </p>
                                    @if($activity->description)
                                        <p class="alliance-agenda-slide-text">{{ \Illuminate\Support\Str::limit(strip_tags($activity->description), 220) }}</p>
                                    @endif
                                    <div class="alliance-agenda-slide-actions">
                                        <a href="{{ route('pastor-activities.show', $activity) }}" class="btn btn-light btn-sm">Détails</a>
                                        @if($spotUrl)
                                            <button
                                                type="button"
                                                class="btn btn-outline-light btn-sm alliance-agenda-spot-link-btn"
                                                data-spot-embed="{{ e($spotEmbed ?? '') }}"
                                                data-spot-fallback="{{ e($spotUrl) }}"
                                            >Spot</button>
                                        @endif
                                    </div>
                                    <div class="alliance-agenda-share" role="group" aria-label="Partager cette activité" onclick="event.stopPropagation();">
                                        <span class="alliance-agenda-share-label">Partager</span>
                                        <a
                                            href="{{ $shareUrlFb }}"
                                            class="btn btn-sm alliance-agenda-share-btn alliance-agenda-share-external-link"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="Facebook"
                                            aria-label="Partager sur Facebook"
                                            onclick="event.stopPropagation(); event.stopImmediatePropagation();"
                                        ><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                        <a
                                            href="{{ $shareUrlX }}"
                                            class="btn btn-sm alliance-agenda-share-btn alliance-agenda-share-external-link alliance-agenda-share-x-link"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="X"
                                            aria-label="Partager sur X"
                                            onclick="event.stopPropagation(); event.stopImmediatePropagation();"
                                        ><svg class="alliance-share-x-svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                                        <a
                                            href="{{ $shareUrlWa }}"
                                            class="btn btn-sm alliance-agenda-share-btn alliance-agenda-share-external-link"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="WhatsApp"
                                            aria-label="Partager sur WhatsApp"
                                            onclick="event.stopPropagation(); event.stopImmediatePropagation();"
                                        ><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                        <a
                                            href="{{ $shareUrlLi }}"
                                            class="btn btn-sm alliance-agenda-share-btn alliance-agenda-share-external-link"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="LinkedIn"
                                            aria-label="Partager sur LinkedIn"
                                            onclick="event.stopPropagation(); event.stopImmediatePropagation();"
                                        ><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                        <button
                                            type="button"
                                            class="btn btn-sm alliance-agenda-share-btn alliance-agenda-copy-link"
                                            title="Copier le lien"
                                            aria-label="Copier le lien"
                                            data-copy-url="{{ e($shareUrl) }}"
                                        ><i class="fa fa-link" aria-hidden="true"></i></button>
                                        <button
                                            type="button"
                                            class="btn btn-sm alliance-agenda-share-btn alliance-agenda-native-share d-none"
                                            title="Partager…"
                                            aria-label="Partager via le système"
                                            data-share-url="{{ e($shareUrl) }}"
                                            data-share-title="{{ e($activity->title) }}"
                                            data-share-text="{{ e(\Illuminate\Support\Str::limit(strip_tags((string) $activity->description), 120)) }}"
                                        ><i class="fa fa-share-alt" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($pastorWelcomeModalActivities->count() > 1)
                        <button class="carousel-control-prev alliance-agenda-carousel-control alliance-agenda-carousel-control-prev" type="button" data-bs-target="#alliancePastorAgendaCarousel" data-bs-slide="prev">
                            <span class="alliance-carousel-nav-box" aria-hidden="true">
                                <span class="carousel-control-prev-icon"></span>
                                <span class="alliance-carousel-nav-label">Précédent</span>
                            </span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next alliance-agenda-carousel-control alliance-agenda-carousel-control-next" type="button" data-bs-target="#alliancePastorAgendaCarousel" data-bs-slide="next">
                            <span class="alliance-carousel-nav-box" aria-hidden="true">
                                <span class="carousel-control-next-icon"></span>
                                <span class="alliance-carousel-nav-label">Suivant</span>
                            </span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    @endif
                </div>
            </div>
            <div class="modal-footer alliance-agenda-welcome-footer flex-column align-items-stretch gap-3 border-0 pt-2 px-4 pb-4">
                <p class="alliance-agenda-footer-hint mb-0">
                    <i class="fa fa-info-circle text-primary me-1" aria-hidden="true"></i>
                    Utilisez <strong>Précédent</strong> et <strong>Suivant</strong> pour parcourir les activités. Vous pouvez masquer cette fenêtre de bienvenue ci-dessous.
                </p>
                <div class="alliance-agenda-never-box form-check alliance-agenda-never-check">
                    <input class="form-check-input" type="checkbox" value="1" id="alliancePastorAgendaWelcomeNever">
                    <label class="form-check-label" for="alliancePastorAgendaWelcomeNever">
                        Ne plus afficher cette fenêtre lors de mes prochaines visites sur le site
                    </label>
                </div>
                <button type="button" class="btn btn-primary btn-lg w-100 w-sm-auto ms-sm-auto" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- Lecteur spot (YouTube / Vimeo) par-dessus la modale agenda --}}
<div class="modal fade alliance-agenda-spot-video-modal" id="alliancePastorSpotVideoModal" tabindex="-1" aria-hidden="true" aria-labelledby="alliancePastorSpotVideoModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
        <div class="modal-content bg-black border-0 overflow-hidden">
            <div class="modal-header border-secondary border-opacity-25 py-2 px-3">
                <h3 class="modal-title text-white h6 mb-0" id="alliancePastorSpotVideoModalLabel">Spot</h3>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer la vidéo"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9 bg-dark">
                    <iframe
                        id="alliancePastorSpotVideoIframe"
                        class="alliance-pastor-spot-iframe"
                        title="Spot vidéo"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        src="about:blank"
                    ></iframe>
                </div>
                <p class="text-white-50 small px-3 py-2 mb-0 alliance-agenda-spot-fallback-wrap d-none" id="alliancePastorSpotFallbackNote">
                    <a href="#" class="link-light alliance-agenda-spot-fallback-link" target="_blank" rel="noopener noreferrer">Ouvrir le spot dans un nouvel onglet</a>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- FAB Agenda intégré dans partials/alliance-float-actions (bouton Soutenir) --}}
@php
    $pastorAgendaFabCount = $pastorWelcomeModalActivities->count();
@endphp
<button type="button" id="alliancePastorAgendaFab" class="d-none" aria-hidden="true" tabindex="-1"></button>

@push('scripts')
<script>
(function () {
    var STORAGE_NEVER = 'alliance_pastor_agenda_welcome_never';
    var STORAGE_SESSION = 'alliance_pastor_agenda_welcome_shown_session';

    function showToast(msg) {
        var toast = document.getElementById('alliance-site-toast');
        if (!toast) {
            return;
        }
        toast.textContent = msg;
        toast.className = 'alliance-site-toast show success agenda-modal-toast';
        clearTimeout(showToast._t);
        showToast._t = setTimeout(function () {
            toast.className = 'alliance-site-toast';
        }, 2800);
    }

    function openSpotVideo(embedUrl, fallbackUrl) {
        var spotModalEl = document.getElementById('alliancePastorSpotVideoModal');
        var iframe = document.getElementById('alliancePastorSpotVideoIframe');
        var note = document.getElementById('alliancePastorSpotFallbackNote');
        var link = note ? note.querySelector('.alliance-agenda-spot-fallback-link') : null;
        if (!spotModalEl || !iframe || typeof bootstrap === 'undefined' || !bootstrap.Modal) {
            if (fallbackUrl) {
                window.open(fallbackUrl, '_blank', 'noopener,noreferrer');
            }
            return;
        }
        if (embedUrl && embedUrl.length > 0) {
            iframe.src = embedUrl;
            if (note) {
                note.classList.add('d-none');
            }
        } else if (fallbackUrl) {
            iframe.src = 'about:blank';
            if (note && link) {
                link.href = fallbackUrl;
                note.classList.remove('d-none');
            }
        }
        var m = bootstrap.Modal.getOrCreateInstance(spotModalEl, { keyboard: true });
        m.show();
    }

    function wireSpotTriggers(root) {
        root.querySelectorAll('.alliance-agenda-play-spot, .alliance-agenda-spot-link-btn').forEach(function (btn) {
            var fallback = btn.getAttribute('data-spot-fallback');
            if (!fallback) {
                return;
            }
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                var embed = btn.getAttribute('data-spot-embed') || '';
                openSpotVideo(embed, fallback);
            });
        });
    }

    function setupPastorAgendaWelcomeModal(el) {
        wireSpotTriggers(el);

        var spotModalEl = document.getElementById('alliancePastorSpotVideoModal');
        if (spotModalEl) {
            spotModalEl.addEventListener('hidden.bs.modal', function () {
                var iframe = document.getElementById('alliancePastorSpotVideoIframe');
                if (iframe) {
                    iframe.src = 'about:blank';
                }
                var note = document.getElementById('alliancePastorSpotFallbackNote');
                if (note) {
                    note.classList.add('d-none');
                }
            });
        }

        el.querySelectorAll('.alliance-agenda-copy-link').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                var url = btn.getAttribute('data-copy-url');
                if (!url) {
                    return;
                }
                var ok = function () {
                    showToast('Lien copié — vous pouvez le coller où vous voulez.');
                };
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(ok).catch(function () {
                        window.prompt('Copiez le lien :', url);
                        ok();
                    });
                } else {
                    window.prompt('Copiez le lien :', url);
                    ok();
                }
            });
        });

        if (navigator.share) {
            el.querySelectorAll('.alliance-agenda-native-share').forEach(function (btn) {
                btn.classList.remove('d-none');
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var u = btn.getAttribute('data-share-url');
                    var title = btn.getAttribute('data-share-title') || '';
                    var text = btn.getAttribute('data-share-text') || '';
                    navigator.share({ title: title, text: text, url: u }).catch(function () {});
                });
            });
        }

        el.addEventListener('hidden.bs.modal', function () {
            var cb = document.getElementById('alliancePastorAgendaWelcomeNever');
            try {
                if (cb && cb.checked) {
                    localStorage.setItem(STORAGE_NEVER, '1');
                }
            } catch (e3) {}
        });
    }

    /**
     * Ouvre l’agenda après la modale produits (priorité boutique à l’ouverture).
     *
     * @param {HTMLElement} el Modale agenda
     * @returns {void}
     */
    function openPastorAgendaWelcome(el) {
        try {
            if (localStorage.getItem(STORAGE_NEVER) === '1' || sessionStorage.getItem(STORAGE_SESSION) === '1') {
                return;
            }
            sessionStorage.setItem(STORAGE_SESSION, '1');
        } catch (eOpen) {
            return;
        }
        bootstrap.Modal.getOrCreateInstance(el, { keyboard: true }).show();
    }

    function maybeAutoOpenPastorAgendaWelcomeModal(el) {
        var delayMs = 1200;
        setTimeout(function () {
            try {
                if (localStorage.getItem(STORAGE_NEVER) === '1' || sessionStorage.getItem(STORAGE_SESSION) === '1') {
                    return;
                }
            } catch (e2) {
                return;
            }
            var productsModal = document.getElementById('allianceProductsWelcomeModal');
            var productsNever = false;
            try {
                productsNever = localStorage.getItem('alliance_products_welcome_never') === '1';
            } catch (eProducts) {}

            // Si une modale produits existe et n’est pas désactivée, attendre sa fermeture.
            if (productsModal && !productsNever) {
                if (productsModal.classList.contains('show')) {
                    productsModal.addEventListener('hidden.bs.modal', function openAgendaAfterProducts() {
                        productsModal.removeEventListener('hidden.bs.modal', openAgendaAfterProducts);
                        openPastorAgendaWelcome(el);
                    });
                    return;
                }
                // Produits déjà montrés cette session : ne pas empiler l’agenda automatiquement.
                try {
                    if (sessionStorage.getItem('alliance_products_welcome_shown_session') === '1') {
                        return;
                    }
                } catch (eSkip) {}
            }
            openPastorAgendaWelcome(el);
        }, delayMs);
    }

    function initPastorAgendaFabAndWelcomeModal() {
        var el = document.getElementById('alliancePastorAgendaWelcomeModal');
        var fab = document.getElementById('alliancePastorAgendaFab');
        if (!el || typeof bootstrap === 'undefined' || !bootstrap.Modal) {
            return;
        }

        setupPastorAgendaWelcomeModal(el);

        if (fab) {
            fab.addEventListener('click', function () {
                bootstrap.Modal.getOrCreateInstance(el, { keyboard: true }).show();
            });
        }

        maybeAutoOpenPastorAgendaWelcomeModal(el);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPastorAgendaFabAndWelcomeModal);
    } else {
        initPastorAgendaFabAndWelcomeModal();
    }
})();
</script>
@endpush
@endif
