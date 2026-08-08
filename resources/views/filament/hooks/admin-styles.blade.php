<style>
    :root {
        --alliance-ochre: #A86C3C;
        --alliance-ochre-dark: #845430;
        --alliance-gold: #C9A25A;
        --alliance-gold-light: #E2C48A;
        --alliance-black: #141414;
        --alliance-cream: #F7F1E8;
        --alliance-cream-soft: #FBF7F1;
        --alliance-muted: #6E6358;
    }

    /* Typo charte */
    .fi-body,
    .fi-simple-layout {
        font-family: "Source Sans 3", "Segoe UI", sans-serif !important;
    }
    .fi-simple-header-heading,
    .fi-header-heading,
    .fi-section-header-heading,
    .fi-wi-stats-overview-stat-label,
    .alliance-admin-footer__brand,
    .alliance-admin-sidebar-foot__name {
        font-family: "Cormorant Garamond", Georgia, serif !important;
    }

    /* ═══════════════════════════════════════════
       Page de connexion (layout simple)
       ═══════════════════════════════════════════ */
    .fi-simple-layout {
        min-height: 100vh;
        background:
            radial-gradient(ellipse 80% 50% at 20% 10%, rgba(201, 162, 90, 0.22) 0%, transparent 55%),
            radial-gradient(ellipse 70% 45% at 90% 90%, rgba(168, 108, 60, 0.35) 0%, transparent 50%),
            linear-gradient(155deg, #141414 0%, #2a1c14 38%, #3d2a1c 68%, #A86C3C 145%) !important;
    }

    .fi-simple-main-ctn {
        padding: 1.5rem !important;
    }

    .fi-simple-main {
        background: #fff !important;
        border-radius: 1.1rem !important;
        box-shadow:
            0 24px 60px rgba(0, 0, 0, 0.35),
            0 0 0 1px rgba(168, 108, 60, 0.12) !important;
        border-top: 3px solid var(--alliance-ochre) !important;
        overflow: hidden;
    }

    .fi-simple-layout .fi-logo {
        height: 4.25rem !important;
        max-width: 220px;
        width: auto;
        object-fit: contain;
    }

    .fi-simple-header {
        gap: 0.65rem !important;
    }

    .fi-simple-header-heading {
        color: var(--alliance-black) !important;
        font-size: 1.85rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.02em;
        line-height: 1.2 !important;
    }

    .fi-simple-header-subheading {
        color: var(--alliance-muted) !important;
        font-size: 0.95rem !important;
        max-width: 22rem;
        margin-inline: auto;
    }

    /* Champs login : bordures visibles, focus ocre */
    .fi-simple-page .fi-input,
    .fi-simple-page input[type="email"],
    .fi-simple-page input[type="password"],
    .fi-simple-page input[type="text"] {
        border-color: rgba(20, 20, 20, 0.22) !important;
        background: var(--alliance-cream-soft) !important;
    }

    .fi-simple-page .fi-input:focus,
    .fi-simple-page input:focus {
        border-color: var(--alliance-ochre) !important;
        --tw-ring-color: rgba(168, 108, 60, 0.35) !important;
    }

    /* Bouton principal login */
    .fi-simple-page .fi-btn-color-primary,
    .fi-simple-page button[type="submit"] {
        background-color: var(--alliance-ochre) !important;
        border-color: var(--alliance-ochre) !important;
        font-weight: 700 !important;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        font-size: 0.8rem !important;
    }

    .fi-simple-page .fi-btn-color-primary:hover,
    .fi-simple-page button[type="submit"]:hover {
        background-color: var(--alliance-ochre-dark) !important;
        border-color: var(--alliance-ochre-dark) !important;
    }

    /* Pied de page login (visible uniquement sur layout simple) */
    .alliance-admin-footer {
        display: none;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 1.25rem 1rem 1.75rem;
        color: rgba(247, 241, 232, 0.78);
        font-size: 0.8rem;
        letter-spacing: 0.04em;
    }

    .fi-simple-layout .alliance-admin-footer {
        display: flex;
    }

    .alliance-admin-footer__brand {
        color: var(--alliance-gold-light);
        font-size: 1.15rem;
        font-weight: 600;
        letter-spacing: 0.06em;
    }

    .alliance-admin-footer__sep {
        opacity: 0.5;
    }

    /* ═══════════════════════════════════════════
       Panel connecté (sidebar / topbar)
       ═══════════════════════════════════════════ */
    .fi-sidebar-header .fi-logo {
        height: 2.75rem !important;
        max-width: 160px;
        object-fit: contain;
    }

    .fi-sidebar-item-button.fi-active,
    .fi-sidebar-item-button:hover {
        background-color: rgba(168, 108, 60, 0.12) !important;
    }

    .fi-sidebar-item-button.fi-active .fi-sidebar-item-label,
    .fi-sidebar-item-button.fi-active .fi-sidebar-item-icon {
        color: var(--alliance-ochre-dark) !important;
    }

    .alliance-admin-sidebar-foot {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
        padding: 0.85rem 1rem 1.1rem;
        border-top: 1px solid rgba(168, 108, 60, 0.18);
        margin-top: auto;
    }

    .alliance-admin-sidebar-foot__label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--alliance-muted);
    }

    .alliance-admin-sidebar-foot__name {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--alliance-ochre);
        letter-spacing: 0.04em;
        line-height: 1.2;
    }

    /* Topbar légère teinte crème */
    .fi-topbar {
        border-bottom-color: rgba(168, 108, 60, 0.15) !important;
    }

    /* ── Recherche globale : barre centrée et élargie ── */
    .fi-topbar .fi-topbar-end {
        flex: 1 1 0%;
        justify-content: center;
    }

    .fi-global-search-ctn {
        width: 100%;
        max-width: 36rem;
        position: relative;
    }

    .fi-global-search {
        width: 100%;
    }

    .fi-global-search-field {
        width: 100%;
    }

    .fi-global-search-results-ctn {
        width: 100%;
        min-width: 100%;
        left: 0 !important;
        right: 0 !important;
    }

    @media (min-width: 1024px) {
        .fi-global-search-ctn {
            max-width: 40rem;
        }
    }

    @media (min-width: 1280px) {
        .fi-global-search-ctn {
            max-width: 48rem;
        }
    }

    @media (max-width: 640px) {
        .fi-simple-layout .fi-logo {
            height: 3.5rem !important;
        }
        .fi-simple-header-heading {
            font-size: 1.5rem !important;
        }
    }
</style>
