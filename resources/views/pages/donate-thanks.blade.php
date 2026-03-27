@extends('layouts.app')

@section('page_banner_title', 'Merci')

@section('page_banner_image')
{{ asset('assets/images/background/2.jpg') }}
@endsection

@section('page_banner_breadcrumbs')
    <li>Confirmation</li>
@endsection

@section('content')

    <section class="contact-details">
        <div class="auto-container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="sec-title">
                        <span class="sub-title">Alliance</span>
                        <h2>{{ session('message', 'Merci pour votre soutien !') }}</h2>
                        @if(session('reference'))
                            <div class="text mt-3">Référence : <strong>{{ session('reference') }}</strong></div>
                        @endif
                        @if(session('amount'))
                            <div class="text">Montant : <strong>{{ session('amount') }} {{ session('currency', 'USD') }}</strong></div>
                        @endif
                    </div>
                    <a href="{{ route('home') }}" class="theme-btn btn-style-one mt-4"><span class="btn-title">Retour à l'accueil</span></a>
                </div>
            </div>
        </div>
    </section>
@endsection
