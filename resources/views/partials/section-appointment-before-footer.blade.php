{{-- Bloc rendez-vous : affiché en bas de toutes les pages publiques (avant le footer), sauf la page dédiée /rendez-vous --}}
@if(! request()->routeIs('appointment.create'))
 {{-- ═══ APPEL AU DON ═══ --}}
    <!-- Call to Action - Soutenir le ministère -->
    <section class="call-to-action-home4 p-0">
        <div class="auto-container">
            <div class="outer-box wow fadeIn">
                <div class="content-box">
                    <div class="title-box mb-4 mb-lg-0">
                        <h3 class="title mb-0 text-white">Votre soutien permet de toucher <br> des vies à travers la Parole de Dieu</h3>
                    </div>
                    <div class="btn-box mb-0 alliance-donate-partner-row">
                        <a href="#" class="theme-btn btn-style-one hvr-dark" data-bs-toggle="modal" data-bs-target="#donatePartnerModal"><span class="btn-title"><i class="fa fa-heart"></i> Faire un don</span></a>
                        <a href="#" class="theme-btn alliance-btn-partner js-donate-modal-partner"><span class="btn-title"><i class="fa fa-handshake"></i> Devenir partenaire</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Call to Action -->
    <section class="contact-section-three">
        <div class="auto-container">
            <div class="row">
                <div class="info-column col-md-6">
                    <div class="inner-column wow fadeInRight">
                        <div class="sec-title light">
                            <div class="sub-title">Rendez-vous</div>
                            <h2>Prenez rendez-vous avec la Pasteure</h2>
                            <div class="text">Besoin d'un entretien spirituel, d'un conseil ou d'un accompagnement personnel ? Remplissez le formulaire et nous vous recontacterons rapidement.</div>
                        </div>

                        <div class="contact-info-box-two">
                            <span class="icon fa fa-map-marker-alt"></span>
                            <h6 class="title">Nous rendre visite</h6>
                            <div class="text">Centre Missionnaire Philadelphie<br>N°17, Av. Nyangwe 1, Q/ Lido Golf — Lubumbashi</div>
                        </div>

                        <div class="contact-info-box-two">
                            <span class="icon fa fa-envelope"></span>
                            <h6 class="title">Adresse e-mail</h6>
                            <div class="text"><a href="mailto:contact@alliance-ministere.com">contact@alliance-ministere.com</a></div>
                        </div>

                        <div class="contact-info-box-two">
                            <span class="icon fa fa-phone"></span>
                            <h6 class="title">Appelez-nous</h6>
                            <div class="text"><a href="tel:+243816681958">+243 816 681 958</a></div>
                        </div>
                    </div>
                </div>

                <div class="form-column col-md-6">
                    <div class="inner-column">
                        <div class="contact-form-home4 wow fadeInLeft">
                            @if(session('appointment_success'))
                                <div class="alert alert-success mb-3">{{ session('appointment_success') }}</div>
                            @endif
                            @if($errors->any() && old('home_appointment') == '1')
                                <div class="alert alert-danger mb-3" role="alert">
                                    <strong>Veuillez corriger les champs ci-dessous.</strong>
                                    <ul class="mb-0 mt-2 ps-3">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('appointment.store') }}" id="home-appointment-form">
                                @csrf
                                <input type="hidden" name="home_appointment" value="1">
                                <div class="row">
                                    <div class="mb-15 col-lg-6">
                                        <label class="field-label" for="home-rdv-name">Nom complet <span class="field-hint">(obligatoire)</span></label>
                                        <input id="home-rdv-name" type="text" name="name" placeholder="Votre nom complet" value="{{ old('name') }}" required>
                                        @error('name') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="mb-15 col-lg-6">
                                        <label class="field-label" for="home-rdv-email">Adresse e-mail <span class="field-hint">(obligatoire)</span></label>
                                        <input id="home-rdv-email" type="email" name="email" placeholder="Adresse e-mail" value="{{ old('email') }}" required>
                                        @error('email') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="mb-15 col-lg-6">
                                        <label class="field-label" for="home-rdv-phone">Téléphone <span class="field-hint">(optionnel)</span></label>
                                        <input id="home-rdv-phone" type="tel" name="phone" placeholder="Numéro de téléphone" value="{{ old('phone') }}">
                                        @error('phone') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="mb-15 col-lg-6">
                                        <label class="field-label" for="home-rdv-date">Date souhaitée <span class="field-hint">(obligatoire)</span></label>
                                        <input id="home-rdv-date" type="date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                                        @error('preferred_date') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="mb-15 col-lg-12">
                                        <label class="field-label" for="home-rdv-time">Heure souhaitée <span class="field-hint">(obligatoire)</span></label>
                                        <select id="home-rdv-time" name="preferred_time" required>
                                            <option value="" disabled {{ old('preferred_time') ? '' : 'selected' }}>Choisir un créneau</option>
                                            <option value="08:00" {{ old('preferred_time') == '08:00' ? 'selected' : '' }}>08h00 - 09h00</option>
                                            <option value="09:00" {{ old('preferred_time') == '09:00' ? 'selected' : '' }}>09h00 - 10h00</option>
                                            <option value="10:00" {{ old('preferred_time') == '10:00' ? 'selected' : '' }}>10h00 - 11h00</option>
                                            <option value="11:00" {{ old('preferred_time') == '11:00' ? 'selected' : '' }}>11h00 - 12h00</option>
                                            <option value="14:00" {{ old('preferred_time') == '14:00' ? 'selected' : '' }}>14h00 - 15h00</option>
                                            <option value="15:00" {{ old('preferred_time') == '15:00' ? 'selected' : '' }}>15h00 - 16h00</option>
                                            <option value="16:00" {{ old('preferred_time') == '16:00' ? 'selected' : '' }}>16h00 - 17h00</option>
                                        </select>
                                        @error('preferred_time') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="mb-15 col-lg-12">
                                        <label class="field-label" for="home-rdv-message">Motif du rendez-vous <span class="field-hint">(optionnel)</span></label>
                                        <textarea id="home-rdv-message" name="message" placeholder="Décrivez brièvement le motif de votre rendez-vous..." cols="30" rows="5">{{ old('message') }}</textarea>
                                        @error('message') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="mb-15 col-lg-12">
                                        <button class="theme-btn btn-style-one hvr-light" type="submit"><span class="btn-title"><i class="fa fa-calendar-check"></i> Demander un rendez-vous</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
