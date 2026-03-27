import Shepherd from 'shepherd.js';
import 'shepherd.js/dist/css/shepherd.css';

const STORAGE_SKIP_AUTO = 'filament_admin_shepherd_skip_auto';

function labelFromLink(anchor) {
    return anchor.textContent?.replace(/\s+/g, ' ').trim() || 'Élément du menu';
}

function ensureSidebarOpen() {
    const openBtn = document.querySelector('.fi-sidebar-open-collapse-sidebar-btn');
    if (!openBtn) {
        return;
    }
    const style = window.getComputedStyle(openBtn);
    if (style.display === 'none' || style.visibility === 'hidden') {
        return;
    }
    openBtn.click();
}

function buildTour() {
    const nav = document.querySelector('nav.fi-sidebar-nav');
    const links = nav
        ? [...nav.querySelectorAll('a.fi-sidebar-item-btn')]
        : [];
    const userMenuEl = document.querySelector('.fi-user-menu');
    const hasUserMenu = Boolean(userMenuEl);
    const hasNavLinks = links.length > 0;

    const tour = new Shepherd.Tour({
        useModalOverlay: true,
        defaultStepOptions: {
            cancelIcon: { enabled: true },
            scrollTo: {
                behavior: 'smooth',
                block: 'center',
            },
            modalOverlayOpeningPadding: 4,
            when: {
                show() {
                    ensureSidebarOpen();
                },
            },
        },
    });

    const main = document.querySelector('.fi-main');

    tour.addStep({
        id: 'intro',
        title: 'Bienvenue dans l’administration',
        text: 'Ce tableau de bord Filament centralise la gestion du site : contenus, boutique, messages, etc. La suite présente le menu latéral et chaque entrée utile.',
        attachTo: main
            ? {
                  element: main,
                  on: 'bottom',
              }
            : undefined,
        buttons: [
            {
                text: 'Suivant',
                action: tour.next,
            },
        ],
    });

    const sidebar = document.querySelector('.fi-main-sidebar');

    tour.addStep({
        id: 'sidebar',
        title: 'Menu latéral',
        text: 'Les liens sont regroupés par rubriques (Contenu, Boutique…). Sur grand écran, vous pouvez réduire le menu avec la flèche ; sur mobile, utilisez l’icône du bandeau.',
        attachTo: sidebar
            ? {
                  element: sidebar,
                  on: document.dir === 'rtl' ? 'left' : 'right',
              }
            : undefined,
        buttons: [
            {
                text: 'Précédent',
                action: tour.back,
                classes: 'shepherd-button-secondary',
            },
            {
                text: 'Suivant',
                action() {
                    if (hasNavLinks) {
                        tour.next();
                    } else if (hasUserMenu) {
                        tour.show('account');
                    } else {
                        tour.complete();
                    }
                },
            },
        ],
    });

    links.forEach((anchor, index) => {
        const label = labelFromLink(anchor);
        const isLastLink = index === links.length - 1;
        const nextIsAccount = isLastLink && hasUserMenu;
        const nextIsEnd = isLastLink && !hasUserMenu;

        tour.addStep({
            id: `nav-${index}`,
            title: label,
            text: `« ${label} » : accédez à cette section pour lister, créer ou modifier les enregistrements correspondants.`,
            attachTo: {
                element: anchor,
                on: document.dir === 'rtl' ? 'left' : 'right',
            },
            buttons: [
                {
                    text: 'Précédent',
                    action: tour.back,
                    classes: 'shepherd-button-secondary',
                },
                {
                    text: nextIsEnd ? 'Terminer' : 'Suivant',
                    action() {
                        if (nextIsEnd) {
                            tour.complete();
                        } else if (nextIsAccount) {
                            tour.show('account');
                        } else {
                            tour.next();
                        }
                    },
                },
            ],
        });
    });

    if (hasUserMenu) {
        tour.addStep({
            id: 'account',
            title: 'Votre compte',
            text: 'Profil, apparence (clair / sombre) et déconnexion. Avec Filament Shield, les rôles et permissions déterminent les écrans accessibles à chaque administrateur.',
            attachTo: {
                element: userMenuEl,
                on: 'bottom',
            },
            buttons: [
                {
                    text: 'Précédent',
                    action: tour.back,
                    classes: 'shepherd-button-secondary',
                },
                {
                    text: 'Terminer',
                    action: tour.complete,
                },
            ],
        });
    }

    tour.on('complete', () => {
        try {
            localStorage.setItem(STORAGE_SKIP_AUTO, '1');
        } catch {
            /* ignore */
        }
        launcher?.classList.remove('is-active');
    });

    tour.on('cancel', () => {
        launcher?.classList.remove('is-active');
    });

    return tour;
}

let launcher = null;

function injectLauncher() {
    if (launcher || !document.querySelector('.fi-main-sidebar')) {
        return;
    }

    launcher = document.createElement('button');
    launcher.type = 'button';
    launcher.className = 'filament-shepherd-launcher';
    launcher.textContent = 'Visite guidée';
    launcher.setAttribute('aria-label', 'Lancer la visite guidée du tableau de bord');

    launcher.addEventListener('click', () => {
        const tour = buildTour();
        if (!tour.steps?.length) {
            return;
        }
        launcher.classList.add('is-active');
        tour.start();
    });

    document.body.appendChild(launcher);
}

function maybeAutoStart() {
    try {
        if (localStorage.getItem(STORAGE_SKIP_AUTO) === '1') {
            return;
        }
    } catch {
        return;
    }

    const params = new URLSearchParams(window.location.search);
    if (params.get('tour') === '1') {
        queueMicrotask(() => {
            launcher?.click();
        });
    }
}

const style = document.createElement('style');
style.textContent = `
.filament-shepherd-launcher {
    position: fixed;
    z-index: 40;
    bottom: 1.25rem;
    right: 1.25rem;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #0f172a;
    background: #fbbf24;
    border: 1px solid #d97706;
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.15);
    cursor: pointer;
}
.filament-shepherd-launcher:hover {
    filter: brightness(1.05);
}
.filament-shepherd-launcher.is-active {
    opacity: 0;
    pointer-events: none;
}
.shepherd-element {
    max-width: 24rem;
}
`;
document.head.appendChild(style);

function boot() {
    injectLauncher();
    maybeAutoStart();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}

document.addEventListener('livewire:navigated', () => {
    injectLauncher();
});
