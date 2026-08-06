@extends('layouts.app')

@section('page_banner_title', Str::limit($content->title, 52))

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('contents.index') }}">Contenus</a></li>
    @if($content->rubrique)
        <li><a href="{{ route('contents.index', ['rubrique' => $content->rubrique->slug]) }}">{{ $content->rubrique->name }}</a></li>
    @endif
    <li>{{ Str::limit($content->title, 40) }}</li>
@endsection

@section('content')

@php
    $pub = $content->published_at;
    $dayFr = $pub ? $pub->locale('fr')->format('d') : '—';
    $monthFr = $pub ? mb_strtoupper($pub->locale('fr')->isoFormat('MMM')) : '';
    $heroUrl = $content->getThumbnailDisplayUrl();
    $hasYoutube = filled($content->youtube_video_id);
    $commentAuthReturn = parse_url(route('contents.show', $content->slug), PHP_URL_PATH).'#commentaires';
    $typeLabel = match ($content->type) {
        'video' => 'Vidéo',
        'audio' => 'Audio',
        'podcast' => 'Podcast',
        'article' => 'Article',
        default => ucfirst($content->type),
    };
    $commentsCount = $contentComments->count();
    $commentsLabel = $commentsCount <= 1 ? 'commentaire' : 'commentaires';
