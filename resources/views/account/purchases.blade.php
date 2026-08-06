@extends('layouts.app')

@section('page_banner_title', 'Mes achats')

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('account.index') }}">Mon compte</a></li>
    <li>Achats</li>
@endsection

@php
    $orderStatusClass = fn (string $s) => match ($s) {
        'pending' => 'bg-warning text-dark',
        'paid' => 'bg-success',
        'cancelled' => 'bg-danger',
        'refunded' => 'bg-secondary',
        default => 'bg-secondary',
    };
    $orderStatusLabel = fn (string $s) => match ($s) {
        'pending' => 'En attente',
        'paid' => 'Payée',
        'cancelled' => 'Annulée',
        'refunded' => 'Remboursée',
        default => $s,
    };
    $payStatusClass = fn (string $s) => match ($s) {
        'pending' => 'bg-warning text-dark',
        'completed' => 'bg-success',
        'failed' => 'bg-danger',
        'processing' => 'bg-info text-dark',
        default => 'bg-light text-dark border',
    };
    $payStatusLabel = fn (string $s) => match ($s) {
        'pending' => 'Paiement en attente',
        'completed' => 'Payé',
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
                <h2 class="mb-0">Mes achats</h2>
            </div>
            <a href="{{ route('account.index') }}" class="theme-btn btn-style-one btn-sm"><span class="btn-title">← Mon compte</span></a>
        </div>

        @if($orders->isEmpty())
            <p class="text-muted py-5 text-center">Vous n’avez pas encore de commande.</p>
        @else
            @foreach($orders as $order)
                @php
                    $due = (float) ($order->grand_total ?? $order->subtotal);
                @endphp
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
                        <div>
                            <strong>Commande</strong>
                            <code class="ms-1">{{ $order->reference ?? '#'.$order->id }}</code>
                            <span class="text-muted small ms-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $orderStatusClass($order->status) }} me-1">{{ $orderStatusLabel($order->status) }}</span>
                            <span class="badge {{ $payStatusClass($order->payment_status) }}">{{ $payStatusLabel($order->payment_status) }}</span>
                            <strong class="ms-2 d-inline-block" style="color:#A86C3C;">{{ number_format($due, 2, ',', ' ') }} {{ $order->currency }}</strong>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if($order->shipping_opt_in)
                            <div class="small text-muted border-bottom pb-2 mb-2">
                                <p class="mb-1">
                                    <i class="fa fa-truck me-1"></i> Livraison : {{ $order->shipping_city }} ({{ $order->shipping_country }})
                                    @if((float) $order->shipping_cost > 0)
                                        — {{ number_format((float) $order->shipping_cost, 2, ',', ' ') }} {{ $order->currency }}
                                    @endif
                                </p>
                                @if(filled($order->shipping_address))
                                    <p class="mb-1 text-dark"><span class="fw-semibold">Adresse :</span><br>{!! nl2br(e($order->shipping_address)) !!}</p>
                                @endif
                                @if(filled($order->shipping_phone))
                                    <p class="mb-0"><span class="fw-semibold">Contact :</span> <a href="tel:{{ preg_replace('/\s+/', '', $order->shipping_phone) }}">{{ $order->shipping_phone }}</a></p>
                                @endif
                            </div>
                        @endif
                        <ul class="list-unstyled mb-0">
                            @foreach($order->orderItems as $line)
                                <li class="border-bottom py-2 d-flex justify-content-between align-items-center gap-3">
                                    <div class="d-flex align-items-center gap-3 min-w-0">
                                        <img src="{{ $line->book?->cover_url ?? asset('assets/images/resource/about-1.jpg') }}" alt="" width="48" height="64" class="flex-shrink-0 rounded" style="object-fit:cover;">
                                        <span class="min-w-0">{{ $line->book?->title ?? 'Livre #'.$line->book_id }} × {{ $line->quantity }}</span>
                                    </div>
                                    <span class="text-nowrap flex-shrink-0">{{ number_format((float) $line->line_total, 2, ',', ' ') }} {{ $order->currency }}</span>
                                </li>
                            @endforeach
                        </ul>
                        @if((float) $order->shipping_cost > 0 || (float) $order->subtotal !== $due)
                            <p class="small text-muted mb-0 mt-2">
                                Sous-total articles : {{ number_format((float) $order->subtotal, 2, ',', ' ') }} {{ $order->currency }}
                                @if((float) $order->shipping_cost > 0)
                                    · Livraison : {{ number_format((float) $order->shipping_cost, 2, ',', ' ') }} {{ $order->currency }}
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-center mt-4">{{ $orders->links() }}</div>
        @endif
    </div>
</section>
@endsection
