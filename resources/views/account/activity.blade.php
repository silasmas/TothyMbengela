@extends('layouts.app')

@section('page_banner_title', 'Historique des transactions')

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('account.index') }}">Mon compte</a></li>
    <li>Historique</li>
@endsection

@php
    $actOrderCmdClass = fn (string $s) => match ($s) {
        'pending' => 'bg-warning text-dark',
        'paid' => 'bg-success',
        'cancelled' => 'bg-danger',
        'refunded' => 'bg-secondary',
        default => 'bg-secondary',
    };
    $actOrderCmdLabel = fn (string $s) => match ($s) {
        'pending' => 'Commande en attente',
        'paid' => 'Commande payée',
        'cancelled' => 'Commande annulée',
        'refunded' => 'Remboursée',
        default => $s,
    };
    $actOrderPayClass = fn (string $s) => match ($s) {
        'pending' => 'bg-warning text-dark',
        'completed' => 'bg-success',
        'failed' => 'bg-danger',
        'processing' => 'bg-info text-dark',
        default => 'bg-light text-dark border',
    };
    $actOrderPayLabel = fn (string $s) => match ($s) {
        'pending' => 'Paiement en attente',
        'completed' => 'Paiement OK',
        'failed' => 'Paiement échoué',
        'processing' => 'Paiement en cours',
        default => $s,
    };
@endphp

@section('content')
<section class="about-section" style="padding-top: 50px; padding-bottom: 80px;">
    <div class="auto-container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div class="sec-title mb-0">
                <h2 class="mb-0">Historique des transactions</h2>
            </div>
            <a href="{{ route('account.index') }}" class="theme-btn btn-style-one btn-sm"><span class="btn-title">← Mon compte</span></a>
        </div>

        @if($items->isEmpty())
            <p class="text-muted py-5 text-center">Aucune transaction enregistrée pour le moment.</p>
        @else
            <div class="table-responsive shadow-sm rounded overflow-hidden" style="background:#fff;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Référence</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $row)
                            <tr>
                                <td class="text-nowrap small">{{ $row['at']?->format('d/m/Y H:i') ?? '—' }}</td>
                                <td><i class="fa {{ $row['icon'] }} me-1" style="color:#C8922A;"></i> {{ $row['title'] }}</td>
                                <td><code class="small">{{ $row['ref'] }}</code></td>
                                <td>{{ $row['detail'] }}</td>
                                <td>
                                    @if(($row['kind'] ?? '') === 'order')
                                        <span class="badge {{ $actOrderCmdClass($row['order_status'] ?? '') }}">{{ $actOrderCmdLabel($row['order_status'] ?? '') }}</span>
                                        <span class="badge {{ $actOrderPayClass($row['payment_status'] ?? '') }}">{{ $actOrderPayLabel($row['payment_status'] ?? '') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $row['status'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection
