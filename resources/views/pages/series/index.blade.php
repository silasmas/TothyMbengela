@extends('layouts.app')

@section('page_banner_title', 'Séries')

@section('page_banner_breadcrumbs')
    <li>Séries</li>
@endsection

@section('content')

    <!-- Series Section -->
    <section class="projects-section">
        <div class="auto-container">
            @if($series->isEmpty())
                <div class="text-center py-5">
                    <h4>Aucune série disponible pour le moment.</h4>
                </div>
            @else
                <div class="row">
                    @foreach($series as $s)
                    <div class="project-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="{{ ($loop->index % 3) * 200 }}ms">
                        <div class="inner-box">
                            <figure class="image">
                                @if($s->thumbnail_path)
                                    <img src="{{ Storage::disk('public')->url($s->thumbnail_path) }}" alt="{{ $s->title }}">
                                @else
                                    <img src="https://placehold.co/500x350/C8922A/ffffff?text={{ urlencode(Str::limit($s->title, 20)) }}" alt="{{ $s->title }}">
                                @endif
                            </figure>
                            <div class="overlay-box">
                                <div class="content">
                                    <span class="cat">{{ $s->rubrique?->name ?? 'Série' }}</span>
                                    <h4 class="title"><a href="{{ route('series.show', $s->slug) }}">{{ $s->title }}</a></h4>
                                    <span class="count">{{ $s->contents_count }} épisode{{ $s->contents_count > 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                        </div>
                        @if($s->description)
                            <div class="mt-2 px-2">
                                <p style="font-size:14px;color:#666;">{{ Str::limit($s->description, 120) }}</p>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $series->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection
