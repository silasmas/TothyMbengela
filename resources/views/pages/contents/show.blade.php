@extends('layouts.app')

@section('page_banner_title', $content->title)

@section('page_banner_image')
{{ $content->getThumbnailDisplayUrl() ?? 'https://images.unsplash.com/photo-1504052434569-70ad5836ab65?w=1920&q=80' }}
@endsection

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('contents.index') }}">Contenus</a></li>
    @if($content->rubrique)
        <li><a href="{{ route('contents.index', ['rubrique' => $content->rubrique->slug]) }}">{{ $content->rubrique->name }}</a></li>
    @endif
    <li>{{ Str::limit($content->title, 40) }}</li>
@endsection

@section('content')

    <!-- Content Detail -->
    <section class="blog-details">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="blog-detail">
                        <div class="inner-box">
                            <!-- Meta -->
                            <div class="post-meta mb-3">
                                <ul>
                                    <li><i class="far fa-calendar-alt"></i> {{ $content->published_at?->translatedFormat('d F Y') ?? '—' }}</li>
                                    <li><i class="far fa-folder-open"></i> {{ $content->rubrique?->name ?? 'Général' }}</li>
                                    <li>
                                        <i class="far fa-play-circle"></i>
                                        {{ match($content->type) { 'video' => 'Vidéo', 'audio' => 'Audio', 'podcast' => 'Podcast', 'article' => 'Article', default => $content->type } }}
                                    </li>
                                    @if($content->duration_seconds)
                                        <li><i class="far fa-clock"></i> {{ gmdate('H:i:s', $content->duration_seconds) }}</li>
                                    @endif
                                </ul>
                            </div>

                            @if($content->series)
                                <div class="mb-3">
                                    <a href="{{ route('series.show', $content->series->slug) }}" class="theme-btn btn-style-two" style="padding:5px 15px;font-size:13px;">
                                        <span class="btn-title">Série : {{ $content->series->title }}</span>
                                    </a>
                                </div>
                            @endif

                            <!-- Lecteur vidéo YouTube -->
                            @if($content->youtube_video_id)
                                <div class="video-box mb-4">
                                    <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:8px;">
                                        <iframe src="https://www.youtube.com/embed/{{ $content->youtube_video_id }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                                    </div>
                                </div>
                            @elseif($content->getThumbnailDisplayUrl())
                                <div class="image mb-4">
                                    <img src="{{ $content->getThumbnailDisplayUrl() }}" alt="{{ $content->title }}" style="width:100%;border-radius:8px;">
                                </div>
                            @endif

                            <!-- Extrait -->
                            @if($content->excerpt)
                                <blockquote class="blockquote-one">
                                    <p>{{ $content->excerpt }}</p>
                                </blockquote>
                            @endif

                            <!-- Corps du texte -->
                            @if($content->body)
                                <div class="text">
                                    {!! nl2br(e($content->body)) !!}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Épisodes de la série -->
                    @if($content->series && $content->series->contents->count() > 1)
                    <div class="related-posts mt-5">
                        <div class="sec-title">
                            <h3>Dans la même série : {{ $content->series->title }}</h3>
                        </div>
                        <div class="list-style-two">
                            @foreach($content->series->contents as $index => $episode)
                            <div class="d-flex align-items-center p-3 mb-2 {{ $episode->id === $content->id ? 'bg-light' : '' }}" style="border-radius:8px;border:1px solid #eee;">
                                <span style="width:35px;height:35px;background:#C8922A;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:14px;flex-shrink:0;margin-right:15px;">{{ $index + 1 }}</span>
                                @if($episode->getThumbnailDisplayUrl())
                                    <img src="{{ $episode->getThumbnailDisplayUrl() }}" alt="" style="width:80px;height:50px;object-fit:cover;border-radius:6px;margin-right:15px;flex-shrink:0;">
                                @endif
                                <div style="min-width:0;flex:1;">
                                    <h5 style="margin:0;font-size:15px;">
                                        <a href="{{ route('contents.show', $episode->slug) }}" style="{{ $episode->id === $content->id ? 'color:#C8922A;' : '' }}">
                                            {{ $episode->title }}
                                        </a>
                                    </h5>
                                    <small class="text-muted">{{ $episode->published_at?->format('d/m/Y') }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-md-12">
                    <aside class="sidebar">
                        <!-- Recherche -->
                        <div class="sidebar-widget search-box">
                            <form method="GET" action="{{ route('contents.index') }}">
                                <div class="form-group">
                                    <input type="search" name="q" placeholder="Rechercher…" required>
                                    <button type="submit"><span class="icon fa fa-search"></span></button>
                                </div>
                            </form>
                        </div>

                        <!-- Contenus similaires -->
                        @if($related->isNotEmpty())
                        <div class="sidebar-widget popular-posts">
                            <div class="sidebar-title"><h4>Contenus similaires</h4></div>
                            @foreach($related as $r)
                            <article class="post">
                                <figure class="post-thumb">
                                    <a href="{{ route('contents.show', $r->slug) }}">
                                        @if($r->getThumbnailDisplayUrl())
                                            <img src="{{ $r->getThumbnailDisplayUrl() }}" alt="{{ $r->title }}">
                                        @else
                                            <img src="https://placehold.co/100x100/e2e8f0/64748b?text=—" alt="">
                                        @endif
                                    </a>
                                </figure>
                                <div class="post-info">
                                    {{ $r->published_at?->format('d M Y') }}
                                </div>
                                <h5><a href="{{ route('contents.show', $r->slug) }}">{{ Str::limit($r->title, 50) }}</a></h5>
                            </article>
                            @endforeach
                        </div>
                        @endif

                        <!-- CTA Don -->
                        <div class="sidebar-widget" style="background:#C8922A;padding:30px;border-radius:8px;text-align:center;">
                            <h4 style="color:#fff;margin-bottom:10px;">Soutenez le ministère</h4>
                            <p style="color:rgba(255,255,255,0.85);font-size:14px;">Votre soutien compte pour continuer à partager la Parole.</p>
                            <a href="#" class="theme-btn btn-style-two" style="margin-top:10px;" data-bs-toggle="modal" data-bs-target="#donatePartnerModal"><span class="btn-title">Faire un don</span></a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

@endsection
