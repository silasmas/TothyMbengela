@extends('layouts.app')

@section('page_banner_title', $series->title)

@section('page_banner_image')
{{ $series->thumbnail_path ? Storage::disk('public')->url($series->thumbnail_path) : 'https://images.unsplash.com/photo-1504052434569-70ad5836ab65?w=1920&q=80' }}
@endsection

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('series.index') }}">Séries</a></li>
    <li>{{ Str::limit($series->title, 48) }}</li>
@endsection

@section('content')

@php
    $seriesHero = $series->thumbnail_path ? Storage::disk('public')->url($series->thumbnail_path) : null;
    $episodeCount = $series->contents->count();
@endphp

    <section class="blog-details alliance-blog-details alliance-series-landing pt-2 pb-5">
        <div class="auto-container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="blog-details__left">
                        @if($seriesHero)
                            <div class="blog-details__img mb-4">
                                <img src="{{ $seriesHero }}" alt="{{ $series->title }}">
                                @if($episodeCount > 0)
                                    <div class="blog-details__date">
                                        <span class="day">{{ str_pad((string) $episodeCount, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="month">{{ $episodeCount <= 1 ? 'ÉP.' : 'ÉPIS.' }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="blog-details__content">
                            <ul class="list-unstyled blog-details__meta mb-3">
                                @if($series->rubrique)
                                    <li>
                                        <a href="{{ route('contents.index', ['rubrique' => $series->rubrique->slug]) }}">
                                            <i class="fa fa-folder-open"></i> {{ $series->rubrique->name }}
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <span class="text-muted" style="cursor:default;">
                                        <i class="fa fa-list-alt"></i> {{ $episodeCount }} épisode{{ $episodeCount > 1 ? 's' : '' }}
                                    </span>
                                </li>
                                <li>
                                    <a href="{{ route('series.index') }}"><i class="fa fa-th-large"></i> Toutes les séries</a>
                                </li>
                            </ul>

                            <h3 class="blog-details__title">{{ $series->title }}</h3>

                            @if($series->description)
                                <div class="blog-details__text-2">
                                    {!! nl2br(e($series->description)) !!}
                                </div>
                            @endif

                            @if($series->contents->isEmpty())
                                <p class="text-muted mt-4 mb-0">Aucun épisode publié dans cette série pour le moment.</p>
                            @else
                                <section class="alliance-series-episodes mt-4 mb-2" aria-label="Épisodes de la série">
                                    <h4 class="alliance-series-episodes__heading">
                                        Épisodes — <span class="alliance-series-episodes__series-name">{{ mb_strtoupper($series->title) }}</span>
                                    </h4>
                                    <div class="alliance-series-episodes__list">
                                        @foreach($series->contents as $index => $content)
                                            <a href="{{ route('contents.show', $content->slug) }}" class="alliance-series-episode-card">
                                                <span class="alliance-series-episode-card__num" aria-hidden="true">{{ $index + 1 }}</span>
                                                <span class="alliance-series-episode-card__thumb">
                                                    @if($content->getThumbnailDisplayUrl())
                                                        <img src="{{ $content->getThumbnailDisplayUrl() }}" alt="">
                                                    @else
                                                        <span class="alliance-series-episode-card__thumb-fallback"></span>
                                                    @endif
                                                </span>
                                                <span class="alliance-series-episode-card__body">
                                                    <span class="alliance-series-episode-card__title">{{ mb_strtoupper($content->title) }}</span>
                                                    <span class="alliance-series-episode-card__date">
                                                        {{ match($content->type) { 'video' => 'Vidéo', 'audio' => 'Audio', 'podcast' => 'Podcast', 'article' => 'Article', default => ucfirst($content->type) } }}
                                                        @if($content->published_at)
                                                            &middot; {{ $content->published_at->locale('fr')->isoFormat('D MMM YYYY') }}
                                                        @endif
                                                        @if($content->duration_seconds)
                                                            &middot; {{ gmdate('i:s', $content->duration_seconds) }}
                                                        @endif
                                                    </span>
                                                    @if($content->excerpt)
                                                        <span class="alliance-series-episode-card__excerpt">{{ Str::limit($content->excerpt, 120) }}</span>
                                                    @endif
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        </div>

                        <div class="blog-details__bottom mt-4">
                            <p class="blog-details__tags">
                                <span>Navigation</span>
                                <a href="{{ route('contents.index') }}">Contenus</a>
                                <a href="{{ route('series.index') }}">Séries</a>
                                @if($series->rubrique)
                                    <a href="{{ route('contents.index', ['rubrique' => $series->rubrique->slug]) }}">{{ $series->rubrique->name }}</a>
                                @endif
                            </p>
                            <div class="blog-details__social-list alliance-blog-social">
                                <a href="https://www.youtube.com/@tothy_mbengela" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                                <a href="{{ route('contact.create') }}" aria-label="Contact"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                <a href="{{ route('donate.create') }}" aria-label="Soutenir"><i class="fa fa-heart" aria-hidden="true"></i></a>
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
                                    @foreach($sidebarRubriques as $r)
                                        <li><a href="{{ route('contents.index', ['rubrique' => $r->slug]) }}">{{ $r->name }}</a></li>
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

                        <div class="sidebar__single text-center" style="background:#C8922A;padding:28px;border-radius:10px;">
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

@push('styles')
<style>
@include('partials.alliance-series-episode-card-styles')
    .alliance-blog-details .blog-details__meta li a { color: #777; }
    .alliance-blog-details .blog-details__meta li a:hover { color: var(--theme-color1); }
    .alliance-series-landing .blog-details__social-list a::after { display: none !important; }
    .alliance-series-landing .alliance-blog-social.blog-details__social-list a {
        background-color: #c8922a !important;
        color: #fff !important;
    }
    .alliance-series-landing .alliance-blog-social.blog-details__social-list a:hover {
        background-color: #a67822 !important;
        color: #fff !important;
    }
</style>
@endpush
