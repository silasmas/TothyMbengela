@php
    $hasAny = $pastorAgendaToday->isNotEmpty()
        || $pastorAgendaUpcoming->isNotEmpty()
        || $pastorAgendaPast->isNotEmpty();
@endphp
@if($hasAny)
<section class="pastor-agenda-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <span class="sub-title">Agenda</span>
            <h2>Activités de la pasteure</h2>
            <div class="text">Prochains rendez-vous, journée en cours et temps forts récents.</div>
        </div>

        @if($pastorAgendaToday->isNotEmpty())
            @php $firstToday = $pastorAgendaToday->first(); @endphp
            <div class="pastor-agenda-hero wow fadeInUp">
                <div
                    class="pastor-agenda-hero__media"
                    style="@if($firstToday->posterDisplayUrl())background-image:url('{{ $firstToday->posterDisplayUrl() }}')@endif"
                ></div>
                <div class="pastor-agenda-hero__body">
                    <span class="pastor-agenda-badge">Aujourd’hui</span>
                    <h3>{{ $firstToday->title }}</h3>
                    <div class="pastor-agenda-meta">
                        {{ $firstToday->starts_at->translatedFormat('H:i') }}
                        @if($firstToday->ends_at)
                            — {{ $firstToday->ends_at->translatedFormat('H:i') }}
                        @endif
                        @if($firstToday->location)
                            · {{ $firstToday->location }}
                        @endif
                    </div>
                    @if($firstToday->description)
                        <div class="text">{!! nl2br(e($firstToday->description)) !!}</div>
                    @endif
                    <a href="{{ route('pastor-activities.show', $firstToday) }}" class="theme-btn btn-style-one"><span class="btn-title">Détails</span></a>
                    @if($firstToday->spot_url)
                        <a href="{{ $firstToday->spot_url }}" class="theme-btn btn-style-two ms-2" target="_blank" rel="noopener noreferrer"><span class="btn-title">Spot</span></a>
                    @endif
                </div>
            </div>
            @if($pastorAgendaToday->count() > 1)
                <div class="mb-4">
                    @foreach($pastorAgendaToday->skip(1) as $activity)
                        @include('partials.pastor-activity-card', ['activity' => $activity])
                    @endforeach
                </div>
            @endif
        @endif

        <div class="pastor-agenda-columns">
            <div>
                <h4 class="pastor-agenda-col__title">À venir</h4>
                @forelse($pastorAgendaUpcoming as $activity)
                    @include('partials.pastor-activity-card', ['activity' => $activity])
                @empty
                    <p class="text-muted mb-0">Aucune activité annoncée pour le moment.</p>
                @endforelse
            </div>
            <div>
                <h4 class="pastor-agenda-col__title">Récemment</h4>
                @forelse($pastorAgendaPast as $activity)
                    @include('partials.pastor-activity-card', ['activity' => $activity, 'variant' => 'past'])
                @empty
                    <p class="text-muted mb-0">Les activités passées apparaîtront ici.</p>
                @endforelse
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('pastor-activities.index') }}" class="theme-btn btn-style-one"><span class="btn-title">Voir tout l’agenda</span></a>
        </div>
    </div>
</section>
@endif
