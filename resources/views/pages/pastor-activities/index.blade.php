@extends('layouts.app')

@section('page_banner_title', 'Activités de la pasteure')

@section('page_banner_breadcrumbs')
    <li>Agenda</li>
@endsection

@section('content')
<section class="blog-details alliance-blog-details alliance-pastor-agenda-hub pt-2 pb-5">
    <div class="auto-container">
        <div class="row">
            <div class="col-12">
                <div class="blog-details__left">
                    <div class="sec-title mb-4">
                        <span class="sub-title" style="color:#A86C3C;letter-spacing:0.12em;">Agenda</span>
                        <h2 class="mb-2">Activités de la pasteure</h2>
                        <p class="text mb-0" style="color:#666;">Prochains rendez-vous, journée en cours et temps forts récents.</p>
                    </div>

                    @if($todayActivities->isNotEmpty())
                        <div class="pastor-agenda-hub-today mb-4 pb-2">
                            <h3 class="pastor-agenda-hub-section-title">Aujourd’hui</h3>
                            @foreach($todayActivities as $activity)
                                @include('partials.pastor-activity-card', ['activity' => $activity])
                            @endforeach
                        </div>
                    @endif

                    <div class="row g-4 align-items-start">
                        <div class="col-md-6">
                            <h3 class="pastor-agenda-hub-col-title">À venir</h3>
                            @forelse($upcomingActivities as $activity)
                                @include('partials.pastor-activity-card', ['activity' => $activity])
                            @empty
                                <p class="text-muted small mb-0">Aucune activité à venir pour l’instant.</p>
                            @endforelse
                        </div>
                        <div class="col-md-6">
                            <h3 class="pastor-agenda-hub-col-title">Récemment</h3>
                            @forelse($pastActivities as $activity)
                                @include('partials.pastor-activity-card', ['activity' => $activity, 'variant' => 'past'])
                            @empty
                                <p class="text-muted small mb-0">Aucune activité passée enregistrée.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
