{{-- Modale don / partenaire + paiement sécurisé (si activé) --}}
<div class="modal fade" id="donatePartnerModal" tabindex="-1" aria-labelledby="donatePartnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content alliance-donate-modal" style="border:none;border-radius:16px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.2);">
            <div class="modal-header text-white border-0" style="background:linear-gradient(135deg,#141414 0%,#3d2a1c 55%,#A86C3C 180%);padding:1.25rem 1.5rem;">
                <div>
                    <h5 class="modal-title mb-0" id="donatePartnerModalLabel"><i class="fa fa-heart me-2"></i> Soutenir le ministère</h5>
                    <small class="opacity-75">Don ou engagement partenaire — paiement sécurisé lorsque le service est activé</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-0">
                <div id="donate-modal-alert" class="alert d-none mx-3 mt-3 mb-0" role="alert"></div>
                <ul class="nav nav-pills nav-fill px-3 pt-3 gap-2" id="donateModalTabs" role="tablist" style="flex-wrap:wrap;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill" id="tab-don" data-bs-toggle="pill" data-bs-target="#pane-don" type="button" role="tab">Faire un don</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill" id="tab-partner" data-bs-toggle="pill" data-bs-target="#pane-partner" type="button" role="tab">Devenir partenaire</button>
                    </li>
                </ul>

                <div class="tab-content p-4">
                    {{-- ONGLET DON --}}
                    <div class="tab-pane fade show active" id="pane-don" role="tabpanel">
                        <div id="don-step1">
                            <form id="formModalDon" class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Montant *</label>
                                    <input type="number" name="montant" id="modal_montant" class="form-control form-control-lg" min="1" step="0.01" required placeholder="Ex. 25">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Devise</label>
                                    <select name="currency" id="modal_currency_don" class="form-select form-select-lg" required>
                                        <option value="CDF" selected>Franc congolais (CDF)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nom @unless(config('services.flexpay.enabled'))*@endunless</label>
                                    <input type="text" name="nom" id="modal_nom" class="form-control" placeholder="Nom complet" @unless(config('services.flexpay.enabled')) required @endunless>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">E-mail @unless(config('services.flexpay.enabled'))*@endunless</label>
                                    <input type="email" name="email" id="modal_email" class="form-control" placeholder="email@exemple.com" @unless(config('services.flexpay.enabled')) required @endunless>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Téléphone</label>
                                    <input type="tel" name="donor_phone" id="modal_phone_don" class="form-control" placeholder="Optionnel">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Fréquence</label>
                                    <div class="d-flex gap-3 flex-wrap">
                                        <label class="d-flex align-items-center gap-2"><input type="radio" name="frequency" value="once" checked> Don unique</label>
                                        <label class="d-flex align-items-center gap-2"><input type="radio" name="frequency" value="monthly"> Don mensuel</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Message</label>
                                    <textarea name="message" id="modal_message_don" class="form-control" rows="2" placeholder="Optionnel"></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="d-flex align-items-center gap-2"><input type="checkbox" name="is_anonymous" value="1" id="modal_anon"> Don anonyme</label>
                                </div>
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-lg text-white fw-bold" style="background:#A86C3C;border:none;" id="btnModalDonSubmit">
                                        @if(config('services.flexpay.enabled'))
                                            Continuer vers le paiement
                                        @else
                                            Enregistrer mon don
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                        @if(config('services.flexpay.enabled'))
                        <div id="don-step2" class="d-none mt-3 pt-3 border-top">
                            <p class="mb-3">Total : <strong id="don_total_display">0 CDF</strong></p>
                            <form id="formModalDonPay">
                                @csrf
                                <input type="hidden" name="reference" id="don_reference">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Moyen de paiement *</label>
                                    <select name="channel" id="don_channel" class="form-select" required>
                                        <option value="">Choisir…</option>
                                        <option value="mobile_money">Mobile Money</option>
                                        <option value="card">Carte bancaire</option>
                                    </select>
                                </div>
                                <div class="mb-3 d-none" id="don_phone_wrap">
                                    <label class="form-label small fw-bold">Téléphone Mobile Money</label>
                                    <input type="text" name="phone" id="don_phone" class="form-control" placeholder="243…">
                                </div>
                                <div class="mb-3">
                                    <label class="d-flex align-items-start gap-2 small">
                                        <input type="checkbox" id="don_cgu" required>
                                        J'accepte les conditions et confirme mon don.
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 btn-lg" id="btnDonPay">Payer</button>
                                <button type="button" class="btn btn-link w-100 mt-2" id="btnDonBack">← Modifier le montant</button>
                            </form>
                        </div>
                        @endif
                    </div>

                    {{-- ONGLET PARTENAIRE : compte créé en même temps que l’engagement --}}
                    <div class="tab-pane fade" id="pane-partner" role="tabpanel">
                        <div id="partner-step1">
                            <p class="small text-muted mb-3">
                                @guest
                                    Remplissez le formulaire : votre compte est créé automatiquement avec l’e-mail indiqué (comme pour une commande boutique).
                                @else
                                    Votre engagement sera lié à votre compte <strong>{{ auth()->user()->email }}</strong>.
                                @endguest
                            </p>
                            <form id="formModalPartner" class="row g-3">
                                @csrf
                                @guest
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nom complet *</label>
                                    <input type="text" name="name" id="modal_partner_name" class="form-control" placeholder="Nom complet" required autocomplete="name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">E-mail *</label>
                                    <input type="email" name="email" id="modal_partner_email" class="form-control" placeholder="email@exemple.com" required autocomplete="email">
                                </div>
                                @endguest
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Montant mensuel *</label>
                                    <input type="number" name="monthly_amount" id="modal_partner_amount" class="form-control form-control-lg" min="1" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Devise *</label>
                                    <select name="currency" id="modal_currency_partner" class="form-select form-select-lg" required>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="CDF">CDF</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Message</label>
                                    <textarea name="message" id="modal_message_partner" class="form-control" rows="2"></textarea>
                                </div>
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-lg text-white fw-bold" style="background:#A86C3C;border:none;" id="btnModalPartnerSubmit">
                                        @if(config('services.flexpay.enabled'))
                                            Continuer vers le paiement
                                        @else
                                            Envoyer ma demande
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                        @if(config('services.flexpay.enabled'))
                        <div id="partner-step2" class="d-none mt-3 pt-3 border-top">
                            <p class="mb-3">Premier versement : <strong id="partner_total_display">0 USD</strong></p>
                            <form id="formModalPartnerPay">
                                @csrf
                                <input type="hidden" name="reference" id="partner_reference">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Moyen de paiement *</label>
                                    <select name="channel" id="partner_channel" class="form-select" required>
                                        <option value="">Choisir…</option>
                                        <option value="mobile_money">Mobile Money</option>
                                        <option value="card">Carte bancaire</option>
                                    </select>
                                </div>
                                <div class="mb-3 d-none" id="partner_phone_wrap">
                                    <label class="form-label small fw-bold">Téléphone</label>
                                    <input type="text" name="phone" id="partner_phone" class="form-control" placeholder="243…">
                                </div>
                                <div class="mb-3">
                                    <label class="d-flex align-items-start gap-2 small">
                                        <input type="checkbox" id="partner_cgu" required>
                                        J'accepte les conditions de partenariat.
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 btn-lg" id="btnPartnerPay">Payer</button>
                                <button type="button" class="btn btn-link w-100 mt-2" id="btnPartnerBack">← Modifier</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    const flexpayEnabled = @json((bool) config('services.flexpay.enabled'));
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const checkUrl = @json(route('payment.check'));

    function showDonateAlert(msg, isError) {
        const el = document.getElementById('donate-modal-alert');
        if (!el) {
            if (window.allianceSiteToast) window.allianceSiteToast(msg, isError ? 'error' : 'success');
            return;
        }
        el.textContent = msg;
        el.classList.remove('d-none', 'alert-success', 'alert-danger', 'alert-info');
        el.classList.add(isError ? 'alert-danger' : 'alert-success');
    }

    function hideDonateAlert() {
        const el = document.getElementById('donate-modal-alert');
        if (el) {
            el.classList.add('d-none');
            el.textContent = '';
        }
    }

    function postJson(url, body) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(body),
        }).then(r => r.json());
    }

    function releaseDonatePayBtn(btn) {
        if (!btn) return;
        if (window.allianceSetSubmitLoading) window.allianceSetSubmitLoading(btn, false);
        else { btn.disabled = false; }
    }

    function pollPayment(ref, payBtn) {
        let attempts = 0;
        const max = 14;
        const iv = setInterval(() => {
            attempts++;
            fetch(checkUrl + '?reference=' + encodeURIComponent(ref), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                .then(r => r.json())
                .then(response => {
                    if (response.reponse === true && Number(response.status) === 0) {
                        clearInterval(iv);
                        releaseDonatePayBtn(payBtn);
                        showDonateAlert(response.message || 'Paiement effectué. Merci !', false);
                        if (window.allianceSiteToast) window.allianceSiteToast(response.message || 'Merci pour votre don !', 'success');
                        const modalEl = document.getElementById('donatePartnerModal');
                        const modal = modalEl && bootstrap.Modal.getInstance(modalEl);
                        setTimeout(function() { modal?.hide(); }, 800);
                    }
                    if (response.reponse === false && Number(response.status) === 1) {
                        clearInterval(iv);
                        releaseDonatePayBtn(payBtn);
                        showDonateAlert(response.message || 'Paiement annulé', true);
                    }
                    if (attempts >= max) {
                        clearInterval(iv);
                        releaseDonatePayBtn(payBtn);
                        showDonateAlert('Délai de confirmation dépassé. Vérifiez plus tard ou contactez-nous.', true);
                    }
                })
                .catch(() => {});
        }, 5000);
    }

    document.getElementById('formModalDon')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnModalDonSubmit');
        btn.disabled = true;
        const fd = new FormData(this);
        const payload = {
            montant: fd.get('montant'),
            currency: fd.get('currency'),
            nom: fd.get('nom'),
            email: fd.get('email'),
            message: fd.get('message'),
            frequency: fd.get('frequency'),
            is_anonymous: !!fd.get('is_anonymous'),
            donor_phone: fd.get('donor_phone') || null,
        };
        try {
            if (flexpayEnabled) {
                const data = await postJson(@json(route('payment.init.don')), payload);
                if (!data.success) { showDonateAlert(data.message || 'Erreur', true); return; }
                document.getElementById('don_reference').value = data.reference;
                document.getElementById('don_total_display').textContent = data.total + ' ' + data.currency;
                document.getElementById('don-step1').classList.add('d-none');
                document.getElementById('don-step2').classList.remove('d-none');
            } else {
                const classic = new URLSearchParams();
                classic.append('_token', csrf);
                classic.append('donor_name', fd.get('nom') || '');
                classic.append('donor_email', fd.get('email') || '');
                classic.append('donor_phone', fd.get('donor_phone') || '');
                classic.append('amount', fd.get('montant'));
                classic.append('currency', fd.get('currency'));
                classic.append('frequency', fd.get('frequency') || 'once');
                classic.append('message', fd.get('message') || '');
                if (fd.get('is_anonymous')) classic.append('is_anonymous', '1');
                const res = await fetch(@json(route('donate.store')), {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
                    body: classic,
                });
                const json = await res.json().catch(() => ({}));
                if (res.ok && json.success) {
                    showDonateAlert(json.message || 'Merci !', false);
                    if (window.allianceSiteToast) window.allianceSiteToast(json.message || 'Merci !', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('donatePartnerModal'))?.hide();
                    this.reset();
                } else {
                    const msg = json.errors ? Object.values(json.errors).flat().join(' ') : (json.message || 'Vérifiez les champs obligatoires.');
                    showDonateAlert(msg, true);
                }
            }
        } catch (err) {
            console.error(err);
            showDonateAlert('Erreur réseau', true);
        } finally {
            btn.disabled = false;
        }
    });

    document.getElementById('don_channel')?.addEventListener('change', function() {
        const wrap = document.getElementById('don_phone_wrap');
        const input = document.getElementById('don_phone');
        if (this.value === 'mobile_money') { wrap.classList.remove('d-none'); input.required = true; }
        else { wrap.classList.add('d-none'); input.required = false; }
    });

    document.getElementById('btnDonBack')?.addEventListener('click', function() {
        document.getElementById('don-step2').classList.add('d-none');
        document.getElementById('don-step1').classList.remove('d-none');
    });

    document.getElementById('formModalDonPay')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!document.getElementById('don_cgu').checked) { showDonateAlert('Veuillez accepter les conditions.', true); return; }
        const btn = document.getElementById('btnDonPay');
        let mobilePoll = false;
        if (window.allianceSetSubmitLoading) window.allianceSetSubmitLoading(btn, true);
        else btn.disabled = true;
        const fd = new FormData(this);
        const body = { reference: fd.get('reference'), channel: fd.get('channel'), phone: fd.get('phone') };
        try {
            const data = await postJson(@json(route('payment.process')), body);
            if (data.reponse) {
                if (data.type === 'mobile') {
                    mobilePoll = true;
                    showDonateAlert(data.message || 'Validez le paiement sur votre téléphone.', false);
                    if (window.allianceSiteToast) window.allianceSiteToast(data.message || 'Validez le paiement sur votre téléphone.', 'info');
                    pollPayment(data.orderNumber || body.reference, btn);
                } else if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            } else {
                showDonateAlert(data.message || 'Échec', true);
            }
        } catch (err) { showDonateAlert('Erreur réseau', true); }
        finally {
            if (!mobilePoll) releaseDonatePayBtn(btn);
        }
    });

    document.getElementById('formModalPartner')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnModalPartnerSubmit');
        btn.disabled = true;
        const fd = new FormData(this);
        const payload = {
            monthly_amount: fd.get('monthly_amount'),
            currency: fd.get('currency'),
            message: fd.get('message'),
        };
        if (fd.get('name')) payload.name = fd.get('name');
        if (fd.get('email')) payload.email = fd.get('email');
        try {
            if (flexpayEnabled) {
                const data = await postJson(@json(route('payment.init.partner')), payload);
                if (!data.success) {
                    const msg = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Erreur');
                    showDonateAlert(msg, true);
                    return;
                }
                document.getElementById('partner_reference').value = data.reference;
                document.getElementById('partner_total_display').textContent = data.total + ' ' + data.currency;
                document.getElementById('partner-step1').classList.add('d-none');
                document.getElementById('partner-step2').classList.remove('d-none');
            } else {
                const classic = new URLSearchParams();
                classic.append('_token', csrf);
                classic.append('monthly_amount', payload.monthly_amount);
                classic.append('currency', payload.currency);
                classic.append('message', payload.message || '');
                if (payload.name) classic.append('name', payload.name);
                if (payload.email) classic.append('email', payload.email);
                const res = await fetch(@json(route('partner.store')), {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
                    body: classic,
                });
                const json = await res.json().catch(() => ({}));
                if (res.ok && json.success) {
                    showDonateAlert(json.message || 'Merci !', false);
                    if (window.allianceSiteToast) window.allianceSiteToast(json.message || 'Merci !', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('donatePartnerModal'))?.hide();
                    this.reset();
                } else {
                    const msg = json.errors ? Object.values(json.errors).flat().join(' ') : (json.message || 'Erreur');
                    showDonateAlert(msg, true);
                }
            }
        } catch (err) { showDonateAlert('Erreur réseau', true); }
        finally { btn.disabled = false; }
    });

    document.getElementById('partner_channel')?.addEventListener('change', function() {
        const wrap = document.getElementById('partner_phone_wrap');
        const input = document.getElementById('partner_phone');
        if (this.value === 'mobile_money') { wrap.classList.remove('d-none'); input.required = true; }
        else { wrap.classList.add('d-none'); input.required = false; }
    });

    document.getElementById('btnPartnerBack')?.addEventListener('click', function() {
        document.getElementById('partner-step2').classList.add('d-none');
        document.getElementById('partner-step1').classList.remove('d-none');
    });

    document.getElementById('formModalPartnerPay')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!document.getElementById('partner_cgu').checked) { showDonateAlert('Veuillez accepter les conditions.', true); return; }
        const btn = document.getElementById('btnPartnerPay');
        let mobilePoll = false;
        if (window.allianceSetSubmitLoading) window.allianceSetSubmitLoading(btn, true);
        else btn.disabled = true;
        const fd = new FormData(this);
        const body = { reference: fd.get('reference'), channel: fd.get('channel'), phone: fd.get('phone') };
        try {
            const data = await postJson(@json(route('payment.process')), body);
            if (data.reponse) {
                if (data.type === 'mobile') {
                    mobilePoll = true;
                    showDonateAlert(data.message || 'Validez le paiement sur votre téléphone.', false);
                    if (window.allianceSiteToast) window.allianceSiteToast(data.message || 'Validez le paiement sur votre téléphone.', 'info');
                    pollPayment(data.orderNumber || body.reference, btn);
                } else if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            } else {
                showDonateAlert(data.message || 'Échec', true);
            }
        } catch (err) { showDonateAlert('Erreur réseau', true); }
        finally {
            if (!mobilePoll) releaseDonatePayBtn(btn);
        }
    });

    document.getElementById('donatePartnerModal')?.addEventListener('hidden.bs.modal', function() {
        hideDonateAlert();
        document.getElementById('don-step1')?.classList.remove('d-none');
        document.getElementById('don-step2')?.classList.add('d-none');
        document.getElementById('partner-step1')?.classList.remove('d-none');
        document.getElementById('partner-step2')?.classList.add('d-none');
        document.getElementById('formModalDon')?.reset();
        document.getElementById('formModalDonPay')?.reset();
        document.getElementById('formModalPartner')?.reset();
        document.getElementById('formModalPartnerPay')?.reset();
    });

    document.querySelectorAll('.js-donate-modal-partner').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const modalEl = document.getElementById('donatePartnerModal');
            if (!modalEl || typeof bootstrap === 'undefined') return;
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
            setTimeout(function() {
                const tabTrigger = document.getElementById('tab-partner');
                if (tabTrigger) bootstrap.Tab.getOrCreateInstance(tabTrigger).show();
            }, 350);
        });
    });
})();
</script>
@endpush
