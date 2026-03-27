@extends('layouts.app')

@section('page_banner_title', 'Prendre rendez-vous')

@section('page_banner_breadcrumbs')
    <li>Rendez-vous</li>
@endsection

@section('content')

    <!-- Appointment Section -->
    <section class="contact-details">
        <div class="auto-container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12">
                    <div class="sec-title text-center">
                        <span class="sub-title">Accompagnement spirituel</span>
                        <h2>Demandez un rendez-vous</h2>
                        <div class="text">Demandez un entretien personnel avec la Pasteure pour un accompagnement spirituel, une prière ou un conseil.</div>
                    </div>

                    @if(session('appointment_success'))
                        <div class="alert alert-success mb-4" style="border-radius:8px;">
                            <i class="fa fa-check-circle"></i> {{ session('appointment_success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger mb-4" style="border-radius:8px;" role="alert">
                            <strong>Certains champs sont incorrects.</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('appointment.store') }}" class="contact-form" id="appointment-page-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <label>Nom complet <span class="text-muted" style="font-weight:400;">(obligatoire)</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Votre nom complet" required>
                                @error('name') <small style="color:#dc3545;display:block;margin-top:4px;">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <label>Adresse e-mail <span class="text-muted" style="font-weight:400;">(obligatoire)</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Votre adresse e-mail" required>
                                @error('email') <small style="color:#dc3545;display:block;margin-top:4px;">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <label>Téléphone <span class="text-muted" style="font-weight:400;">(optionnel)</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Votre numéro">
                                @error('phone') <small style="color:#dc3545;display:block;margin-top:4px;">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <label>Date souhaitée <span class="text-muted" style="font-weight:400;">(obligatoire)</span></label>
                                <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                                @error('preferred_date') <small style="color:#dc3545;display:block;margin-top:4px;">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <label>Heure souhaitée <span class="text-muted" style="font-weight:400;">(optionnel)</span></label>
                                <select name="preferred_time" class="form-control">
                                    <option value="">Pas de préférence</option>
                                    <option value="matin" {{ old('preferred_time') === 'matin' ? 'selected' : '' }}>Matin (9h – 12h)</option>
                                    <option value="apres-midi" {{ old('preferred_time') === 'apres-midi' ? 'selected' : '' }}>Après-midi (14h – 17h)</option>
                                    <option value="soir" {{ old('preferred_time') === 'soir' ? 'selected' : '' }}>Soir (18h – 20h)</option>
                                </select>
                                @error('preferred_time') <small style="color:#dc3545;display:block;margin-top:4px;">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <label>Motif de la demande <span class="text-muted" style="font-weight:400;">(optionnel)</span></label>
                                <textarea name="message" rows="4" placeholder="Décrivez brièvement le motif de votre rendez-vous…">{{ old('message') }}</textarea>
                                @error('message') <small style="color:#dc3545;display:block;margin-top:4px;">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
                                <button class="theme-btn btn-style-one" type="submit">
                                    <span class="btn-title">Envoyer la demande</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
