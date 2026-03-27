@extends('layouts.app')

@section('page_banner_title', 'Partenariats')

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('account.index') }}">Mon compte</a></li>
    <li>Partenariats</li>
@endsection

@section('content')
<section class="about-section" style="padding-top: 50px; padding-bottom: 80px;">
    <div class="auto-container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div class="sec-title mb-0">
                <h2 class="mb-0">Mes partenariats</h2>
            </div>
            <a href="{{ route('account.index') }}" class="theme-btn btn-style-one btn-sm"><span class="btn-title">← Mon compte</span></a>
        </div>

        @if($commitments->isEmpty())
            <p class="text-muted py-5 text-center">Vous n’avez pas encore d’engagement partenaire enregistré.</p>
        @else
            <div class="table-responsive shadow-sm rounded overflow-hidden" style="background:#fff;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Référence</th>
                            <th>Engagement mensuel</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commitments as $c)
                            <tr>
                                <td class="text-nowrap small">{{ $c->created_at->format('d/m/Y H:i') }}</td>
                                <td><code class="small">{{ $c->reference }}</code></td>
                                <td>{{ number_format((float) $c->monthly_amount, 2, ',', ' ') }} {{ $c->currency }}</td>
                                <td><span class="badge bg-secondary">{{ $c->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">{{ $commitments->links() }}</div>
        @endif
    </div>
</section>
@endsection
