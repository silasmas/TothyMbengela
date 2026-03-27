@extends('layouts.app')

@section('content')

    {{-- ═══ RUBRIQUES ═══ --}}
    @if($rubriques->isNotEmpty())
    <!-- Services Section -->
    <section class="services-section">
        <div class="bg bg-pattern-1"></div>
        <div class="auto-container">
            <div class="sec-title light">
                <div class="row">
                    <div class="col-lg-7">
                        <span class="sub-title">Nos services</span>
                        <h2>Ce que nous offrons</h2>
                    </div>
                    <div class="col-lg-5">
                        <div class="text">Découvrez nos différentes rubriques, chacune conçue pour vous enrichir spirituellement et répondre à vos besoins dans votre marche avec Dieu.</div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($rubriques as $rubrique)
                    <div class="service-block col-sm-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ $loop->index * 300 }}ms">
                        <div class="inner-box">
                            <span class="count">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h6 class="title"><a href="{{ route('contents.index', ['rubrique' => $rubrique->slug]) }}">{{ $rubrique->name }}</a></h6>
                            <div class="icon">
                                @if($rubrique->thumbnail_path)
                                    <img src="{{ Storage::disk('public')->url($rubrique->thumbnail_path) }}" alt="{{ $rubrique->name }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                @else
                                    <i class="flaticon-digital-marketing"></i>
                                @endif
                            </div>
                            <div class="text">{{ $rubrique->contents_count }} contenu{{ $rubrique->contents_count > 1 ? 's' : '' }} disponible{{ $rubrique->contents_count > 1 ? 's' : '' }} dans cette rubrique.</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Services Section -->

    <!-- About Section -->
    <section class="about-section-home6">
        <div class="anim-icons">
            <span class="icon icon-object-1"></span>
            <span class="icon icon-object-4"></span>
        </div>
        <div class="auto-container">
            <div class="row">
                <div class="content-column col-lg-7 col-xl-6 order-2 wow fadeInRight" data-wow-delay="600ms">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">À propos de nous</span>
                            <h3>Une communauté passionnée au service de votre croissance spirituelle.</h3>
                            <div class="text">Depuis plusieurs années, nous nous engageons à partager l'évangile et accompagner chacun dans sa vie chrétienne à travers des enseignements, ressources, et accompagnements adaptés à tous.</div>
                            <ul class="list-style-one">
                                <li><i class="fa fa-check-circle"></i> Une diversité de contenus pour tous les âges et besoins</li>
                                <li><i class="fa fa-check-circle"></i> Un ministère à l'écoute et engagé pour l'édification</li>
                            </ul>
                        </div>
                        <div class="content-box">
                            <div class="info-box">
                                <i class="icon flaticon-digital-services"></i>
                                <h6 class="title">Des milliers de personnes accompagnées</h6>
                            </div>
                            <h5 class="title">Un soutien disponible 7j/7</h5>
                            <div class="text">Nous sommes là pour vous, pour prier avec vous, répondre à vos questions et vous guider dans votre marche avec Dieu.</div>
                            <a href="{{ route('about') }}" class="theme-btn btn-style-one"><span class="btn-title">Découvrir le ministère</span></a>
                        </div>
                    </div>
                </div>
                <!-- Image Column -->
                <div class="image-column col-lg-5 col-xl-6">
                    <div class="inner-column wow fadeInLeft">
                        <span class="icon-dots bounce-y"></span>
                        <figure class="image-1 overlay-anim wow fadeInUp"><img src="{{ asset('assets/images/resource/about-1.jpg') }}" alt="Ministère Alliance"></figure>
                        <figure class="image-2 overlay-anim wow fadeInRight"><img src="{{ asset('assets/images/resource/about-2.jpg') }}" alt="Équipe Alliance"></figure>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section -->

    <!-- Video Section -->
    <section class="video-section">
        <div class="auto-container">
            <div class="video-box">
                <div class="bg">
                    <div class="bg bg-image" style="background-image: url({{ asset('assets/images/background/2.jpg') }})"></div>
                    <div class="overlay"></div>
                </div>
                <div class="content">
                    <div class="btn-box">
                        <a href="https://www.youtube.com/watch?v=0BH75IkAuq4" class="play-now" data-fancybox="gallery" data-caption="Vernissage des 4 livres — Pasteure Tothy Mbengela"><i class="icon fa fa-play" aria-hidden="true"></i><span class="ripple"></span></a>
                    </div>
                    <h2 class="title">Vernissage des 4 livres de la Pasteure</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End Video Section -->

    <!-- Fun Fact Section -->
    <section class="fun-fact-section at-home6">
        <div class="auto-container">
            <div class="outer-box">
                <div class="bg bg-pattern-5"></div>
                <div class="row">
                    <div class="title-column col-lg-4">
                        <div class="inner-column">
                            <div class="sec-title light">
                                <h3>Alliance en quelques chiffres</h3>
                            </div>
                        </div>
                    </div>

                    <div class="column col-lg-8">
                        <div class="fact-counter">
                            <div class="row">
                                <!-- Counter block -->
                                <div class="counter-block col-6 col-sm-4 wow fadeInUp">
                                    <div class="inner">
                                        <div class="content">
                                            <i class="icon flaticon-checking"></i>
                                            <div class="count-box"><span class="count-text" data-speed="3000" data-stop="{{ \App\Models\Content::where('is_published', true)->count() }}">0</span></div>
                                            <h6 class="counter-title">Contenus publiés</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- Counter block -->
                                <div class="counter-block col-6 col-sm-4 wow fadeInUp" data-wow-delay="300ms">
                                    <div class="inner">
                                        <div class="content">
                                            <i class="icon flaticon-recommend"></i>
                                            <div class="count-box"><span class="count-text" data-speed="3000" data-stop="{{ \App\Models\Book::where('is_active', true)->count() }}">0</span></div>
                                            <h6 class="counter-title">Livres disponibles</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- Counter block -->
                                <div class="counter-block col-6 col-sm-4 wow fadeInUp" data-wow-delay="600ms">
                                    <div class="inner">
                                        <div class="content">
                                            <i class="icon flaticon-consulting"></i>
                                            <div class="count-box"><span class="count-text" data-speed="3000" data-stop="{{ \App\Models\Series::count() }}">0</span></div>
                                            <h6 class="counter-title">Séries d'enseignements</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Fun Fact Section -->
    @endif

    {{-- ═══ LIVRES (Features Style) ═══ --}}
    <!-- Features Section - Livres de la Pasteure -->
    <section class="home5-features-section">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="sub-title">Boutique</span>
                <h2>Les livres de la Pasteure</h2>
                <div class="text">4 ouvrages disponibles — 10 $ par livre</div>
            </div>
            <div class="row">
                @foreach($books->take(4) as $book)
                @php
                    $homeBookCart = [
                        'id' => $book->id,
                        'title' => $book->title,
                        'price' => $book->price !== null ? (float) $book->price : null,
                        'currency' => $book->currency ?? 'USD',
                        'cover_url' => $book->cover_url,
                    ];
                    $canAddHomeBook = $book->stock_quantity === null || $book->stock_quantity > 0;
                @endphp
                <div class="feature-block-home5 col-md-6 col-lg-3">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    @if($book->cover_path)
                                        <img src="{{ Storage::disk('public')->url($book->cover_path) }}" alt="{{ $book->title }}">
                                    @else
                                        <img src="{{ asset('assets/images/resource/testimonial-bg1-550x550.jpg') }}" alt="{{ $book->title }}">
                                    @endif
                                </a>
                            </figure>
                            <div class="info-box">
                                <i class="icon fa fa-book"></i>
                                <h6 class="title">{{ $book->title }}</h6>
                                <span class="book-price-tag">{{ number_format((float) $book->price, 0, ',', ' ') }} {{ $book->currency ?? 'USD' }}</span>
                                <a href="{{ route('books.show', $book->slug) }}" class="read-more"><i class="fa fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                        <div class="overlay-content">
                            <div class="info-box">
                                <i class="icon fa fa-book"></i>
                                <h6 class="title"><a href="{{ route('books.show', $book->slug) }}">{{ $book->title }}</a></h6>
                                <div class="text">{{ Str::limit($book->description, 60) }}</div>
                                @if($canAddHomeBook)
                                <button type="button" class="theme-btn btn-style-one btn-sm js-add-to-cart" style="padding:6px 18px;font-size:13px;margin-top:8px;" data-item='@json($homeBookCart)'><span class="btn-title"><i class="fa fa-cart-plus"></i> Panier</span></button>
                                @endif
                                <a href="{{ route('books.show', $book->slug) }}" class="theme-btn btn-style-two btn-sm" style="padding:6px 18px;font-size:13px;margin-top:8px;{{ $canAddHomeBook ? 'margin-left:6px;' : '' }}"><span class="btn-title">Détails</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4 d-flex flex-wrap justify-content-center align-items-center gap-2">
                @if(!empty($booksCartPayload))
                <button type="button" class="theme-btn btn-style-one js-add-all-books-to-cart" data-books='@json($booksCartPayload)'><span class="btn-title"><i class="fa fa-shopping-cart"></i> Ajouter les ouvrages au panier</span></button>
                @endif
                <a href="{{ route('books.index') }}" class="theme-btn btn-style-two"><span class="btn-title">Voir la boutique</span></a>
            </div>
        </div>
    </section>
    <!-- End Features Section - Livres -->

    {{-- ═══ CONTENUS À LA UNE ═══ --}}
    <!-- News Section Two -->
    <section class="news-section-two">
        <div class="auto-container">
            <div class="row">
                <!-- Title Column -->
                <div class="title-column col-xl-4 col-lg-4 col-md-12">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">À la une</span>
                            <h2>Nos publications et enseignements</h2>
                            <div class="text">Retrouvez les contenus les plus récents du ministère : prédications, enseignements, études bibliques et bien plus.</div>
                        </div>
                        <a href="{{ route('contents.index') }}" class="theme-btn btn-style-one"><span class="btn-title">Tous les contenus</span></a>
                    </div>
                </div>

                <!-- Carousel Column -->
                <div class="carousel-column col-xl-8 col-lg-8 col-md-12">
                    <div class="carousel-outer d-inline-block">
                        <div class="news-carousel owl-carousel owl-theme">
                            @forelse($latestContents as $content)
                            <div class="news-block wow fadeInUp" @if($loop->index > 0) data-wow-delay="{{ min($loop->index * 300, 600) }}ms" @endif>
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image">
                                            <a href="{{ route('contents.show', $content->slug) }}">
                                                @if($content->getThumbnailDisplayUrl())
                                                    <img src="{{ $content->getThumbnailDisplayUrl() }}" alt="{{ $content->title }}">
                                                @else
                                                    <img src="{{ asset('assets/images/resource/news-1.jpg') }}" alt="{{ $content->title }}">
                                                @endif
                                            </a>
                                        </figure>
                                        @if($content->published_at)
                                        <span class="date">{{ $content->published_at->format('d') }}<br>{{ strtoupper($content->published_at->translatedFormat('M')) }}</span>
                                        @endif
                                    </div>
                                    <div class="lower-content">
                                        <ul class="post-info">
                                            <li>{{ $content->rubrique?->name ?? 'Général' }}</li>
                                            <li>{{ match($content->type) { 'video' => 'Vidéo', 'audio' => 'Audio', 'podcast' => 'Podcast', 'article' => 'Article', default => ucfirst($content->type) } }}</li>
                                        </ul>
                                        <h4 class="title"><a href="{{ route('contents.show', $content->slug) }}">{{ Str::limit($content->title, 55) }}</a></h4>
                                        <a href="{{ route('contents.show', $content->slug) }}" class="read-more">Lire la suite <i class="fa fa-long-arrow-alt-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="news-block">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image"><img src="{{ asset('assets/images/resource/news-1.jpg') }}" alt="Alliance"></figure>
                                    </div>
                                    <div class="lower-content">
                                        <h4 class="title">Les contenus arrivent bientôt</h4>
                                        <div class="text">Revenez prochainement pour découvrir nos prédications et enseignements.</div>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End News Section Two -->

    {{-- ═══ POURQUOI SOUTENIR ═══ --}}
    <!-- About Section Two - Soutien -->
    <section class="about-section-home5 alliance-support-section">
        <div class="auto-container">
            <div class="row">
                <div class="content-column position-relative col-xl-6 wow fadeInRight" data-wow-delay="600ms">
                    <div class="inner-column">
                        <div class="sec-title">
                            <span class="sub-title">Soutenir le ministère</span>
                            <h2>Pourquoi faire un don ou devenir partenaire ?</h2>
                            <div class="text">La Bible nous enseigne que donner est un acte de foi qui ouvre les portes de la bénédiction. <em>« Donnez et il vous sera donné »</em> <strong>(Luc 6:38)</strong>. Votre soutien permet de toucher des milliers de vies à travers la Parole de Dieu.</div>
                        </div>
                        <ul class="list-style-one">
                            <li><i class="fa fa-check-circle"></i> <strong>Semer dans le Royaume</strong> — « Celui qui sème abondamment moissonnera abondamment » (2 Cor 9:6)</li>
                            <li><i class="fa fa-check-circle"></i> <strong>Participer à l'œuvre</strong> — Chaque don finance la production de contenus, l'impression de livres et les missions</li>
                            <li><i class="fa fa-check-circle"></i> <strong>Recevoir la bénédiction</strong> — « Dieu aime celui qui donne avec joie » (2 Cor 9:7)</li>
                            <li><i class="fa fa-check-circle"></i> <strong>Devenir partenaire</strong> — Un engagement régulier pour un impact durable dans la vie des âmes</li>
                        </ul>
                        <div class="btn-box mt-3">
                            <a href="#" class="theme-btn btn-style-one" data-bs-toggle="modal" data-bs-target="#donatePartnerModal"><span class="btn-title"><i class="fa fa-heart"></i> Faire un don</span></a>
                            <a href="#" class="theme-btn alliance-btn-partner js-donate-modal-partner"><span class="btn-title"><i class="fa fa-handshake"></i> Devenir partenaire</span></a>
                        </div>
                    </div>
                </div>

                <!-- Image Column : hauteur alignée sur la colonne texte (styles .alliance-support-section dans le layout) -->
                <div class="image-column position-relative col-xl-6">
                    <div class="inner-column wow fadeInLeft">
                        <div class="image-box alliance-support-image-box">
                            <figure class="image overlay-anim wow fadeInUp">
                                <img src="{{ asset('assets/images/resource/about-1.jpg') }}" alt="Soutenir le ministère Alliance">
                            </figure>
                            <span class="float-text">Luc 6:38</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section Two -->

    {{-- ═══ TÉMOIGNAGES ═══ --}}
    @if($testimonials->isNotEmpty())
    <!-- Testimonial Section Two -->
    <section class="testimonial-section-two">
        <div class="bg bg-pattern-2"></div>
        <div class="auto-container">
            <div class="row">
                <!-- Title Column -->
                <div class="title-column col-xl-3 col-lg-12">
                    <div class="sec-title">
                        <span class="sub-title">Témoignages</span>
                        <h2>Ce qu'ils<br>disent de nous</h2>
                        <div class="text">Découvrez les témoignages de ceux dont la vie a été transformée par les enseignements et les livres du ministère Alliance.</div>
                    </div>
                </div>

                <!-- Testimonial Column -->
                <div class="testimonial-column col-xl-9 col-lg-12">
                    <div class="inner-column">
                        <div class="testimonial-carousel owl-carousel owl-theme">
                            @foreach($testimonials as $testimonial)
                            <div class="testimonial-block-two">
                                <div class="inner-box">
                                    <div class="content-box">
                                        <div class="thumb">
                                            @if($testimonial->avatar_path)
                                                <img src="{{ Storage::disk('public')->url($testimonial->avatar_path) }}" alt="{{ $testimonial->name }}">
                                            @else
                                                <img src="{{ asset('assets/images/resource/testi-thumb-1.png') }}" alt="{{ $testimonial->name }}">
                                            @endif
                                        </div>
                                        <div class="rating">
                                            @for($i = 0; $i < $testimonial->rating; $i++)
                                                <i class="fa fa-star"></i>
                                            @endfor
                                        </div>
                                        <div class="text">{{ $testimonial->message }}</div>
                                    </div>
                                    <div class="info-box">
                                        <h6 class="name">{{ $testimonial->name }}</h6>
                                        <span class="designation">{{ $testimonial->role }}{{ $testimonial->location ? ' — ' . $testimonial->location : '' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Testimonial Section -->
    @endif

    {{-- ═══ CONTACT / MAP ═══ --}}
    <!-- Map Section -->
    <section class="map-section">
        <div class="auto-container">
            <div class="outer-box">
                <div class="row g-0">
                    <!-- Contact Info Block -->
                    <div class="contact-info-block-two col-lg-4 col-md-12 col-sm-12">
                        <div class="inner">
                            <i class="icon fa fa-phone-volume"></i>
                            <h6 class="title">Une question ?</h6>
                            <div class="text"><a href="tel:+243816681958">+243 816 681 958</a></div>
                        </div>
                    </div>

                    <!-- Contact Info Block -->
                    <div class="contact-info-block-two col-lg-4 col-md-12 col-sm-12">
                        <div class="inner">
                            <i class="icon fa fa-envelope"></i>
                            <h6 class="title">Écrivez-nous</h6>
                            <div class="text"><a href="mailto:contact@alliance-ministere.com">contact@alliance-ministere.com</a></div>
                        </div>
                    </div>

                    <!-- Contact Info Block -->
                    <div class="contact-info-block-two col-lg-4 col-md-12 col-sm-12">
                        <div class="inner">
                            <i class="icon fa fa-map-marker-alt"></i>
                            <h6 class="title">Point de vente</h6>
                            <div class="text">Centre Missionnaire Philadelphie<br>N°17, Av. Nyangwe 1, Q/ Lido Golf — Lubumbashi</div>
                        </div>
                    </div>
                </div>
                <div class="social-link-outer">
                    <div class="text">Suivez-nous</div>
                    <ul class="social-icon-two">
                        <li><a href="https://www.facebook.com/tothymbengela" target="_blank"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="https://www.youtube.com/@tothymbengela" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        <li><a href="https://www.instagram.com/tothymbengela" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/@tothymbengela" target="_blank"><i class="fab fa-tiktok"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <iframe class="map" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=fr&amp;q=Lubumbashi,+RDC+(Centre+Missionnaire+Philadelphie)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
    </section>
    <!-- End Map Section -->


    {{-- Prise de rendez-vous : incluse globalement dans layouts/app (partials.section-appointment-before-footer) --}}

@endsection
