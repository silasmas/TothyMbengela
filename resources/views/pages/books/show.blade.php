@extends('layouts.app')

@section('page_banner_title', $book->title)

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('books.index') }}">Boutique</a></li>
    <li>{{ Str::limit($book->title, 48) }}</li>
@endsection

@section('content')

@php
    $imageUrls = $book->imageUrls();
    $mainImage = $imageUrls[0];
    $priceFormatted = $book->price !== null
        ? number_format((float) $book->price, 2, ',', ' ') . ' USD'
        : null;
    $shareUrl = url()->current();
    $shareText = rawurlencode($book->title . ' — Alliance');
    $cartItemShow = $book->toCartItem();
    $inStock = $book->isPurchasable();
    $descriptionPreview = $book->description
        ? Str::limit(strip_tags($book->description), 220)
        : null;
@endphp

    {{-- Bloc principal produit : marge sous le bandeau page-title --}}
    <section class="product-details alliance-book-product pb-4">
        <span id="slider-prev" class="visually-hidden" aria-hidden="true"></span>
        <span id="slider-next" class="visually-hidden" aria-hidden="true"></span>
        <div class="auto-container pb-70 alliance-book-product__inner">
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="bxslider">
                        @foreach($imageUrls as $imgUrl)
                        <div class="slider-content">
                            <figure class="image-box">
                                <a href="{{ $imgUrl }}" class="lightbox-image" data-fancybox="gallery-book" data-caption="{{ e($book->title) }}">
                                    <img src="{{ $imgUrl }}" alt="{{ $book->title }}">
                                </a>
                            </figure>
                            @if(count($imageUrls) > 1)
                            <div class="slider-pager">
                                <ul class="thumb-box">
                                    @foreach($imageUrls as $thumbIdx => $thumbUrl)
                                    <li>
                                        <a class="{{ $loop->parent->first && $loop->first ? 'active' : '' }}" data-slide-index="{{ $thumbIdx }}" href="#">
                                            <figure><img src="{{ $thumbUrl }}" alt=""></figure>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6 product-info">
                    <div class="product-details__top">
                        <h3 class="product-details__title">
                            {{ $book->title }}
                            @if($book->price !== null)
                                <span class="js-alliance-price" data-price-usd="{{ (float) $book->price }}">{{ $priceFormatted }}</span>
                            @endif
                        </h3>
                        <p class="small text-muted mb-0">{{ $book->product_type_label }}</p>
                    </div>
                    <div class="product-details__reveiw">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <span>Ouvrage du ministère Alliance</span>
                    </div>
                    <div class="product-details__content">
                        @if($descriptionPreview)
                            <p class="product-details__content-text1 text-muted">{{ $descriptionPreview }}</p>
                        @endif
                        <p class="product-details__content-text2">
                            @if($book->isbn)
                                <strong>RÉF.</strong> {{ $book->isbn }}
                            @else
                                <strong>RÉF.</strong> {{ $book->slug }}
                            @endif
                        </p>
                    </div>

                    @if($inStock && ($book->price !== null))
                        <div class="product-details__quantity">
                            <h3 class="product-details__quantity-title">Quantité</h3>
                            <div class="quantity-box">
                                <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                <input type="number" id="alliance-book-qty" value="1" min="1" max="999" aria-label="Quantité" />
                                <button type="button" class="add"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    @endif

                    <div class="product-details__buttons alliance-book-actions">
                        <div class="alliance-book-actions-row">
                            @if($inStock)
                                <button type="button" class="theme-btn btn-style-one js-add-to-cart" data-item='@json($cartItemShow)'>
                                    <span class="btn-title"><i class="fa fa-cart-plus"></i> Ajouter au panier</span>
                                </button>
                                <button type="button" class="theme-btn btn-style-two js-buy-now" data-item='@json($cartItemShow)'>
                                    <span class="btn-title"><i class="fa fa-bolt"></i> Acheter</span>
                                </button>
                            @endif
                            <a href="{{ route('books.index') }}" class="theme-btn btn-style-one">
                                <span class="btn-title"><i class="fa fa-th-large"></i> Boutique</span>
                            </a>
                        </div>
                    </div>

                    <div class="product-details__social alliance-book-share">
                        <div class="title">
                            <h3>Partager</h3>
                        </div>
                        <ul class="social-icon-one">
                            <li>
                                <a href="https://twitter.com/intent/tweet?url={{ rawurlencode($shareUrl) }}&text={{ $shareText }}" target="_blank" rel="noopener noreferrer" aria-label="Partager sur X"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" aria-label="Partager sur Facebook"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href="https://wa.me/?text={{ rawurlencode($book->title . ' ' . $shareUrl) }}" target="_blank" rel="noopener noreferrer" aria-label="Partager sur WhatsApp"><i class="fab fa-whatsapp"></i></a>
                            </li>
                            <li>
                                <a href="mailto:?subject={{ rawurlencode($book->title) }}&body={{ rawurlencode($shareUrl) }}" aria-label="Partager par e-mail"><i class="fa fa-envelope"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="alliance-book-contact">
                        <a href="{{ route('contact.create') }}?subject={{ urlencode('Commande : '.$book->title) }}" class="theme-btn btn-style-two">
                            <span class="btn-title"><i class="fa fa-envelope"></i> Nous contacter pour ce livre</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Onglets Description / Avis (thème : tabs-box + product-discription) --}}
    <section class="product-discription pb-5">
        <div class="auto-container">
            <div class="tabs-box">
                <div class="tab-btn-box">
                    <div class="tab-buttons">
                        <ul class="tab-btns clearfix">
                            <li class="tab-btn active-btn" data-tab="#book-tab-description">Description</li>
                            <li class="tab-btn" data-tab="#book-tab-reviews">Avis</li>
                        </ul>
                    </div>
                </div>
                <div class="tabs-content">
                    <div class="tab active-tab" id="book-tab-description">
                        <div class="text">
                            @if($book->description)
                                <div class="product-description__text1" style="font-size:16px;line-height:1.75;">
                                    {!! nl2br(e($book->description)) !!}
                                </div>
                            @else
                                <p class="text-muted mb-0">Aucune description détaillée pour cet ouvrage.</p>
                            @endif
                        </div>
                    </div>
                    <div class="tab" id="book-tab-reviews" style="display: none;">
                        <div class="comment-box">
                            <h3>Avis et témoignages</h3>
                            @forelse($bookReviews as $rev)
                                <div class="customer-comment">
                                    <div class="single-comment-box">
                                        <div class="inner-box">
                                            <figure class="comment-thumb">
                                                @if($rev->avatar_path)
                                                    <img src="{{ Storage::disk('public')->url($rev->avatar_path) }}" alt="">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($rev->name) }}&background=A86C3C&color=fff&size=160" alt="">
                                                @endif
                                            </figure>
                                            @if($rev->rating)
                                                <ul class="rating review-box clearfix list-unstyled">
                                                    @for($i = 0; $i < 5; $i++)
                                                        <li><i class="fa fa-star{{ $i < $rev->rating ? '' : '-o' }}"></i></li>
                                                    @endfor
                                                </ul>
                                            @endif
                                            <h5>{{ $rev->name }} @if($rev->role || $rev->location)<span>— {{ trim(implode(' · ', array_filter([$rev->role, $rev->location]))) }}</span>@endif</h5>
                                            <div class="text">
                                                <p class="mb-0">{{ $rev->message }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Aucun avis publié pour le moment. Les encouragements de la communauté apparaîtront ici.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($relatedBooks->isNotEmpty())
        <section class="related-product pb-90 pt-1">
            <div class="auto-container">
                <h3>Ouvrages associés</h3>
                <div class="row clearfix">
                    @foreach($relatedBooks as $rb)
                        @php
                            $cartRel = [
                                'id' => $rb->id,
                                'title' => $rb->title,
                                'price' => $rb->price !== null ? (float) $rb->price : null,
                                'currency' => $rb->currency ?? 'USD',
                                'cover_url' => $rb->cover_url,
                            ];
                            $canCartRel = ! ($rb->stock_quantity !== null && $rb->stock_quantity <= 0);
                            $relImg = $rb->cover_path
                                ? Storage::disk('public')->url($rb->cover_path)
                                : asset('assets/images/resource/about-1.jpg');
                        @endphp
                        <div class="product-block col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="inner-box">
                                <div class="image">
                                    <a href="{{ route('books.show', $rb->slug) }}">
                                        <img src="{{ $relImg }}" alt="{{ $rb->title }}" style="width:100%;max-height:320px;object-fit:cover;">
                                    </a>
                                </div>
                                <div class="content">
                                    <h4><a href="{{ route('books.show', $rb->slug) }}">{{ Str::limit($rb->title, 52) }}</a></h4>
                                    @if($rb->price !== null)
                                        <span class="price">{{ number_format((float) $rb->price, 2, ',', ' ') }} {{ $rb->currency ?? 'USD' }}</span>
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
                                    <a href="{{ route('books.show', $rb->slug) }}" class="ui-btn like-btn" title="Fiche livre"><i class="fa fa-book"></i></a>
                                    @if($canCartRel)
                                        <button type="button" class="ui-btn add-to-cart js-add-to-cart" title="Ajouter au panier" data-item='@json($cartRel)'><i class="fa fa-shopping-cart"></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('styles')
<style>
    .alliance-book-product {
        padding-top: clamp(2.25rem, 5vw, 3.75rem) !important;
    }
    .alliance-book-product__inner {
        padding-bottom: 2rem;
    }
    .product-discription .tab-buttons .tab-btns {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .product-discription .tab-buttons .tab-btns .tab-btn {
        cursor: pointer;
    }
</style>
@endpush
