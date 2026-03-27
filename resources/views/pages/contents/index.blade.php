@extends('layouts.app')

@section('page_banner_title', 'Nos contenus')

@section('page_banner_breadcrumbs')
    <li>Contenus</li>
@endsection

@section('content')

    <section class="news-section alliance-contents-listing">
        <div class="auto-container">

            <div class="alliance-contents-filter-wrap mb-5">
                <div class="alliance-contents-filter-inner">
                    <p class="alliance-contents-filter-intro mb-3 mb-md-4">
                        <strong>Affinez la liste</strong> — choisissez une rubrique ou un type de média pour ne voir que les prédications et enseignements qui vous intéressent. La recherche porte sur le titre et le résumé.
                    </p>
                    <form method="GET" action="{{ route('contents.index') }}" class="alliance-contents-filter-form">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4 col-lg-3">
                                <label for="contents-filter-q" class="form-label fw-semibold text-uppercase small alliance-filter-label">Recherche</label>
                                <input id="contents-filter-q" type="text" name="q" value="{{ request('q') }}" placeholder="Mots-clés…" class="form-control alliance-filter-control">
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="contents-filter-rubrique" class="form-label fw-semibold text-uppercase small alliance-filter-label">Rubrique</label>
                                <select id="contents-filter-rubrique" name="rubrique" class="form-control alliance-filter-control" aria-describedby="contents-filter-rubrique-hint">
                                    <option value="">Toutes les rubriques</option>
                                    @foreach($rubriques as $r)
                                        <option value="{{ $r->slug }}" {{ request('rubrique') === $r->slug ? 'selected' : '' }}>{{ $r->name }}</option>
                                    @endforeach
                                </select>
                                <span id="contents-filter-rubrique-hint" class="visually-hidden">Filtrer par thématique du ministère</span>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="contents-filter-type" class="form-label fw-semibold text-uppercase small alliance-filter-label">Type de contenu</label>
                                <select id="contents-filter-type" name="type" class="form-control alliance-filter-control">
                                    <option value="">Tous les types</option>
                                    @foreach($types as $t)
                                        <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ match($t) { 'video' => 'Vidéo', 'audio' => 'Audio', 'podcast' => 'Podcast', 'article' => 'Article', default => ucfirst($t) } }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 d-flex flex-wrap gap-2 pt-1 pt-lg-0">
                                <button type="submit" class="theme-btn btn-style-one flex-grow-1 flex-lg-grow-0"><span class="btn-title">Appliquer les filtres</span></button>
                                @if(request()->hasAny(['q', 'rubrique', 'type']))
                                    <a href="{{ route('contents.index') }}" class="theme-btn btn-style-two flex-grow-1 flex-lg-grow-0"><span class="btn-title">Réinitialiser</span></a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if($contents->isEmpty())
                <div class="text-center py-5">
                    <h4>Aucun contenu trouvé.</h4>
                    <p>Essayez d’élargir la recherche ou de réinitialiser les filtres.</p>
                </div>
            @else
                <div class="row">
                    @foreach($contents as $content)
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="{{ ($loop->index % 3) * 200 }}ms">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image">
                                    <a href="{{ route('contents.show', $content->slug) }}">
                                        @if($content->getThumbnailDisplayUrl())
                                            <img src="{{ $content->getThumbnailDisplayUrl() }}" alt="{{ $content->title }}">
                                        @else
                                            <img src="https://placehold.co/400x250/e2e8f0/64748b?text=Alliance" alt="{{ $content->title }}">
                                        @endif
                                    </a>
                                </figure>
                                <span class="date">{{ $content->published_at?->locale('fr')->isoFormat('D MMM YYYY') ?? '—' }}</span>
                            </div>
                            <div class="lower-content">
                                <div class="post-meta">
                                    <ul>
                                        <li><i class="far fa-folder-open"></i> {{ $content->rubrique?->name ?? 'Général' }}</li>
                                        <li><i class="far fa-play-circle"></i> {{ match($content->type) { 'video' => 'Vidéo', 'audio' => 'Audio', 'podcast' => 'Podcast', 'article' => 'Article', default => $content->type } }}</li>
                                    </ul>
                                </div>
                                <h4 class="title"><a href="{{ route('contents.show', $content->slug) }}">{{ Str::limit($content->title, 60) }}</a></h4>
                                @if($content->excerpt)
                                    <div class="text">{{ Str::limit($content->excerpt, 100) }}</div>
                                @endif
                                <div class="d-flex align-items-center justify-content-start flex-wrap gap-2 mt-2 pt-2 border-top border-1" style="border-color: rgba(0,0,0,0.06) !important;">
                                    @auth
                                        @php $likedCard = in_array($content->id, $likedContentIds, true); @endphp
                                        <button type="button"
                                            class="btn alliance-content-like-pill alliance-content-like-btn {{ $likedCard ? 'btn-warning text-dark' : 'btn-outline-secondary' }}"
                                            data-content-slug="{{ $content->slug }}"
                                            data-like-url="{{ route('contents.like', $content->slug) }}"
                                            data-liked="{{ $likedCard ? '1' : '0' }}"
                                            aria-pressed="{{ $likedCard ? 'true' : 'false' }}"
                                            onclick="event.preventDefault(); event.stopPropagation();">
                                            <i class="fa fa-heart{{ $likedCard ? '' : '-o' }}"></i>
                                            <span class="alliance-content-like-count-num" data-for-slug="{{ $content->slug }}">{{ $content->content_likes_count }}</span>
                                            <span class="d-none d-md-inline ms-1 fw-semibold">J’aime</span>
                                        </button>
                                    @else
                                        <button type="button"
                                            class="btn btn-outline-secondary alliance-content-like-pill alliance-content-like-btn alliance-content-like-guest"
                                            data-content-slug="{{ $content->slug }}"
                                            data-like-url="{{ route('contents.like', $content->slug) }}"
                                            onclick="event.preventDefault(); event.stopPropagation();">
                                            <i class="fa fa-heart-o"></i>
                                            <span class="alliance-content-like-count-num" data-for-slug="{{ $content->slug }}">{{ $content->content_likes_count }}</span>
                                            <span class="ms-1 fw-semibold">J’aime</span>
                                        </button>
                                    @endauth
                                </div>
                                <a href="{{ route('contents.show', $content->slug) }}" class="read-more">Lire la suite <i class="fa fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $contents->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection

