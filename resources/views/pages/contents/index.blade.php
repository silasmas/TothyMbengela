@extends('layouts.app')

@section('page_banner_title', 'Nos contenus')

@section('page_banner_breadcrumbs')
    <li>Contenus</li>
@endsection

@section('content')

    <!-- Contents Section -->
    <section class="news-section">
        <div class="auto-container">

            <!-- Filtres -->
            <div class="row mb-5">
                <div class="col-12">
                    <form method="GET" action="{{ route('contents.index') }}" class="d-flex flex-wrap align-items-center" style="gap:10px;">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher…" class="form-control" style="max-width:200px;">
                        <select name="rubrique" class="form-control" style="max-width:200px;">
                            <option value="">Toutes les rubriques</option>
                            @foreach($rubriques as $r)
                                <option value="{{ $r->slug }}" {{ request('rubrique') === $r->slug ? 'selected' : '' }}>{{ $r->name }}</option>
                            @endforeach
                        </select>
                        <select name="type" class="form-control" style="max-width:180px;">
                            <option value="">Tous les types</option>
                            @foreach($types as $t)
                                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ match($t) { 'video' => 'Vidéo', 'audio' => 'Audio', 'podcast' => 'Podcast', 'article' => 'Article', default => ucfirst($t) } }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="theme-btn btn-style-one"><span class="btn-title">Filtrer</span></button>
                        @if(request()->hasAny(['q', 'rubrique', 'type']))
                            <a href="{{ route('contents.index') }}" class="theme-btn btn-style-two"><span class="btn-title">Réinitialiser</span></a>
                        @endif
                    </form>
                </div>
            </div>

            @if($contents->isEmpty())
                <div class="text-center py-5">
                    <h4>Aucun contenu trouvé.</h4>
                    <p>Essayez de modifier vos critères de recherche.</p>
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
                                <span class="date">{{ $content->published_at?->format('d M Y') ?? '—' }}</span>
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
