@extends('layouts.app')

@section('page_banner_title', 'Boutique')

@section('page_banner_breadcrumbs')
    <li>Boutique</li>
@endsection

@section('content')

    <section class="featured-products alliance-books-shop">
        <span class="bg-shape"></span>

        <div class="auto-container">
            <div class="sec-title text-center mb-4">
                <span class="sub-title">Librairie</span>
                <h2>Nos ouvrages</h2>
            </div>

            @if($books->isEmpty())
                <div class="text-center py-5">
                    <h4>Aucun livre disponible pour le moment.</h4>
                    <p class="text-muted">Revenez bientôt pour découvrir nos publications.</p>
                </div>
            @else
                <div class="mixitup-gallery">
                    <div class="filters clearfix">
                        <ul class="filter-tabs filter-btns clearfix">
                            <li class="active filter" data-role="button" data-filter="all">Tous</li>
                            <li class="filter" data-role="button" data-filter=".dispo">En stock</li>
                            <li class="filter" data-role="button" data-filter=".ebook">E-book</li>
                            <li class="filter" data-role="button" data-filter=".rupture">Rupture</li>
                        </ul>
                    </div>

                    <div class="filter-list row">
                        @foreach($books as $book)
                            @php
                                $mix = ['all', 'mix'];
                                if ($book->stock_quantity === null || $book->stock_quantity > 0) {
                                    $mix[] = 'dispo';
                                } else {
                                    $mix[] = 'rupture';
                                }
                                if ($book->digital_file_path) {
                                    $mix[] = 'ebook';
                                }
                                $cartItem = [
                                    'id' => $book->id,
                                    'title' => $book->title,
                                    'price' => $book->price !== null ? (float) $book->price : null,
                                    'currency' => $book->currency ?? 'USD',
                                    'cover_url' => $book->cover_url,
                                ];
                                $canCart = ! ($book->stock_quantity !== null && $book->stock_quantity <= 0);
                            @endphp
                            <div class="product-block {{ implode(' ', $mix) }} col-lg-3 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a href="{{ route('books.show', $book->slug) }}">
                                            @if($book->cover_path)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($book->cover_path) }}" alt="{{ $book->title }}">
                                            @else
                                                <img src="{{ asset('assets/images/resource/about-1.jpg') }}" alt="{{ $book->title }}" style="width:100%;max-height:320px;object-fit:cover;filter:saturate(0.85);">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h4><a href="{{ route('books.show', $book->slug) }}">{{ $book->title }}</a></h4>
                                        @if($book->price !== null)
                                            <span class="price">{{ number_format((float) $book->price, 2, ',', ' ') }} {{ $book->currency ?? 'USD' }}</span>
                                        @else
                                            <span class="price">—</span>
                                        @endif
                                        <span class="rating" aria-hidden="true">
                                            @for($i = 0; $i < 5; $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor
                                        </span>
                                    </div>
                                    <div class="icon-box">
                                        <a href="{{ route('books.show', $book->slug) }}" class="ui-btn like-btn" title="Fiche livre"><i class="fa fa-book"></i></a>
                                        @if($canCart)
                                            <button type="button" class="ui-btn add-to-cart js-add-to-cart" title="Ajouter au panier" data-item='@json($cartItem)'><i class="fa fa-shopping-cart"></i></button>
                                        @else
                                            <span class="ui-btn add-to-cart opacity-50" style="cursor:not-allowed;" title="Indisponible"><i class="fa fa-shopping-cart"></i></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
