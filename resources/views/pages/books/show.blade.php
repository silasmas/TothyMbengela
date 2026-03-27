@extends('layouts.app')

@section('page_banner_title', $book->title)

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('books.index') }}">Boutique</a></li>
    <li>{{ Str::limit($book->title, 48) }}</li>
@endsection

@section('content')

    <!-- Book Detail -->
    <section class="shop-details">
        <div class="auto-container">
            <div class="row">
                <!-- Image -->
                <div class="col-lg-6 col-md-12 mb-4">
                    @if($book->cover_path)
                        <img src="{{ Storage::disk('public')->url($book->cover_path) }}" alt="{{ $book->title }}" style="width:100%;max-width:450px;border-radius:8px;box-shadow:0 8px 25px rgba(0,0,0,0.1);margin:0 auto;display:block;">
                    @else
                        <div style="width:100%;max-width:450px;height:500px;background:linear-gradient(135deg,#C8922A,#e5ab2e);border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <i class="fa fa-book" style="font-size:80px;color:rgba(255,255,255,0.7);"></i>
                        </div>
                    @endif
                </div>

                <!-- Details -->
                <div class="col-lg-6 col-md-12">
                    <h2 style="margin-bottom:15px;">{{ $book->title }}</h2>

                    @if($book->price)
                        <div style="font-size:32px;font-weight:bold;color:#C8922A;margin-bottom:20px;">
                            {{ number_format((float) $book->price, 2, ',', ' ') }} {{ $book->currency ?? 'USD' }}
                        </div>
                    @endif

                    @if($book->isbn)
                        <p style="color:#888;font-size:14px;margin-bottom:10px;">ISBN : {{ $book->isbn }}</p>
                    @endif

                    @if($book->stock_quantity !== null)
                        <p style="font-size:14px;margin-bottom:20px;">
                            <span style="color:{{ $book->stock_quantity > 0 ? '#28a745' : '#dc3545' }};font-weight:600;">
                                <i class="fa {{ $book->stock_quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $book->stock_quantity > 0 ? 'En stock ('.$book->stock_quantity.' disponible'.($book->stock_quantity > 1 ? 's' : '').')' : 'Rupture de stock' }}
                            </span>
                        </p>
                    @endif

                    @if($book->description)
                        <div style="line-height:1.8;color:#555;margin-bottom:30px;">
                            {!! nl2br(e($book->description)) !!}
                        </div>
                    @endif

                    @php
                        $cartItemShow = [
                            'id' => $book->id,
                            'title' => $book->title,
                            'price' => $book->price !== null ? (float) $book->price : null,
                            'currency' => $book->currency ?? 'USD',
                            'cover_url' => $book->cover_url,
                        ];
                    @endphp
                    @if($book->stock_quantity === null || $book->stock_quantity > 0)
                    <button type="button" class="theme-btn btn-style-one me-2 mb-2 js-add-to-cart" data-item='@json($cartItemShow)'>
                        <span class="btn-title"><i class="fa fa-cart-plus"></i> Ajouter au panier</span>
                    </button>
                    @endif
                    <a href="{{ route('contact.create') }}?subject=Commande : {{ urlencode($book->title) }}" class="theme-btn btn-style-two mb-2">
                        <span class="btn-title"><i class="fa fa-envelope"></i> Nous contacter</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
