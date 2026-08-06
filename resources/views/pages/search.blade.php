@extends('layouts.app')

@section('page_banner_title', 'Recherche')

@section('page_banner_breadcrumbs')
    <li>Résultats</li>
@endsection

@section('content')

    <section class="contact-details">
        <div class="auto-container">
            <div class="sec-title mb-4">
                <form method="GET" action="{{ route('search') }}" class="row g-2 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label small fw-bold">Rechercher sur tout le site</label>
                        <input type="search" name="q" class="form-control form-control-lg" value="{{ $q }}" placeholder="Contenus, livres, séries, agenda…" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="theme-btn btn-style-one w-100"><span class="btn-title">Rechercher</span></button>
                    </div>
                </form>
            </div>

            @if($q === '')
                <p class="text-muted">Saisissez un mot-clé pour lancer une recherche.</p>
            @else
                @php
                    $total = $contents->count() + $books->count() + $series->count() + $activities->count();
                @endphp
                <p class="mb-4"><strong>{{ $total }}</strong> résultat(s) pour « {{ $q }} »</p>

                @if($total === 0)
                    <p>Aucun résultat. Essayez d’autres termes ou parcourez les <a href="{{ route('contents.index') }}">contenus</a>, l’<a href="{{ route('pastor-activities.index') }}">agenda</a> et la <a href="{{ route('books.index') }}">boutique</a>.</p>
                @else
                    @if($contents->isNotEmpty())
                        <h3 class="mt-4 mb-3" style="font-size:1.25rem;color:#A86C3C;">Contenus</h3>
                        <ul class="list-unstyled mb-5">
                            @foreach($contents as $c)
                                <li class="mb-2 pb-2 border-bottom">
                                    <a href="{{ route('contents.show', $c->slug) }}">{{ $c->title }}</a>
                                    @if($c->rubrique)
                                        <small class="text-muted"> — {{ $c->rubrique->name }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if($books->isNotEmpty())
                        <h3 class="mt-4 mb-3" style="font-size:1.25rem;color:#A86C3C;">Livres</h3>
                        <ul class="list-unstyled mb-5">
                            @foreach($books as $b)
                                <li class="mb-2 pb-2 border-bottom">
                                    <a href="{{ route('books.show', $b->slug) }}">{{ $b->title }}</a>
                                    @if($b->price)
                                        <small class="text-muted"> — {{ number_format((float) $b->price, 2, ',', ' ') }} {{ $b->currency ?? 'USD' }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if($series->isNotEmpty())
                        <h3 class="mt-4 mb-3" style="font-size:1.25rem;color:#A86C3C;">Séries</h3>
                        <ul class="list-unstyled mb-5">
                            @foreach($series as $s)
                                <li class="mb-2 pb-2 border-bottom">
                                    <a href="{{ route('series.show', $s->slug) }}">{{ $s->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if($activities->isNotEmpty())
                        <h3 class="mt-4 mb-3" style="font-size:1.25rem;color:#A86C3C;">Agenda</h3>
                        <ul class="list-unstyled">
                            @foreach($activities as $a)
                                <li class="mb-2 pb-2 border-bottom">
                                    <a href="{{ route('pastor-activities.show', $a) }}">{{ $a->title }}</a>
                                    @if($a->starts_at)
                                        <small class="text-muted"> — {{ $a->starts_at->locale('fr')->isoFormat('D MMM YYYY') }}</small>
                                    @endif
                                    @if($a->location)
                                        <small class="text-muted"> — {{ $a->location }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endif
            @endif
        </div>
    </section>

@endsection
