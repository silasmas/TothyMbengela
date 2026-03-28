@extends('layouts.app')

@section('page_banner_title', 'À propos')

@section('page_banner_image', asset('assets/images/about-ministry/about-banner-tothy.png'))

@section('page_banner_breadcrumbs')
    <li>À propos</li>
@endsection

@section('content')

    <!-- About Section — collage à gauche (image principale + vignette superposée), texte à droite -->
    <section class="about-section alliance-about-collage">
        <div class="auto-container">
            <div class="outer-box">
                <div class="row align-items-start">
                    <div class="image-column col-xl-6 col-lg-5 col-md-12 col-sm-12">
                        <div class="inner-column wow fadeInLeft">
                            <div class="image-box">
                                <span class="icon icon-dots-one bounce-x" aria-hidden="true"></span>
                                <figure class="image-1 overlay-anim wow fadeInUp">
                                    <img src="{{ asset('assets/images/about-ministry/about-collage-main.jpg') }}" alt="Pasteure Tothy Mbengela — Parole et enseignement" width="500" height="540">
                                </figure>
                                <figure class="image-2 overlay-anim wow fadeInRight" data-wow-delay="200ms">
                                    <img src="{{ asset('assets/images/about-ministry/about-collage-accent.jpg') }}" alt="Pasteure Tothy Mbengela" width="310" height="360">
                                </figure>
                                <span class="icon-box icon-one"><i class="flaticon-mission" aria-hidden="true"></i></span>
                                <span class="icon-box icon-two"><i class="flaticon-content-creator" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="content-column col-xl-6 col-lg-7 col-md-12 col-sm-12 wow fadeInRight" data-wow-delay="400ms">
                        <div class="inner-column">
                            <div class="sec-title">
                                <span class="sub-title">Faire connaissance</span>
                                <h2>Alliance — un ministère au service<br>de la Parole et des vies</h2>
                                <h4>Une approche biblique, accessible et engagée.</h4>
                                <div class="text">Alliance est le ministère de la Pasteure Tothy Mbengela. Nous proposons des enseignements, des prédications, des ressources et un accompagnement spirituel pour édifier la foi, restaurer les cœurs et encourager chacun dans sa marche avec Dieu — à Lubumbashi et au-delà, grâce aux contenus en ligne et aux ouvrages publiés.</div>
                            </div>

                            <div class="row g-4 g-lg-5 align-items-start alliance-about-cta-row">
                                <div class="col-lg-7 col-md-7">
                                    <ul class="list-style-one mb-0">
                                        <li><i class="fa fa-check-circle"></i> Des contenus variés : vidéos, audio, articles et séries d’enseignements</li>
                                        <li><i class="fa fa-check-circle"></i> Quatre livres pour approfondir la foi et la vie quotidienne</li>
                                        <li><i class="fa fa-check-circle"></i> Une communauté invitée à grandir dans l’amour et la vérité</li>
                                    </ul>
                                    <a href="{{ route('contents.index') }}" class="theme-btn btn-style-one hvr-dark mt-3"><span class="btn-title">Découvrir nos contenus</span></a>
                                </div>
                                <div class="col-lg-5 col-md-5 d-flex justify-content-lg-end justify-content-center">
                                    <div class="exp-box alliance-about-exp-static">
                                        <h2 class="count"><i class="icon flaticon-experience"></i> +10</h2>
                                        <span class="txt">Années au service du ministère</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section — image centrée, sans étirement (contain) -->
    <section class="video-section">
        <div class="auto-container">
            <div class="video-box">
                <div class="bg">
                    <div class="bg bg-image" style="background-image: url({{ asset('assets/images/video.jpeg') }})"></div>
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

    <!-- Features Section Two -->
    <section class="features-section-two pull-up">
        <div class="auto-container">
            <div class="row">
                <div class="feature-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                    <div class="inner-box">
                        <div class="content">
                            <h6 class="title"><a href="{{ route('contact.create') }}">Une équipe<br>à l’écoute</a></h6>
                            <i class="icon flaticon-team"></i>
                        </div>
                        <a href="{{ route('contact.create') }}" class="read-more">Nous écrire</a>
                    </div>
                </div>
                <div class="feature-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="200ms">
                    <div class="inner-box">
                        <div class="content">
                            <h6 class="title"><a href="{{ route('contents.index') }}">Un message<br>ancré dans la Bible</a></h6>
                            <i class="icon flaticon-customer-satisfaction"></i>
                        </div>
                        <a href="{{ route('contents.index') }}" class="read-more">Voir les contenus</a>
                    </div>
                </div>
                <div class="feature-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="400ms">
                    <div class="inner-box">
                        <div class="content">
                            <h6 class="title"><a href="{{ route('books.index') }}">Livres &amp;<br>ressources</a></h6>
                            <i class="icon flaticon-design-thinking"></i>
                        </div>
                        <a href="{{ route('books.index') }}" class="read-more">La boutique</a>
                    </div>
                </div>
            </div>

            <div class="bottom-box">
                Le ministère propose des contenus et des ouvrages pour chaque étape de votre cheminement spirituel.
                <a href="{{ url('/#prise-rendez-vous') }}" class="theme-btn btn-style-one light-bg small"><span class="btn-title">Prendre rendez-vous</span></a>
            </div>
        </div>
    </section>

    <!-- Team Section — données admin (table team_members) -->
    <section class="team-section">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="sub-title">Leadership</span>
                <h2>{{ $teamMembers->count() === 1 ? $teamMembers->first()->name : 'Notre équipe' }}</h2>
            </div>

            @if($teamMembers->isEmpty())
                <p class="text-center text-muted mb-0">L’équipe sera bientôt présentée ici.</p>
            @else
                <div class="row justify-content-center">
                    @foreach($teamMembers as $index => $member)
                        <div class="team-block-two col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 200 }}ms">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image">
                                        @php $profile = $member->profileHref(); @endphp
                                        @if($profile)
                                            <a href="{{ $profile }}" target="_blank" rel="noopener noreferrer">
                                                <img src="{{ $member->photoDisplayUrl() }}" alt="{{ $member->name }}">
                                            </a>
                                        @else
                                            <a href="{{ route('team.show', $member) }}">
                                                <img src="{{ $member->photoDisplayUrl() }}" alt="{{ $member->name }}">
                                            </a>
                                        @endif
                                    </figure>
                                    <div class="social-links">
                                        @if($member->social_facebook)
                                            <a href="{{ $member->social_facebook }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                        @endif
                                        @if($member->social_youtube)
                                            <a href="{{ $member->social_youtube }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                                        @endif
                                        @if($member->social_instagram)
                                            <a href="{{ $member->social_instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                                        @endif
                                        @if($member->social_tiktok)
                                            <a href="{{ $member->social_tiktok }}" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                                        @endif
                                    </div>
                                    <span class="share-icon fa fa-share-alt"></span>
                                </div>
                                <div class="info-box">
                                    <h5 class="name"><a href="{{ route('team.show', $member) }}">{{ $member->name }}</a></h5>
                                    @if($member->role)
                                        <span class="designation">{{ $member->role }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>





@endsection
