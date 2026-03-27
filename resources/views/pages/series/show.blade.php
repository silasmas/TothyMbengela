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

    <!-- Series Detail -->
    <section class="blog-details">
        <div class="auto-container">
            <!-- Description -->
            @if($series->description)
                <div class="row mb-5">
                    <div class="col-lg-8 mx-auto text-center">
                        <p style="font-size:17px;color:#555;">{{ $series->description }}</p>
                        <div class="post-meta mt-2">
                            <ul>
                                @if($series->rubrique)
                                    <li><i class="far fa-folder-open"></i> {{ $series->rubrique->name }}</li>
                                @endif
                                <li><i class="far fa-list-alt"></i> {{ $series->contents->count() }} épisode{{ $series->contents->count() > 1 ? 's' : '' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Épisodes -->
            @if($series->contents->isEmpty())
                <div class="text-center py-5">
                    <h4>Aucun épisode dans cette série pour le moment.</h4>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        @foreach($series->contents as $index => $content)
                        <a href="{{ route('contents.show', $content->slug) }}" class="d-flex align-items-center p-3 mb-3" style="border-radius:8px;border:1px solid #eee;text-decoration:none;color:inherit;transition:box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
                            <span style="width:40px;height:40px;background:#C8922A;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:15px;flex-shrink:0;margin-right:15px;">{{ $index + 1 }}</span>
                            @if($content->getThumbnailDisplayUrl())
                                <img src="{{ $content->getThumbnailDisplayUrl() }}" alt="" style="width:100px;height:65px;object-fit:cover;border-radius:6px;margin-right:15px;flex-shrink:0;">
                            @else
                                <div style="width:100px;height:65px;background:#f0f0f0;border-radius:6px;margin-right:15px;flex-shrink:0;"></div>
                            @endif
                            <div style="min-width:0;flex:1;">
                                <h5 style="margin:0 0 4px;font-size:16px;">{{ $content->title }}</h5>
                                @if($content->excerpt)
                                    <p style="margin:0;font-size:13px;color:#888;">{{ Str::limit($content->excerpt, 80) }}</p>
                                @endif
                                <div style="font-size:12px;color:#aaa;margin-top:4px;">
                                    {{ match($content->type) { 'video' => 'Vidéo', 'audio' => 'Audio', 'podcast' => 'Podcast', 'article' => 'Article', default => $content->type } }}
                                    @if($content->published_at)
                                        &middot; {{ $content->published_at->format('d/m/Y') }}
                                    @endif
                                    @if($content->duration_seconds)
                                        &middot; {{ gmdate('i:s', $content->duration_seconds) }}
                                    @endif
                                </div>
                            </div>
                            <i class="fa fa-chevron-right" style="color:#ccc;flex-shrink:0;"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
