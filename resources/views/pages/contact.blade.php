@extends('layouts.app')

@section('page_banner_title', 'Contactez-nous')

@section('page_banner_breadcrumbs')
    <li>Contact</li>
@endsection

@section('content')

@php
    $contactEmail = config('mail.from.address');
@endphp

<div class="alliance-engagement-page-wrap">
    <section class="alliance-engagement-intro">
        <div class="auto-container">
            <div class="sec-title text-center">
                <span class="sub-title">Échangeons ensemble</span>
                <h2>Une question, un projet, une prière ?</h2>
                <div class="text mx-auto" style="max-width:640px;">Alliance reste à votre écoute. Écrivez-nous ou prenez rendez-vous : nous vous répondrons dans les meilleurs délais.</div>
            </div>
        </div>
    </section>

    <section class="contact-section alliance-engagement-contact">
		<div class="bg bg-pattern-6"></div>
		@include('partials.engagement-bg-image', ['filename' => 'alliance-engagement-contact.png', 'alt' => 'Portrait — Alliance, nous contacter'])
		<div class="auto-container">
			<div class="row">
				<!-- Title Column -->
				<div class="title-column col-lg-6 col-md-12">
					<div class="inner-column">
						<div class="sec-title">
							<span class="sub-title">Contactez-nous</span>
							<h2>Travaillons ensemble ?</h2>
							<div class="text">Que ce soit pour un renseignement, un encouragement ou un projet lié au ministère, votre message nous importe. Nous lisons chaque demande avec attention.</div>
						</div>

						<div class="contact-info-block">
							<div class="inner">
								<i class="icon fa fa-envelope"></i>
								<h6 class="title">Écrire par e-mail</h6>
								<div class="text">
									@if($contactEmail)
										<a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
									@else
										Utilisez le formulaire ci-contre : nous vous répondrons sur l’adresse indiquée.
									@endif
								</div>
							</div>
						</div>

						<div class="contact-info-block">
							<div class="inner">
								<i class="icon fa fa-calendar-alt"></i>
								<h6 class="title">Prendre rendez-vous</h6>
								<div class="text"><a href="{{ route('appointment.create') }}">Demander un rendez-vous en ligne</a></div>
							</div>
						</div>

						<div class="contact-info-block">
							<div class="inner">
								<i class="icon fa fa-heart"></i>
								<h6 class="title">Soutenir le ministère</h6>
								<div class="text"><a href="{{ route('donate.create') }}">Faire un don</a> ou <a href="{{ route('partner.create') }}">devenir partenaire</a></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Form Column -->
				<div class="form-column col-lg-6 col-md-12 col-sm-12">
					<div class="inner-column">
						<div class="contact-form wow fadeInLeft">
							<h2 class="title">Envoyez-nous un message</h2>

							@if(session('success'))
								<div class="alert alert-success mb-4" style="border-radius:8px;">
									<i class="fa fa-check-circle"></i> {{ session('success') }}
								</div>
							@endif

							<form method="POST" action="{{ route('contact.store') }}" id="contact-page-form">
								@csrf
								<div class="row">
									<div class="form-group col-lg-12">
										<input type="text" name="name" value="{{ old('name') }}" placeholder="Votre nom complet" required autocomplete="name">
										@error('name') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
									</div>

									<div class="form-group col-lg-12">
										<input type="email" name="email" value="{{ old('email') }}" placeholder="Adresse e-mail" required autocomplete="email">
										@error('email') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
									</div>

									<div class="form-group col-lg-12">
										<input type="text" name="phone" value="{{ old('phone') }}" placeholder="Téléphone (optionnel)" autocomplete="tel">
										@error('phone') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
									</div>

									<div class="form-group col-lg-12">
										<input type="text" name="subject" value="{{ old('subject') }}" placeholder="Sujet de votre message" required>
										@error('subject') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
									</div>

									<div class="form-group col-lg-12">
										<textarea name="body" rows="5" placeholder="Votre message" required>{{ old('body') }}</textarea>
										@error('body') <small class="d-block mt-1" style="color:#dc3545;">{{ $message }}</small> @enderror
									</div>

									<div class="form-group col-lg-12">
										<button class="theme-btn btn-style-one hvr-dark" type="submit" name="submit-form"><span class="btn-title">Envoyer le message</span></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (new URLSearchParams(window.location.search).get('from') !== 'cart' || !window.allianceCart) return;
    var cart = window.allianceCart.get();
    if (!cart.length) return;
    var ta = document.querySelector('#contact-page-form textarea[name="body"]');
    if (!ta || ta.value.trim()) return;
    var lines = cart.map(function(i) {
        var cur = i.currency || 'USD';
        var p = i.price != null ? ' — ' + Number(i.price).toFixed(2).replace('.', ',') + ' ' + cur : '';
        return '• ' + i.title + ' ×' + (i.qty || 1) + p;
    });
    ta.value = 'Bonjour,\n\nJe souhaite commander les ouvrages suivants :\n\n' + lines.join('\n') + '\n\nMerci de me recontacter.';
});
</script>
@endpush
