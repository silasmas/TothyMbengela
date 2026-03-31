@php
    /** @var \Illuminate\Support\Collection<int, \App\Models\PastorActivityGalleryItem> $items */
    $visibleItems = $items->filter(function (\App\Models\PastorActivityGalleryItem $item) {
        return ($item->isImage() && $item->fileDisplayUrl())
            || ($item->isVideo() && $item->hasDisplayableVideo());
    });
@endphp
@if($visibleItems->isNotEmpty())
    <section class="pastor-activity-gallery mt-5 pt-4 border-top" aria-label="Galerie de l’activité">
        <h4 class="mb-3" style="font-size:1.15rem;font-weight:700;color:#1a1a1a;">Galerie</h4>
        <div class="pastor-activity-gallery__grid">
            @foreach($visibleItems as $item)
                @php
                    $showImage = $item->isImage() && $item->fileDisplayUrl();
                    $showVideo = $item->isVideo() && $item->hasDisplayableVideo();
                @endphp
                @if($showImage || $showVideo)
                    <figure class="pastor-activity-gallery__cell">
                        @if($showImage)
                            <a href="{{ $item->fileDisplayUrl() }}" class="pastor-activity-gallery__link" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $item->fileDisplayUrl() }}" alt="{{ $item->caption ?? $activity->title }}" loading="lazy">
                            </a>
                        @elseif($showVideo)
                            <div class="pastor-activity-gallery__video-wrap">
                                @if($item->youtubeVideoId())
                                    <div class="pastor-activity-gallery__ratio">
                                        <iframe src="https://www.youtube.com/embed/{{ $item->youtubeVideoId() }}" title="{{ $item->caption ?? 'Vidéo' }}" allowfullscreen loading="lazy"></iframe>
                                    </div>
                                @elseif($item->fileDisplayUrl())
                                    <div class="pastor-activity-gallery__ratio">
                                        <video controls playsinline preload="metadata" src="{{ $item->fileDisplayUrl() }}"></video>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if($item->caption)
                            <figcaption class="pastor-activity-gallery__caption">{{ $item->caption }}</figcaption>
                        @endif
                    </figure>
                @endif
            @endforeach
        </div>
    </section>
@endif