@endphp

    <section class="blog-details alliance-blog-details pt-2 pb-5" id="commentaires">
        <div class="auto-container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="blog-details__left">
                        @if(!$hasYoutube)
                            <div class="blog-details__img">
                                @if($heroUrl)
                                    <img src="{{ $heroUrl }}" alt="{{ $content->title }}">
                                @else
                                    <img src="https://placehold.co/1200x640/e8e4dc/5c4a32?text=Alliance" alt="{{ $content->title }}">
                                @endif
                                <div class="blog-details__date">
                                    <span class="day">{{ $dayFr }}</span>
                                    <span class="month">{{ $monthFr }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="blog-details__content">
                            @if($hasYoutube)
                                <div class="video-box alliance-content-video-frame mb-4">
                                    <div class="alliance-content-video-frame__bg" style="background-image: url('{{ asset('assets/images/Im3.jpg.jpeg') }}');" role="presentation"></div>
                                    <div class="alliance-content-video-frame__player">
                                        <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:10px;">
                                            <iframe src="https://www.youtube.com/embed/{{ $content->youtube_video_id }}" title="{{ $content->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <ul class="list-unstyled blog-details__meta">
                                <li>
                                    @if($content->rubrique)
                                        <a href="{{ route('contents.index', ['rubrique' => $content->rubrique->slug]) }}">
                                            <i class="fa fa-user-circle"></i> Alliance
                                        </a>
                                    @else
                                        <span class="text-muted" style="cursor:default;"><i class="fa fa-user-circle"></i> Alliance</span>
                                    @endif
                                </li>
                                <li>
                                    <span class="text-muted" style="cursor:default;">
                                        <i class="fa fa-play-circle"></i> {{ $typeLabel }}
                                    </span>
                                </li>
                                @if($content->duration_seconds)
                                    <li>
                                        <span class="text-muted" style="cursor:default;">
                                            <i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $content->duration_seconds) }}
                                        </span>
                                    </li>
                                @endif
                                @if($hasYoutube && $pub)
                                    <li>
                                        <span class="text-muted" style="cursor:default;">
                                            <i class="fa fa-calendar"></i> {{ $pub->locale('fr')->isoFormat('D MMMM YYYY') }}
                                        </span>
                                    </li>
                                @endif
                                <li>
                                    <button type="button" class="btn btn-link p-0 align-baseline text-decoration-none alliance-meta-comments-btn" data-bs-toggle="modal" data-bs-target="#allianceContentCommentsModal" style="color:#777;font-weight:500;">
                                        <i class="fa fa-comments"></i> <span id="alliance-comments-count-meta">{{ $commentsCount }}</span> <span id="alliance-comments-label-meta">{{ $commentsLabel }}</span>
                                    </button>
                                </li>
                                <li class="alliance-meta-like-item">
                                    @auth
                                        <button type="button"
                                            class="btn alliance-content-like-pill alliance-content-like-btn {{ $userLikedContent ? 'btn-warning text-dark' : 'btn-outline-secondary' }}"
                                            data-content-slug="{{ $content->slug }}"
                                            data-like-url="{{ route('contents.like', $content->slug) }}"
                                            data-liked="{{ $userLikedContent ? '1' : '0' }}"
                                            aria-pressed="{{ $userLikedContent ? 'true' : 'false' }}"
                                            title="Cliquez pour aimer ou retirer votre j’aime">
                                            <i class="fa fa-heart{{ $userLikedContent ? '' : '-o' }}" aria-hidden="true"></i>
                                            <span class="alliance-content-like-count-num" data-for-slug="{{ $content->slug }}">{{ $content->content_likes_count }}</span>
                                            <span class="d-none d-sm-inline ms-1 fw-semibold">J’aime</span>
                                        </button>
                                    @else
                                        <button type="button"
                                            class="btn btn-outline-secondary alliance-content-like-pill alliance-content-like-btn alliance-content-like-guest"
                                            data-content-slug="{{ $content->slug }}"
                                            data-like-url="{{ route('contents.like', $content->slug) }}"
                                            title="Connexion requise — ouvre la fenêtre de connexion">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                            <span class="alliance-content-like-count-num" data-for-slug="{{ $content->slug }}">{{ $content->content_likes_count }}</span>
                                            <span class="ms-1 fw-semibold">J’aime</span>
                                        </button>
                                    @endauth
                                </li>
                            </ul>

                            @if($content->series)
                                <div class="mb-3">
                                    <a href="{{ route('series.show', $content->series->slug) }}" class="theme-btn btn-style-two" style="padding:6px 16px;font-size:13px;">
                                        <span class="btn-title">Série : {{ $content->series->title }}</span>
                                    </a>
                                </div>
                            @endif

                            <h3 class="blog-details__title">{{ $content->title }}</h3>

                            @if($content->series && $content->series->contents->isNotEmpty())
                                <section class="alliance-series-episodes mb-4" aria-label="Épisodes de la série">
                                    <h4 class="alliance-series-episodes__heading">
                                        Dans la même série : <span class="alliance-series-episodes__series-name">{{ mb_strtoupper($content->series->title) }}</span>
                                    </h4>
                                    <div class="alliance-series-episodes__list">
                                        @foreach($content->series->contents as $index => $episode)
                                            <a href="{{ route('contents.show', $episode->slug) }}" class="alliance-series-episode-card {{ $episode->id === $content->id ? 'is-current' : '' }}">
                                                <span class="alliance-series-episode-card__num" aria-hidden="true">{{ $index + 1 }}</span>
                                                <span class="alliance-series-episode-card__thumb">
                                                    @if($episode->getThumbnailDisplayUrl())
                                                        <img src="{{ $episode->getThumbnailDisplayUrl() }}" alt="">
                                                    @else
                                                        <span class="alliance-series-episode-card__thumb-fallback"></span>
                                                    @endif
                                                </span>
                                                <span class="alliance-series-episode-card__body">
                                                    <span class="alliance-series-episode-card__title">{{ mb_strtoupper($episode->title) }}</span>
                                                    <span class="alliance-series-episode-card__date">{{ $episode->published_at?->format('d/m/Y') ?? '—' }}</span>
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </section>
                            @endif

                            @if($content->excerpt)
                                <p class="blog-details__text-2 fw-semibold">{{ $content->excerpt }}</p>
                            @endif

                            @if($content->body)
                                <div class="blog-details__text-2">
                                    {!! nl2br(e($content->body)) !!}
                                </div>
                            @endif
                        </div>

                        <div class="blog-details__bottom">
                            <p class="blog-details__tags">
                                <span>Tags</span>
                                @if($content->rubrique)
                                    <a href="{{ route('contents.index', ['rubrique' => $content->rubrique->slug]) }}">{{ $content->rubrique->name }}</a>
                                @endif
                                <a href="{{ route('contents.index', ['type' => $content->type]) }}">{{ $typeLabel }}</a>
                                @if($content->theme)
                                    <a href="{{ route('contents.index') }}">{{ $content->theme->name }}</a>
                                @endif
                            </p>
                            <div class="blog-details__social-list alliance-blog-social">
                                <a href="https://www.youtube.com/@tothy_mbengela" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                                <a href="{{ route('contact.create') }}" aria-label="Contact"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                <a href="{{ route('donate.create') }}" aria-label="Soutenir"><i class="fa fa-heart" aria-hidden="true"></i></a>
                            </div>
                        </div>

                        @if($prevContent || $nextContent)
                            <div class="nav-links">
                                @if($prevContent)
                                    <div class="prev">
                                        <a href="{{ route('contents.show', $prevContent->slug) }}" rel="prev">{{ Str::limit($prevContent->title, 72) }}</a>
                                    </div>
                                @else
                                    <div class="prev"></div>
                                @endif
                                @if($nextContent)
                                    <div class="next">
                                        <a href="{{ route('contents.show', $nextContent->slug) }}" rel="next">{{ Str::limit($nextContent->title, 72) }}</a>
                                    </div>
                                @else
                                    <div class="next"></div>
                                @endif
                            </div>
                        @endif

                        <div class="comment-one alliance-content-comments-preview">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                                <h3 class="comment-one__title mb-0"><span id="alliance-comments-count-preview">{{ $commentsCount }}</span> <span id="alliance-comments-label-preview">{{ $commentsLabel }}</span></h3>
                                <button type="button" class="theme-btn btn-style-one" data-bs-toggle="modal" data-bs-target="#allianceContentCommentsModal">
                                    <span class="btn-title"><i class="fa fa-comments me-1"></i> Voir tous les commentaires</span>
                                </button>
                            </div>

                            @guest
                                <p class="text-muted small mb-3">
                                    Pour publier un commentaire ou un « j’aime » (commentaires), ouvrez la fenêtre ci-dessous puis
                                    <button type="button" class="btn btn-link btn-sm p-0 align-baseline" data-bs-toggle="modal" data-bs-target="#allianceOtpAuthModal" onclick="sessionStorage.setItem('alliance_open_comments_after_auth','1');">connectez-vous ou créez un compte par e-mail (modale)</button>.
                                </p>
                            @endguest

                            @if(session('comment_success'))
                                <div class="alert alert-success alliance-comment-flash">{{ __('Merci ! Votre commentaire a été publié.') }}</div>
                            @endif

                            <p id="alliance-comments-preview-empty" class="text-muted mb-0 @unless($contentComments->isEmpty()) d-none @endunless">Soyez le premier à laisser un encouragement ou une réflexion sur cet enseignement.</p>
                            <p id="alliance-comments-preview-hint" class="text-muted small mb-3 @if($contentComments->isEmpty()) d-none @endif">Aperçu des derniers messages — ouvrez la fenêtre pour tout lire, réagir et participer.</p>
                            <div id="alliance-comments-preview-list">
                                @foreach($contentComments->take(2) as $c)
                                    <div class="comment-one__single alliance-comment-preview-item">
                                        <div class="comment-one__image">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($c->author_name) }}&background=A86C3C&color=fff&size=80" alt="">
                                        </div>
                                        <div class="comment-one__content">
                                            <h3>{{ $c->author_name }}</h3>
                                            <p>{{ Str::limit($c->body, 220) }}</p>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="small text-muted" title="{{ $c->created_at->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}">{{ $c->created_at->locale('fr')->diffForHumans() }}</span>
                                                <span class="small text-muted">·</span>
                                                <span class="small text-muted alliance-like-count-preview" data-comment-id="{{ $c->id }}">{{ $c->likes_count }} j’aime</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">
                        <div class="sidebar__single sidebar__search">
                            <form method="GET" action="{{ route('contents.index') }}" class="sidebar__search-form">
                                <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un contenu…" aria-label="Rechercher">
                                <button type="submit" aria-label="Lancer la recherche"><i class="fa fa-search"></i></button>
                            </form>
                        </div>

                        @if($latestContents->isNotEmpty())
                            <div class="sidebar__single sidebar__post">
                                <h3 class="sidebar__title">Derniers contenus</h3>
                                <ul class="sidebar__post-list list-unstyled">
                                    @foreach($latestContents as $post)
                                        <li>
                                            <div class="sidebar__post-image">
                                                @if($post->getThumbnailDisplayUrl())
                                                    <img src="{{ $post->getThumbnailDisplayUrl() }}" alt="">
                                                @else
                                                    <img src="https://placehold.co/120x120/e8e4dc/5c4a32?text=+" alt="">
                                                @endif
                                            </div>
                                            <div class="sidebar__post-content">
                                                <h3>
                                                    <span class="sidebar__post-content-meta"><i class="fa fa-user-circle"></i>Alliance</span>
                                                    <a href="{{ route('contents.show', $post->slug) }}">{{ Str::limit($post->title, 56) }}</a>
                                                </h3>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($sidebarRubriques->isNotEmpty())
                            <div class="sidebar__single sidebar__category">
                                <h3 class="sidebar__title">Rubriques</h3>
                                <ul class="sidebar__category-list list-unstyled">
                                    @foreach($sidebarRubriques as $cat)
                                        <li class="{{ $content->rubrique_id === $cat->id ? 'active' : '' }}">
                                            <a href="{{ route('contents.index', ['rubrique' => $cat->slug]) }}">{{ $cat->name }}<span class="icon-right-arrow"></span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($sidebarTags->isNotEmpty())
                            <div class="sidebar__single sidebar__tags">
                                <h3 class="sidebar__title">Thèmes</h3>
                                <div class="sidebar__tags-list">
                                    @foreach($sidebarTags as $tag)
                                        <a href="{{ route('contents.index') }}">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="sidebar__single sidebar__comments">
                            <h3 class="sidebar__title">À retenir</h3>
                            <ul class="sidebar__comments-list list-unstyled">
                                <li>
                                    <div class="sidebar__comments-icon"><i class="fa fa-comments"></i></div>
                                    <div class="sidebar__comments-text-box">
                                        <p>Retrouvez d’autres enseignements dans la <a href="{{ route('contents.index') }}">liste des contenus</a> ou par <a href="{{ route('series.index') }}">série</a>.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="sidebar__comments-icon"><i class="fa fa-book"></i></div>
                                    <div class="sidebar__comments-text-box">
                                        <p><a href="{{ route('books.index') }}">Découvrez aussi les ouvrages</a> de la Pasteure.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="sidebar__single text-center" style="background:#A86C3C;padding:28px;border-radius:10px;">
                            <h4 style="color:#fff;margin-bottom:8px;">Soutenir le ministère</h4>
                            <p style="color:rgba(255,255,255,0.9);font-size:14px;margin-bottom:14px;">Chaque geste compte pour poursuivre la mission.</p>
                            <button type="button" class="theme-btn btn-style-two" data-bs-toggle="modal" data-bs-target="#donatePartnerModal"><span class="btn-title">Faire un don</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('modals')
    {{-- Hors de .page-wrapper (@stack dans layouts/app) pour que le backdrop Bootstrap ne bloque pas les clics --}}
    <div class="modal fade alliance-content-comments-modal" id="allianceContentCommentsModal" tabindex="-1" aria-labelledby="allianceContentCommentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content alliance-comments-modal-content" style="border-radius:14px;border:none;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="allianceContentCommentsModalLabel"><span id="alliance-comments-modal-title">Commentaires ({{ $commentsCount }})</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body pt-2">
                    <div class="alliance-comments-modal-list mb-4" id="alliance-comments-list-root">
                        @forelse($contentComments as $c)
                            <div class="alliance-comment-modal-row" data-comment-row-id="{{ $c->id }}">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($c->author_name) }}&background=b89968&color=fff&size=96" alt="" class="rounded-circle" width="48" height="48">
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                                            <div>
                                                <strong class="text-uppercase d-block" style="letter-spacing:0.04em;font-size:0.9rem;">{{ $c->author_name }}</strong>
                                                <span class="small text-muted">{{ $c->created_at->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}</span>
                                            </div>
                                            @auth
                                                <button type="button"
                                                    class="btn btn-sm alliance-comment-like-btn {{ in_array($c->id, $likedCommentIds, true) ? 'btn-warning text-dark' : 'btn-outline-secondary' }}"
                                                    data-like-url="{{ route('contents.comments.like', ['slug' => $content->slug, 'comment' => $c]) }}"
                                                    data-comment-id="{{ $c->id }}"
                                                    aria-pressed="{{ in_array($c->id, $likedCommentIds, true) ? 'true' : 'false' }}">
                                                    <i class="fa fa-heart{{ in_array($c->id, $likedCommentIds, true) ? '' : '-o' }}"></i>
                                                    <span class="alliance-like-count">{{ $c->likes_count }}</span>
                                                </button>
                                            @else
                                                <span class="small text-muted">{{ $c->likes_count }} j’aime</span>
                                                <button type="button" class="btn btn-link btn-sm p-0 ms-1 align-baseline alliance-open-otp-for-comments">Se connecter pour aimer</button>
                                            @endauth
                                        </div>
                                        <p class="mb-0 mt-2 text-muted" style="line-height:1.55;">{{ $c->body }}</p>
                                    </div>
                                </div>
                                <hr class="my-3 opacity-25">
                            </div>
                        @empty
                            <p class="text-muted text-center py-4 mb-0" id="alliance-comments-empty-state">Aucun commentaire pour l’instant.</p>
                        @endforelse
                    </div>

                    <div class="alliance-comments-modal-form-wrap border-top pt-4">
                        <h6 class="fw-bold text-uppercase small mb-3" style="letter-spacing:0.08em;">Laisser un commentaire</h6>
                        @auth
                            <form id="alliance-comment-form-ajax" method="POST" action="{{ route('contents.comments.store', $content->slug) }}" data-comments-url="{{ route('contents.comments.store', $content->slug) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold" for="cc-body">Message</label>
                                    <textarea id="cc-body" name="body" class="form-control" rows="4" required minlength="2" maxlength="5000" placeholder="Votre encouragement, question ou partage…">{{ old('body') }}</textarea>
                                </div>
                                <div id="alliance-comment-form-errors" class="text-danger small mb-2 d-none" role="alert"></div>
                                @error('body') <div class="text-danger small mb-2">{{ $message }}</div> @enderror
                                <button type="submit" class="theme-btn btn-style-one" id="alliance-comment-submit"><span class="btn-title">Publier le commentaire</span></button>
                            </form>
                        @else
                            <p class="text-muted mb-3">Comme pour la boutique : connexion ou inscription par <strong>code e-mail</strong> (sans mot de passe). Votre profil est enregistré dans la table <code>users</code> après validation du code.</p>
                            <button type="button" class="theme-btn btn-style-one" data-bs-toggle="modal" data-bs-target="#allianceOtpAuthModal" onclick="sessionStorage.setItem('alliance_open_comments_after_auth','1');"><span class="btn-title">Connexion / créer un compte</span></button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('styles')
<style>
    .alliance-blog-details .blog-details__meta li span.text-muted i { color: var(--theme-color1); margin-right: 6px; }
    .alliance-meta-comments-btn:hover { color: var(--theme-color1) !important; }

    .alliance-blog-details .blog-details__meta .alliance-meta-like-item {
        margin-left: 18px;
        list-style: none;
    }
    .alliance-content-like-pill {
        border-radius: 999px !important;
        padding: 0.4rem 1rem !important;
        font-weight: 600;
        font-size: 0.9rem;
        position: relative;
        z-index: 3;
        cursor: pointer;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        white-space: nowrap;
    }
    .alliance-content-like-pill:focus {
        box-shadow: 0 0 0 3px rgba(200, 146, 42, 0.35);
    }
    .alliance-content-like-pill .alliance-content-like-count-num {
        margin-left: 0.25rem;
        font-weight: 800;
    }
    .alliance-content-like-pill.alliance-async-busy,
    .alliance-comment-like-btn.alliance-async-busy {
        pointer-events: none;
        opacity: 0.88;
    }
    .alliance-content-like-pill .alliance-async-spinner,
    .alliance-comment-like-btn .alliance-async-spinner {
        vertical-align: -0.125em;
    }

    /* Icônes réseaux : glyphes lisibles (évite le ::after du thème + FA6 pour YouTube) */
    .alliance-blog-details .alliance-blog-social.blog-details__social-list a::after {
        display: none !important;
    }
    .alliance-blog-details .alliance-blog-social.blog-details__social-list a {
        background-color: #A86C3C !important;
        color: #fff !important;
        overflow: visible;
    }
    .alliance-blog-details .alliance-blog-social.blog-details__social-list a:hover {
        background-color: #a67822 !important;
        color: #fff !important;
    }
    .alliance-blog-details .alliance-blog-social.blog-details__social-list a i {
        position: relative;
        z-index: 1;
        font-size: 1.05rem;
        line-height: 1;
    }

    .alliance-content-comments-modal { z-index: 1060; }

    /* Lecteur vidéo : photo dédiée en fond (cadre autour du 16:9) */
    .alliance-content-video-frame {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
    }
    .alliance-content-video-frame__bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        filter: brightness(0.5);
    }
    .alliance-content-video-frame__player {
        position: relative;
        z-index: 1;
        padding: clamp(10px, 2.5vw, 28px);
    }
    .alliance-content-video-frame__player > div {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
    }

