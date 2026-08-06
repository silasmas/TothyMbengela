{{-- Règles CSS partagées : inclure dans un bloc <style> parent --}}
    .alliance-series-episodes__heading {
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #1a1a1a;
        margin-bottom: 1rem;
        line-height: 1.35;
    }
    .alliance-series-episodes__series-name { color: #1a1a1a; }
    .alliance-series-episodes__list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .alliance-series-episode-card {
        display: flex;
        align-items: stretch;
        gap: 14px;
        padding: 12px 14px;
        background: #fff;
        border: 1px solid #e8e4dc;
        border-radius: 10px;
        text-decoration: none;
        color: inherit;
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .alliance-series-episode-card:hover {
        border-color: #d4c4a8;
        box-shadow: 0 6px 24px rgba(30, 20, 10, 0.06);
        color: inherit;
    }
    .alliance-series-episode-card.is-current {
        border-color: #A86C3C;
        box-shadow: 0 0 0 1px rgba(200, 146, 42, 0.25);
    }
    .alliance-series-episode-card__num {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #b89968;
        color: #fff;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        align-self: center;
    }
    .alliance-series-episode-card__thumb {
        flex-shrink: 0;
        width: 96px;
        border-radius: 8px;
        overflow: hidden;
        background: #ece9e0;
    }
    .alliance-series-episode-card__thumb img {
        width: 100%;
        height: 100%;
        min-height: 54px;
        object-fit: cover;
        display: block;
    }
    .alliance-series-episode-card__thumb-fallback {
        display: block;
        width: 100%;
        min-height: 54px;
        background: linear-gradient(135deg, #e8e4dc, #d8d2c6);
    }
    .alliance-series-episode-card__body {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 4px;
    }
    .alliance-series-episode-card__title {
        display: block;
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #9a7b4f;
        line-height: 1.35;
    }
    .alliance-series-episode-card:hover .alliance-series-episode-card__title { color: #7d5f36; }
    .alliance-series-episode-card__date {
        font-size: 0.8rem;
        color: #888;
    }
    .alliance-series-episode-card__excerpt {
        font-size: 0.8rem;
        color: #666;
        line-height: 1.4;
        margin-top: 2px;
    }