@push('styles')
<style>
    .alliance-contents-filter-wrap {
        position: relative;
        border-radius: 14px;
        padding: 2px;
        background: linear-gradient(135deg, rgba(200, 146, 42, 0.45), rgba(212, 168, 74, 0.2));
        box-shadow: 0 12px 40px rgba(30, 20, 10, 0.06);
    }
    .alliance-contents-filter-inner {
        background: #fff;
        border-radius: 12px;
        padding: 1.35rem 1.5rem 1.5rem;
        border: 1px solid rgba(200, 146, 42, 0.12);
    }
    @media (min-width: 768px) {
        .alliance-contents-filter-inner { padding: 1.75rem 2rem 2rem; }
    }
    .alliance-contents-filter-intro {
        color: #4a4338;
        line-height: 1.55;
        font-size: 0.98rem;
        margin-bottom: 0;
    }
    .alliance-contents-filter-intro strong {
        color: #1a1a1a;
    }
    .alliance-filter-label {
        color: #6b5c48;
        letter-spacing: 0.06em;
        margin-bottom: 0.35rem;
    }
    .alliance-filter-control {
        border-radius: 8px !important;
        border: 1px solid #e5dfd4 !important;
        min-height: 48px;
        background: #fdfcfa !important;
    }
    .alliance-filter-control:focus {
        border-color: #c8922a !important;
        box-shadow: 0 0 0 3px rgba(200, 146, 42, 0.18) !important;
    }
    .alliance-contents-listing .alliance-content-like-pill {
        border-radius: 999px !important;
        padding: 0.35rem 0.85rem !important;
        font-weight: 600;
        font-size: 0.85rem;
        position: relative;
        z-index: 2;
        cursor: pointer;
    }
    .alliance-contents-listing .alliance-content-like-pill .alliance-content-like-count-num {
        margin-left: 0.25rem;
        font-weight: 800;
    }
</style>
@endpush
