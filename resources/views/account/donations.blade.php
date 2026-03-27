@extends('layouts.app')

@section('page_banner_title', 'Mes dons')

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('account.index') }}">Mon compte</a></li>
    <li>Dons</li>
@endsection

@section('content')
<section class="about-section" style="padding-top: 50px; padding-bottom: 80px;">
    <div class="auto-container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div class="sec-title mb-0">
                <h2 class="mb-0">Mes dons</h2>
                <p class="text-muted small mb-0">Dons enregistrés avec l’adresse <strong>{{ Auth::user()->email }}</strong>.</p>
            </div>
            <a href="{{ route('account.index') }}" class="theme-btn btn-style-one btn-sm"><span class="btn-title">← Mon compte</span></a>
        </div>

        @if($donations->isEmpty())
            <p class="text-muted py-5 text-center">Aucun don n’est associé à votre e-mail. Si vous avez donné avec une autre adresse, ils n’apparaîtront pas ici.</p>
        @else
            <div class="table-responsive shadow-sm rounded overflow-hidden" style="background:#fff;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Référence</th>
                            <th>Montant</th>
                            <th>Fréquence</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donations as $d)
                            <tr>
                                <td class="text-nowrap small">{{ $d->created_at->format('d/m/Y H:i') }}</td>
                                <td><code class="small">{{ $d->reference }}</code></td>
                                <td>{{ number_format((float) $d->amount, 2, ',', ' ') }} {{ $d->currency }}</td>
                                <td>{{ $d->frequency === 'monthly' ? 'Mensuel' : 'Unique' }}</td>
                                <td><span class="badge bg-secondary">{{ $d->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">{{ $donations->links() }}</div>
        @endif
    </div>
</section>
@endsection
