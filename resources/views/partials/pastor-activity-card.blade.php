@php
    /** @var \App\Models\PastorActivity $activity */
    $variant = $variant ?? 'default';
    $poster = $activity->posterDisplayUrl();
@endphp
<div class="pastor-activity-card {{ $variant === 'past' ? 'pastor-activity-card--past' : '' }}">
    @if($poster)
        <img class="pastor-activity-card__thumb" src="{{ $poster }}" alt="" loading="lazy">
    @else
        <div class="pastor-activity-card__thumb" aria-hidden="true"></div>
    @endif
    <div class="pastor-activity-card__body">
        <h5><a href="{{ route('pastor-activities.show', $activity) }}">{{ $activity->title }}</a></h5>
        <div class="pastor-activity-card__meta">
            {{ $activity->starts_at->translatedFormat('d M Y, H:i') }}
            @if($activity->ends_at)
                — {{ $activity->ends_at->translatedFormat('H:i') }}
            @endif
            @if($activity->location)
                · {{ $activity->location }}
            @endif
        </div>
        @if($activity->description)
            <p class="pastor-activity-card__excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($activity->description), 140) }}</p>
        @endif
        @if($activity->spot_url)
            <a href="{{ $activity->spot_url }}" class="pastor-agenda-spot" target="_blank" rel="noopener noreferrer">
                <i class="fa fa-play-circle" aria-hidden="true"></i> Voir le spot
            </a>
        @endif
    </div>
</div>
