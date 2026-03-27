<style>
    /* ── Logo plus grand sur la page login ── */
    .fi-simple-layout .fi-logo {
        height: 5rem !important;
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
</style>
