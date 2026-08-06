@php
    $highlightRubriqueId = $highlightRubriqueId ?? null;
    /** @var string $sidebarHubMode full = sidebar complète ; pastor_detail = recherche + autres activités uniquement */
    $sidebarHubMode = $sidebarHubMode ?? 'full';
@endphp
<div class="sidebar">
    <div class="sidebar__single sidebar__search">
        <form method="GET" action="{{ route('contents.index') }}" class="sidebar__search-form">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un contenu…" aria-label="Rechercher">
            <button type="submit" aria-label="Lancer la recherche"><i class="fa fa-search"></i></button>
        </form>
    </div>

    @isset($sidebarPastorActivities)
        @if($sidebarPastorActivities->isNotEmpty())
            <div class="sidebar__single sidebar__post">
                <h3 class="sidebar__title">Autres activités</h3>
                <ul class="sidebar__post-list list-unstyled">
                    @foreach($sidebarPastorActivities as $pa)
                        <li>
                            <div class="sidebar__post-image">
                                @if($pa->posterDisplayUrl())
                                    <img src="{{ $pa->posterDisplayUrl() }}" alt="">
                                @else
                                    <img src="https://placehold.co/120x120/e8e4dc/5c4a32?text=+" alt="">
                                @endif
                            </div>
                            <div class="sidebar__post-content">
                                <h3>
                                    <span class="sidebar__post-content-meta"><i class="fa fa-calendar-check"></i>Agenda</span>
                                    <a href="{{ route('pastor-activities.show', $pa) }}">{{ Str::limit($pa->title, 56) }}</a>
                                </h3>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endisset

    @if($sidebarHubMode === 'full')
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
                        <li class="{{ (int) $highlightRubriqueId === (int) $cat->id ? 'active' : '' }}">
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
                    <div class="sidebar__comments-icon"><i class="fa fa-calendar-alt"></i></div>
                    <div class="sidebar__comments-text-box">
                        <p>Toutes les dates sur la <a href="{{ route('pastor-activities.index') }}">page Agenda</a>.</p>
                    </div>
                </li>
                <li>
                    <div class="sidebar__comments-icon"><i class="fa fa-comments"></i></div>
                    <div class="sidebar__comments-text-box">
                        <p>Enseignements dans la <a href="{{ route('contents.index') }}">liste des contenus</a> ou par <a href="{{ route('series.index') }}">série</a>.</p>
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
    @endif
</div>
