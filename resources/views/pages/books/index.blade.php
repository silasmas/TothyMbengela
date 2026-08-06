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
                <span class="sub-title">Boutique Alliance</span>
                <h2>Produits de la Pasteure</h2>
                <p class="text">Livres, Flash USB + bracelet, packs et autres ressources</p>
            </div>

            @if($books->isEmpty())
                <div class="text-center py-5">
                    <h4>Aucun produit disponible pour le moment.</h4>
                    <p class="text-muted">Revenez bientôt pour découvrir nos publications et ressources.</p>
                </div>
            @else
                <div class="mixitup-gallery">
                    <div class="filters clearfix">
                        <ul class="filter-tabs filter-btns clearfix">
                            <li class="active filter" data-role="button" data-filter="all">Tous</li>
                            <li class="filter" data-role="button" data-filter=".type-book">Livres</li>
                            <li class="filter" data-role="button" data-filter=".type-usb">Flash USB</li>
                            <li class="filter" data-role="button" data-filter=".type-pack">Packs</li>
                            <li class="filter" data-role="button" data-filter=".ebook">E-book</li>
                        </ul>
                    </div>

                    <div class="filter-list row">
                        @foreach($books as $book)
                            @php
                                $mix = ['all', 'mix', 'type-'.($book->product_type ?? 'book')];
                                if ($book->stock_quantity === null || $book->stock_quantity > 0) {
                                    $mix[] = 'dispo';
                                } else {
                                    $mix[] = 'rupture';
                                }
                                if ($book->digital_file_path) {
                                    $mix[] = 'ebook';
                                }
                                $cartItem = $book->toCartItem();
                                $canCart = $book->isPurchasable();
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
                                        <span class="d-block small text-uppercase mb-1" style="letter-spacing:.06em;color:#A86C3C;font-weight:700;">{{ $book->product_type_label }}</span>
                                        <h4><a href="{{ route('books.show', $book->slug) }}">{{ $book->title }}</a></h4>
                                        @if($book->price !== null)
                                            <span class="price js-alliance-price" data-price-usd="{{ (float) $book->price }}">{{ number_format((float) $book->price, 2, ',', ' ') }} USD</span>
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
                                        <a href="{{ route('books.show', $book->slug) }}" class="ui-btn like-btn" title="Fiche produit"><i class="fa fa-eye"></i></a>
                                        @if($canCart)
                                            <button type="button" class="ui-btn add-to-cart js-add-to-cart" title="Ajouter au panier" data-item='@json($cartItem)'><i class="fa fa-shopping-cart"></i></button>
                                            <button type="button" class="ui-btn js-buy-now" title="Acheter maintenant" data-item='@json($cartItem)'><i class="fa fa-bolt"></i></button>
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
