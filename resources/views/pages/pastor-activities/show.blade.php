@extends('layouts.app')

@php
    $ytId = $activity->spotYoutubeVideoId();
    $hasYoutube = filled($ytId);
    $posterUrl = $activity->posterDisplayUrl();
    $videoFrameBg = $posterUrl ?? asset('assets/images/Im3.jpg.jpeg');
@endphp

@section('page_banner_title')
    {{ \Illuminate\Support\Str::limit($activity->title, 72) }}
@endsection

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('pastor-activities.index') }}">Agenda</a></li>
    <li>{{ \Illuminate\Support\Str::limit($activity->title, 40) }}</li>
@endsection

@section('content')
<section class="blog-details alliance-blog-details alliance-pastor-activity-detail pt-2 pb-5">
    <div class="auto-container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="blog-details__left">
                    @if($hasYoutube)
                        <div class="video-box alliance-content-video-frame mb-4">
                            <div class="alliance-content-video-frame__bg" style="background-image: url('{{ $videoFrameBg }}');" role="presentation"></div>
                            <div class="alliance-content-video-frame__player">
                                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:10px;">
                                    <iframe src="https://www.youtube.com/embed/{{ $ytId }}" title="{{ $activity->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                                </div>
                            </div>
                        </div>
                    @elseif($posterUrl)
                        <div class="blog-details__img mb-4">
                            <img src="{{ $posterUrl }}" alt="{{ $activity->title }}">
                        </div>
                    @endif

                    <div class="blog-details__content">
                        <ul class="list-unstyled blog-details__meta">
                            <li>
                                <span class="text-muted" style="cursor:default;"><i class="fa fa-calendar-check"></i> Agenda</span>
                            </li>
                            <li>
                                <span class="text-muted" style="cursor:default;">
                                    <i class="fa fa-clock-o"></i>
                                    {{ $activity->starts_at->locale('fr')->isoFormat('D MMM YYYY, HH:mm') }}
                                    @if($activity->ends_at)
                                        — {{ $activity->ends_at->format('H:i') }}
                                    @endif
                                </span>
                            </li>
                            @if($activity->location)
                                <li>
                                    <span class="text-muted" style="cursor:default;"><i class="fa fa-map-marker"></i> {{ $activity->location }}</span>
                                </li>
                            @endif
                        </ul>

                        <h3 class="blog-details__title">{{ $activity->title }}</h3>

                        @if($activity->description)
                            <div class="blog-details__text-2" style="line-height:1.7;">{!! nl2br(e($activity->description)) !!}</div>
                        @endif

                        @if($activity->spot_url || $activity->spotImageDisplayUrl())
                            <div class="pastor-activity-detail__spot mt-4">
                                <h5 class="mb-3">Spot</h5>
                                @if($activity->spotImageDisplayUrl() && ! $hasYoutube)
                                    <img src="{{ $activity->spotImageDisplayUrl() }}" alt="">
                                @endif
                                @if($activity->spot_url)
                                    <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                                        <a href="{{ $activity->spot_url }}" class="theme-btn btn-style-one" target="_blank" rel="noopener noreferrer">
                                            <span class="btn-title"><i class="fa fa-youtube-play me-2"></i>{{ $hasYoutube ? 'Ouvrir sur YouTube' : 'Voir le spot' }}</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @include('partials.pastor-activity-gallery', [
                            'activity' => $activity,
                            'items' => $activity->galleryItems,
                        ])
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('pastor-activities.index') }}" class="theme-btn btn-style-two">
                            <span class="btn-title">← Retour à l’agenda</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                @include('partials.sidebar-content-hub', ['sidebarHubMode' => 'pastor_detail'])
            </div>
        </div>
    </div>
</section>
@endsection
