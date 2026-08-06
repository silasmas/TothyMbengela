@extends('layouts.app')

@section('page_banner_title', 'Séries')

@section('page_banner_breadcrumbs')
    <li>Séries</li>
@endsection

@section('content')

    <section class="blog-details alliance-series-index-list pt-5 pb-5">
        <div class="auto-container">
            <div class="sec-title text-center mb-5">
                <span class="sub-title">Enseignements</span>
                <h2>Nos séries</h2>
                <p class="text-muted mb-0" style="max-width:640px;margin-left:auto;margin-right:auto;">
                    Parcourez les playlists et collections : chaque carte mène au détail des épisodes.
                </p>
            </div>

            @if($series->isEmpty())
                <div class="text-center py-5">
                    <h4>Aucune série disponible pour le moment.</h4>
                </div>
            @else
                <div class="alliance-series-stack d-flex flex-column gap-4">
                    @foreach($series as $s)
                        @php
                            $coverUrl = null;
                            if ($s->thumbnail_path) {
                                $coverUrl = Storage::disk('public')->url($s->thumbnail_path);
                            } else {
                                $firstEp = $s->contents->first();
                                $coverUrl = $firstEp?->getThumbnailDisplayUrl();
                            }
                            if (! $coverUrl) {
                                $coverUrl = asset('assets/images/resource/news-1.jpg');
                            }
                        @endphp
                        <article class="alliance-series-stack-card wow fadeInUp">
                            <div class="row g-0 align-items-stretch rounded-3 overflow-hidden border shadow-sm bg-white">
                                <div class="col-md-5 col-lg-4">
                                    <a href="{{ route('series.show', $s->slug) }}" class="d-block alliance-series-stack-card__media h-100">
                                        <img src="{{ $coverUrl }}" alt="{{ $s->title }}" class="w-100 h-100" style="object-fit: cover; min-height: 240px;">
                                    </a>
                                </div>
                                <div class="col-md-7 col-lg-8 p-4 p-lg-5 d-flex flex-column">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <span class="badge rounded-pill text-bg-light border">{{ $s->rubrique?->name ?? 'Série' }}</span>
                                        <span class="text-muted small">
                                            <i class="fa fa-list-ul me-1"></i>{{ $s->contents_count }} épisode{{ $s->contents_count > 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                    <h3 class="h4 fw-bold mb-3">
                                        <a href="{{ route('series.show', $s->slug) }}" class="text-dark text-decoration-none alliance-series-stack-card__title">
                                            {{ $s->title }}
                                        </a>
                                    </h3>
                                    @if($s->description)
                                        <p class="text-muted flex-grow-1 mb-4" style="line-height:1.65;">{{ Str::limit($s->description, 280) }}</p>
                                    @else
                                        <p class="text-muted flex-grow-1 mb-4 small">Découvrez les épisodes de cette série.</p>
                                    @endif
                                    <div class="mt-auto">
                                        <a href="{{ route('series.show', $s->slug) }}" class="theme-btn btn-style-one">
                                            <span class="btn-title">Voir la série <i class="fa fa-long-arrow-alt-right ms-1"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5 pt-2">
                    {{ $series->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection

@push('styles')
<style>
    .alliance-series-index-list {
        padding-top: clamp(2.25rem, 5vw, 3.75rem) !important;
    }
    .alliance-series-stack-card__title:hover {
        color: var(--theme-color1, #A86C3C) !important;
    }
    .alliance-series-stack-card__media img {
        transition: transform 0.35s ease;
    }
    .alliance-series-stack-card:hover .alliance-series-stack-card__media img {
        transform: scale(1.03);
    }
    .alliance-series-stack {
        gap: 1.5rem !important;
    }
</style>
@endpush
