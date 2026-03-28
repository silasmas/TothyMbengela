@extends('layouts.app')

@section('page_banner_title', $teamMember->name)

@section('page_banner_image', $teamMember->photoDisplayUrl())

@section('page_banner_breadcrumbs')
    <li><a href="{{ route('about') }}">À propos</a></li>
    <li>{{ Str::limit($teamMember->name, 48) }}</li>
@endsection

@section('content')

    <section class="blog-details alliance-blog-details alliance-team-detail pt-2 pb-5">
        <div class="auto-container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="blog-details__left">
                        <div class="blog-details__img mb-4">
                            <img src="{{ $teamMember->photoDisplayUrl() }}" alt="{{ $teamMember->name }}">
                        </div>

                        <div class="blog-details__content">
                            <ul class="list-unstyled blog-details__meta mb-3">
                                @if($teamMember->role)
                                    <li>
                                        <span class="text-muted" style="cursor:default;"><i class="fa fa-briefcase"></i> {{ $teamMember->role }}</span>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('about') }}"><i class="fa fa-users"></i> Toute l’équipe</a>
                                </li>
                                <li>
                                    <a href="{{ route('contents.index') }}"><i class="fa fa-play-circle"></i> Nos contenus</a>
                                </li>
                            </ul>

                            <h3 class="blog-details__title">{{ $teamMember->name }}</h3>

                            @if($teamMember->excerpt)
                                <p class="lead text-muted alliance-team-detail__excerpt">{{ $teamMember->excerpt }}</p>
                            @endif

                            @if($teamMember->body)
                                <div class="blog-details__text-2">
                                    {!! nl2br(e($teamMember->body)) !!}
                                </div>
                            @endif

                            <div class="alliance-team-detail__social mt-4 pt-3 border-top">
                                <h5 class="mb-3">Suivre</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    @if($teamMember->social_facebook)
                                        <a href="{{ $teamMember->social_facebook }}" class="theme-btn btn-style-two btn-sm" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i> Facebook</a>
                                    @endif
                                    @if($teamMember->social_youtube)
                                        <a href="{{ $teamMember->social_youtube }}" class="theme-btn btn-style-two btn-sm" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i> YouTube</a>
                                    @endif
                                    @if($teamMember->social_instagram)
                                        <a href="{{ $teamMember->social_instagram }}" class="theme-btn btn-style-two btn-sm" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i> Instagram</a>
                                    @endif
                                    @if($teamMember->social_tiktok)
                                        <a href="{{ $teamMember->social_tiktok }}" class="theme-btn btn-style-two btn-sm" target="_blank" rel="noopener noreferrer"><i class="fab fa-tiktok"></i> TikTok</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar blog-sidebar alliance-team-sidebar">
                        @if($otherMembers->isNotEmpty())
                            <div class="sidebar-widget">
                                <div class="widget-title">
                                    <h4>Autres membres</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="list-style-two">
                                        @foreach($otherMembers as $m)
                                            <li>
                                                <a href="{{ route('team.show', $m) }}">{{ $m->name }}</a>
                                                @if($m->role)
                                                    <span class="text-muted small d-block">{{ Str::limit($m->role, 60) }}</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="sidebar-widget">
                            <div class="widget-title">
                                <h4>Liens utiles</h4>
                            </div>
                            <div class="widget-content">
                                <a href="{{ route('contact.create') }}" class="theme-btn btn-style-one w-100 mb-2"><span class="btn-title">Nous contacter</span></a>
                                <a href="{{ route('books.index') }}" class="theme-btn btn-style-two w-100"><span class="btn-title">Boutique</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