@include('partials.alliance-series-episode-card-styles')

    .alliance-comments-modal-content { box-shadow: 0 20px 60px rgba(0,0,0,0.12); }
    .alliance-comment-like-btn.btn-warning { border-color: #A86C3C; }
    .alliance-content-comments-preview .comment-one__title { font-size: 1.35rem; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrf = document.querySelector('meta[name="csrf-token"]');
    var token = csrf ? csrf.getAttribute('content') : '';

    try {
        if (sessionStorage.getItem('alliance_open_comments_after_auth') === '1') {
            sessionStorage.removeItem('alliance_open_comments_after_auth');
            var commentsModal = document.getElementById('allianceContentCommentsModal');
            if (commentsModal && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(commentsModal).show();
            }
        }
    } catch (e) {}

    function openOtpFromCommentLike() {
        var cm = document.getElementById('allianceContentCommentsModal');
        if (cm && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bootstrap.Modal.getInstance(cm)?.hide();
        }
        sessionStorage.setItem('alliance_open_comments_after_auth', '1');
        setTimeout(function () {
            var om = document.getElementById('allianceOtpAuthModal');
            if (om && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(om).show();
            }
        }, 400);
    }

    document.querySelectorAll('.alliance-open-otp-for-comments').forEach(function (link) {
        link.addEventListener('click', function () { openOtpFromCommentLike(); });
    });

    function setAllianceAsyncLoading(btn, on) {
        if (!btn) return;
        btn.classList.toggle('alliance-async-busy', !!on);
        btn.disabled = !!on;
        btn.setAttribute('aria-busy', on ? 'true' : 'false');
        var sp = btn.querySelector('.alliance-async-spinner');
        if (on) {
            if (!sp) {
                sp = document.createElement('span');
                sp.className = 'spinner-border spinner-border-sm alliance-async-spinner me-1';
                sp.setAttribute('role', 'status');
                sp.innerHTML = '<span class="visually-hidden">Chargement…</span>';
                btn.insertBefore(sp, btn.firstChild);
            }
            sp.classList.remove('d-none');
        } else if (sp) {
            sp.classList.add('d-none');
        }
    }

    var commentsModalEl = document.getElementById('allianceContentCommentsModal');
    if (commentsModalEl) {
        commentsModalEl.addEventListener('click', function (e) {
            var btn = e.target.closest('.alliance-comment-like-btn');
            if (!btn || !commentsModalEl.contains(btn)) return;
            var url = btn.getAttribute('data-like-url');
            if (!url) return;
            setAllianceAsyncLoading(btn, true);
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: '{}',
                credentials: 'same-origin'
            }).then(function (r) {
                if (r.status === 401) {
                    openOtpFromCommentLike();
                    return Promise.reject();
                }
                return r.json();
            }).then(function (data) {
                if (!data || typeof data.count !== 'number') return;
                var id = btn.getAttribute('data-comment-id');
                var cnt = btn.querySelector('.alliance-like-count');
                if (cnt) cnt.textContent = data.count;
                var icon = btn.querySelector('i');
                if (data.liked) {
                    btn.classList.remove('btn-outline-secondary');
                    btn.classList.add('btn-warning', 'text-dark');
                    btn.setAttribute('aria-pressed', 'true');
                    if (icon) { icon.className = 'fa fa-heart'; }
                } else {
                    btn.classList.add('btn-outline-secondary');
                    btn.classList.remove('btn-warning', 'text-dark');
                    btn.setAttribute('aria-pressed', 'false');
                    if (icon) { icon.className = 'fa fa-heart-o'; }
                }
                document.querySelectorAll('.alliance-like-count-preview[data-comment-id="' + id + '"]').forEach(function (el) {
                    el.textContent = data.count + ' j’aime';
                });
            }).catch(function () {})
            .finally(function () { setAllianceAsyncLoading(btn, false); });
        });
    }

    function escHtml(s) {
        var d = document.createElement('div');
        d.textContent = s == null ? '' : String(s);
        return d.innerHTML;
    }

    function updateCommentCounts(n) {
        var label = (Number(n) <= 1) ? 'commentaire' : 'commentaires';
        var metaN = document.getElementById('alliance-comments-count-meta');
        var metaL = document.getElementById('alliance-comments-label-meta');
        var prevN = document.getElementById('alliance-comments-count-preview');
        var prevL = document.getElementById('alliance-comments-label-preview');
        var title = document.getElementById('alliance-comments-modal-title');
        if (metaN) metaN.textContent = n;
        if (metaL) metaL.textContent = label;
        if (prevN) prevN.textContent = n;
        if (prevL) prevL.textContent = label;
        if (title) title.textContent = 'Commentaires (' + n + ')';
    }

    function prependCommentPreview(c) {
        var emptyEl = document.getElementById('alliance-comments-preview-empty');
        var hintEl = document.getElementById('alliance-comments-preview-hint');
        var list = document.getElementById('alliance-comments-preview-list');
        if (!list) return;
        if (emptyEl) emptyEl.classList.add('d-none');
        if (hintEl) hintEl.classList.remove('d-none');
        var body = (c.body == null) ? '' : String(c.body);
        var bodyPreview = body.length > 220 ? body.substring(0, 220) + '…' : body;
        var row = document.createElement('div');
        row.className = 'comment-one__single alliance-comment-preview-item';
        row.innerHTML = '<div class="comment-one__image">' +
            '<img src="https://ui-avatars.com/api/?name=' + encodeURIComponent(c.author_name) + '&background=A86C3C&color=fff&size=80" alt="">' +
            '</div><div class="comment-one__content"><h3>' + escHtml(c.author_name) + '</h3>' +
            '<p>' + escHtml(bodyPreview).split('\n').join('<br>') + '</p>' +
            '<div class="d-flex align-items-center gap-2 flex-wrap">' +
            '<span class="small text-muted">' + escHtml(c.created_label) + '</span>' +
            '<span class="small text-muted">·</span>' +
            '<span class="small text-muted alliance-like-count-preview" data-comment-id="' + c.id + '">' + (c.likes_count || 0) + ' j’aime</span>' +
            '</div></div>';
        list.insertBefore(row, list.firstChild);
        while (list.children.length > 2) {
            list.removeChild(list.lastChild);
        }
    }

    var commentForm = document.getElementById('alliance-comment-form-ajax');
    var commentLikePrefix = @json(url('/contenus/'.$content->slug.'/commentaires'));
    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var errEl = document.getElementById('alliance-comment-form-errors');
            if (errEl) {
                errEl.classList.add('d-none');
                errEl.textContent = '';
            }
            var submitBtn = document.getElementById('alliance-comment-submit');
            var fd = new FormData(commentForm);
            if (window.allianceSetSubmitLoading) window.allianceSetSubmitLoading(submitBtn, true);
            else if (submitBtn) submitBtn.disabled = true;
            fetch(commentForm.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                body: fd,
                credentials: 'same-origin'
            }).then(function (r) {
                return r.text().then(function (text) {
                    var d = {};
                    if (text) {
                        try {
                            d = JSON.parse(text);
                        } catch (e) {
                            d = {
                                success: false,
                                message: r.status === 419
                                    ? 'Session expirée. Rechargez la page.'
                                    : 'Réponse invalide du serveur.',
                            };
                        }
                    }
                    return { r: r, d: d };
                });
            }).then(function (pair) {
                if (pair.r.ok && pair.d.success && pair.d.comment) {
                    if (window.allianceSiteToast) window.allianceSiteToast(pair.d.message || 'Commentaire publié.', 'success');
                    var empty = document.getElementById('alliance-comments-empty-state');
                    if (empty) empty.remove();
                    var root = document.getElementById('alliance-comments-list-root');
                    var c = pair.d.comment;
                    var likeUrl = commentLikePrefix + '/' + c.id + '/like';
                    var row = document.createElement('div');
                    row.className = 'alliance-comment-modal-row';
                    row.setAttribute('data-comment-row-id', c.id);
                    var bodyHtml = escHtml(c.body).split('\n').join('<br>');
                    row.innerHTML = '<div class="d-flex gap-3">' +
                        '<div class="flex-shrink-0"><img src="https://ui-avatars.com/api/?name=' + encodeURIComponent(c.author_name) + '&background=b89968&color=fff&size=96" alt="" class="rounded-circle" width="48" height="48"></div>' +
                        '<div class="flex-grow-1 min-w-0">' +
                        '<div class="d-flex flex-wrap justify-content-between align-items-start gap-2">' +
                        '<div><strong class="text-uppercase d-block" style="letter-spacing:0.04em;font-size:0.9rem;">' + escHtml(c.author_name) + '</strong>' +
                        '<span class="small text-muted">' + escHtml(c.created_label) + '</span></div>' +
                        '<button type="button" class="btn btn-sm alliance-comment-like-btn btn-outline-secondary" data-comment-id="' + c.id + '" aria-pressed="false">' +
                        '<i class="fa fa-heart-o"></i> <span class="alliance-like-count">' + (c.likes_count || 0) + '</span></button>' +
                        '</div>' +
                        '<p class="mb-0 mt-2 text-muted" style="line-height:1.55;">' + bodyHtml + '</p>' +
                        '</div></div><hr class="my-3 opacity-25">';
                    var likeBtnNew = row.querySelector('.alliance-comment-like-btn');
                    if (likeBtnNew) likeBtnNew.setAttribute('data-like-url', likeUrl);
                    if (root) root.insertBefore(row, root.firstChild);
                    var ta = document.getElementById('cc-body');
                    if (ta) ta.value = '';
                    updateCommentCounts(pair.d.comments_count);
                    prependCommentPreview(c);
                } else {
                    var msg = (pair.d && pair.d.message) ? pair.d.message : 'Impossible de publier.';
                    if (pair.d && pair.d.errors && pair.d.errors.body) {
                        msg = Array.isArray(pair.d.errors.body) ? pair.d.errors.body.join(' ') : String(pair.d.errors.body);
                    }
                    if (errEl) {
                        errEl.textContent = msg;
                        errEl.classList.remove('d-none');
                    }
                }
            }).catch(function () {
                if (errEl) {
                    errEl.textContent = 'Erreur réseau. Réessayez.';
                    errEl.classList.remove('d-none');
                }
            }).finally(function () {
                if (window.allianceSetSubmitLoading) window.allianceSetSubmitLoading(submitBtn, false);
                else if (submitBtn) submitBtn.disabled = false;
            });
        });
    }

    @if(session('comment_success'))
    var modalEl = document.getElementById('allianceContentCommentsModal');
    if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
    @endif
});
</script>
@endpush
