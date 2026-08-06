{{-- Tunnel commande boutique : e-mail obligatoire (compte auto), devise USD/CDF, puis paiement --}}
<div class="modal fade" id="allianceCheckoutModal" tabindex="-1" aria-labelledby="allianceCheckoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="allianceCheckoutModalLabel"><i class="fa fa-shopping-bag me-2" style="color:#A86C3C;"></i> Finaliser la commande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div id="checkout-step-auth" class="checkout-step">
                    <p class="text-muted small mb-3">Indiquez votre <strong>adresse e-mail</strong> pour recevoir la confirmation. Aucun code ni mot de passe n’est demandé : un compte est associé automatiquement à cet e-mail.</p>
                    <label class="form-label small fw-bold" for="chk-guest-name">Nom (optionnel)</label>
                    <input type="text" class="form-control mb-2" id="chk-guest-name" autocomplete="name" placeholder="Votre nom">
                    <label class="form-label small fw-bold" for="chk-guest-email">E-mail <span class="text-danger">*</span></label>
                    <input type="email" class="form-control mb-3" id="chk-guest-email" autocomplete="email" required placeholder="vous@exemple.com">
                    <button type="button" class="btn w-100 text-white fw-bold" style="background:#A86C3C;" id="chk-guest-continue">Continuer</button>
                </div>

                <div id="checkout-step-summary" class="checkout-step d-none">
                    <p class="small text-muted mb-2">Commande pour <strong id="chk-summary-email"></strong> · <button type="button" class="btn btn-link btn-sm p-0 align-baseline" id="chk-back-auth">Modifier l’e-mail</button></p>
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3" id="checkout-currency-wrap">
                        <span class="small fw-bold">Payer en :</span>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Devise">
                            <button type="button" class="btn btn-outline-secondary js-checkout-currency active" data-currency="USD">USD</button>
                            <button type="button" class="btn btn-outline-secondary js-checkout-currency" data-currency="CDF">CDF</button>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-2">Récapitulatif</h6>
                    <ul class="list-unstyled small mb-3" id="checkout-summary-lines"></ul>
                    <div id="checkout-shipping-block" class="d-none border rounded p-3 mb-3 small bg-light">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="chk-shipping-enabled" autocomplete="off">
                            <label class="form-check-label fw-bold" for="chk-shipping-enabled">Ajouter la livraison</label>
                        </div>
                        <div id="checkout-shipping-fields" class="d-none">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small mb-0" for="chk-shipping-country">Pays</label>
                                    <select class="form-select form-select-sm" id="chk-shipping-country" autocomplete="country">
                                        <option value="">— Choisir —</option>
                                        <option value="CD">République démocratique du Congo</option>
                                        <option value="CG">Congo (Brazzaville)</option>
                                        <option value="FR">France</option>
                                        <option value="BE">Belgique</option>
                                        <option value="CA">Canada</option>
                                        <option value="US">États-Unis</option>
                                        <option value="GB">Royaume-Uni</option>
                                        <option value="DE">Allemagne</option>
                                        <option value="ZA">Afrique du Sud</option>
                                        <option value="RW">Rwanda</option>
                                        <option value="UG">Ouganda</option>
                                        <option value="KE">Kenya</option>
                                        <option value="TZ">Tanzanie</option>
                                        <option value="ZM">Zambie</option>
                                        <option value="AO">Angola</option>
                                        <option value="CM">Cameroun</option>
                                        <option value="SN">Sénégal</option>
                                        <option value="CI">Côte d’Ivoire</option>
                                        <option value="NG">Nigeria</option>
                                        <option value="NL">Pays-Bas</option>
                                        <option value="CH">Suisse</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small mb-0" for="chk-shipping-city">Ville</label>
                                    <input type="text" class="form-control form-control-sm" id="chk-shipping-city" placeholder="Ex. Lubumbashi" maxlength="120" autocomplete="address-level2">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small mb-0" for="chk-shipping-address">Adresse complète</label>
                                    <textarea class="form-control form-control-sm" id="chk-shipping-address" rows="3" maxlength="2000" placeholder="Commune, quartier, avenue, numéro, point de repère…" autocomplete="street-address"></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small mb-0" for="chk-shipping-phone">Téléphone de contact (livraison)</label>
                                    <input type="tel" class="form-control form-control-sm" id="chk-shipping-phone" placeholder="Ex. +243…" maxlength="40" autocomplete="tel">
                                </div>
                            </div>
                            <p class="text-muted small mt-2 mb-0">Tarif national pour le pays configuré sur le site (ex. RDC), tarif international pour les autres pays.</p>
                        </div>
                    </div>
                    <p class="mb-1 small text-muted">Sous-total articles : <strong id="checkout-summary-subtotal">0,00</strong> <span class="checkout-summary-cur">USD</span></p>
                    <p class="mb-1 small d-none" id="checkout-summary-shipping-line">Livraison : <strong id="checkout-summary-shipping-amount">0,00</strong> <span class="checkout-summary-cur">USD</span></p>
                    <p class="mb-3">Total : <strong id="checkout-summary-total">0,00 USD</strong></p>
                    <button type="button" class="btn w-100 text-white fw-bold mb-2 alliance-checkout-gold-btn" style="background:#A86C3C;" id="chk-confirm-order">Confirmer et payer</button>
                </div>

                <div id="checkout-step-pay" class="checkout-step d-none">
                    <p class="mb-2">Référence : <strong id="chk-pay-ref"></strong></p>
                    <p class="mb-3">Montant : <strong id="chk-pay-total"></strong></p>
                    <form id="chk-pay-form" class="row g-2">
                        @csrf
                        <input type="hidden" id="chk-pay-reference" name="reference">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Moyen de paiement</label>
                            <select class="form-select" id="chk-pay-channel" name="channel" required>
                                <option value="">Choisir…</option>
                                <option value="mobile_money">Mobile Money</option>
                                <option value="card">Carte bancaire</option>
                            </select>
                        </div>
                        <div class="col-12 d-none" id="chk-pay-phone-wrap">
                            <label class="form-label small fw-bold">Téléphone</label>
                            <input type="text" class="form-control" name="phone" id="chk-pay-phone" placeholder="243…">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark w-100" id="chk-pay-submit">Payer</button>
                        </div>
                    </form>
                    <div id="checkout-no-online-pay" class="d-none alert alert-info small mt-2">
                        Le paiement en ligne n’est pas activé. Votre commande peut être enregistrée — contactez le ministère pour le règlement.
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2 d-none" id="chk-order-offline">Enregistrer la commande (sans paiement en ligne)</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    var routes = window.allianceRoutes || {};
    var flexOn = window.allianceFlexPayEnabled === true;
    var checkoutCurrency = 'USD';
    var guestEmail = '';
    var guestName = '';

    function shopCfg() {
        return window.allianceShopCurrency || { rate: 2850, default: 'USD', allowSwitch: true };
    }

    function convertUsd(amountUsd, currency) {
        var n = Number(amountUsd) || 0;
        if (String(currency).toUpperCase() === 'CDF') {
            return Math.round(n * (Number(shopCfg().rate) || 2850) * 100) / 100;
        }
        return Math.round(n * 100) / 100;
    }

    function showStep(name) {
        document.querySelectorAll('.checkout-step').forEach(function(el) { el.classList.add('d-none'); });
        var map = { auth: 'checkout-step-auth', summary: 'checkout-step-summary', pay: 'checkout-step-pay' };
        var id = map[name];
        if (id) document.getElementById(id)?.classList.remove('d-none');
    }

    function cartPayload() {
        try { return JSON.parse(localStorage.getItem('alliance_cart') || '[]'); }
        catch (e) { return []; }
    }

    function escapeHtmlCheckout(s) {
        var d = document.createElement('div');
        d.textContent = s == null ? '' : String(s);
        return d.innerHTML;
    }

    function fmtMoneyCheckout(n, cur) {
        var v = Number(n) || 0;
        var digits = String(cur).toUpperCase() === 'CDF' ? 0 : 2;
        return v.toFixed(digits).replace('.', ',') + ' ' + (cur || 'USD');
    }

    function setShippingFieldsRequired(on) {
        ['chk-shipping-country', 'chk-shipping-city', 'chk-shipping-address', 'chk-shipping-phone'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.required = !!on;
        });
    }

    function syncShippingUi() {
        var cfg = window.allianceShippingConfig || {};
        var block = document.getElementById('checkout-shipping-block');
        var cb = document.getElementById('chk-shipping-enabled');
        var fields = document.getElementById('checkout-shipping-fields');
        if (!block) return;
        if (!cfg.enabled) {
            block.classList.add('d-none');
            if (cb) cb.checked = false;
            if (fields) fields.classList.add('d-none');
            setShippingFieldsRequired(false);
            return;
        }
        block.classList.remove('d-none');
        var on = !!(cb && cb.checked);
        if (fields) fields.classList.toggle('d-none', !on);
        setShippingFieldsRequired(on);
    }

    function syncCurrencyButtons() {
        document.querySelectorAll('.js-checkout-currency').forEach(function(btn) {
            btn.classList.toggle('active', btn.getAttribute('data-currency') === checkoutCurrency);
        });
        var wrap = document.getElementById('checkout-currency-wrap');
        if (wrap) wrap.classList.toggle('d-none', shopCfg().allowSwitch === false);
    }

    function refreshCheckoutSummary() {
        var cart = cartPayload();
        var ul = document.getElementById('checkout-summary-lines');
        if (!ul) return;
        ul.innerHTML = '';
        var subtotalUsd = 0;
        cart.forEach(function(item) {
            var unitUsd = parseFloat(item.price) || 0;
            var qty = item.qty || 1;
            subtotalUsd += unitUsd * qty;
            var unitDisp = convertUsd(unitUsd, checkoutCurrency);
            var li = document.createElement('li');
            li.className = 'mb-2 border-bottom pb-2 d-flex align-items-center gap-2';
            var thumb = item.cover_url
                ? '<img src="' + escapeHtmlCheckout(item.cover_url) + '" alt="" width="44" height="58" class="flex-shrink-0 rounded" style="object-fit:cover;">'
                : '';
            li.innerHTML = thumb +
                '<div class="min-w-0 flex-grow-1"><div class="fw-semibold">' + escapeHtmlCheckout(item.title || 'Article') + '</div>' +
                '<div class="small text-muted">× ' + qty +
                ' — ' + fmtMoneyCheckout(unitDisp, checkoutCurrency) +
                '</div></div>';
            ul.appendChild(li);
        });

        var cfg = window.allianceShippingConfig || {};
        var shipUsd = 0;
        if (cfg.enabled) {
            var cb = document.getElementById('chk-shipping-enabled');
            if (cb && cb.checked) {
                var code = (document.getElementById('chk-shipping-country') && document.getElementById('chk-shipping-country').value || '').toUpperCase();
                var domestic = (cfg.domesticCode || 'CD').toUpperCase();
                var shipRaw = 0;
                if (code && code === domestic) shipRaw = Number(cfg.domestic) || 0;
                else if (code) shipRaw = Number(cfg.international) || 0;
                var shipCur = String(cfg.currency || 'USD').toUpperCase();
                shipUsd = shipCur === 'CDF'
                    ? shipRaw / Math.max(Number(shopCfg().rate) || 2850, 0.0001)
                    : shipRaw;
            }
        }

        var subtotal = convertUsd(subtotalUsd, checkoutCurrency);
        var ship = convertUsd(shipUsd, checkoutCurrency);
        var total = Math.round((subtotal + ship) * 100) / 100;

        var subEl = document.getElementById('checkout-summary-subtotal');
        if (subEl) subEl.textContent = subtotal.toFixed(checkoutCurrency === 'CDF' ? 0 : 2).replace('.', ',');
        document.querySelectorAll('.checkout-summary-cur').forEach(function(el) { el.textContent = checkoutCurrency; });
        var sl = document.getElementById('checkout-summary-shipping-line');
        var sa = document.getElementById('checkout-summary-shipping-amount');
        if (sl && sa) {
            if (ship > 0) {
                sl.classList.remove('d-none');
                sa.textContent = ship.toFixed(checkoutCurrency === 'CDF' ? 0 : 2).replace('.', ',');
            } else {
                sl.classList.add('d-none');
            }
        }
        var t = document.getElementById('checkout-summary-total');
        if (t) t.textContent = fmtMoneyCheckout(total, checkoutCurrency);
    }

    var orderRef = null;
    var orderTotalStr = '';

    function toast(msg, variant) {
        if (window.allianceSiteToast) window.allianceSiteToast(msg, variant || 'error');
    }

    function setBtnLoading(btn, on) {
        if (window.allianceSetSubmitLoading) window.allianceSetSubmitLoading(btn, !!on);
        else if (btn) { btn.disabled = !!on; }
    }

    function goToSummary() {
        var emailEl = document.getElementById('chk-summary-email');
        if (emailEl) emailEl.textContent = guestEmail;
        syncCurrencyButtons();
        syncShippingUi();
        refreshCheckoutSummary();
        showStep('summary');
    }

    function resetCheckoutSensitiveFields() {
        var cb = document.getElementById('chk-shipping-enabled');
        if (cb) cb.checked = false;
        ['chk-shipping-country', 'chk-shipping-city', 'chk-shipping-address', 'chk-shipping-phone', 'chk-guest-name', 'chk-guest-email'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.value = '';
        });
        guestEmail = '';
        guestName = '';
        checkoutCurrency = shopCfg().default || 'USD';
        syncShippingUi();
        refreshCheckoutSummary();
        document.getElementById('chk-pay-phone-wrap')?.classList.add('d-none');
        var pp = document.getElementById('chk-pay-phone');
        if (pp) { pp.value = ''; pp.required = false; }
        var pch = document.getElementById('chk-pay-channel');
        if (pch) pch.value = '';
        document.getElementById('chk-pay-form')?.reset();
        orderRef = null;
        orderTotalStr = '';
    }

    window.allianceResetCheckoutModal = resetCheckoutSensitiveFields;

    document.getElementById('chk-guest-continue')?.addEventListener('click', function() {
        var email = document.getElementById('chk-guest-email')?.value?.trim();
        var name = document.getElementById('chk-guest-name')?.value?.trim() || '';
        if (!email || email.indexOf('@') < 1) {
            toast('Veuillez indiquer une adresse e-mail valide.', 'error');
            return;
        }
        guestEmail = email.toLowerCase();
        guestName = name;
        goToSummary();
    });

    document.getElementById('chk-back-auth')?.addEventListener('click', function() {
        showStep('auth');
    });

    document.querySelectorAll('.js-checkout-currency').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (shopCfg().allowSwitch === false) return;
            checkoutCurrency = btn.getAttribute('data-currency') || 'USD';
            if (window.allianceSetDisplayCurrency) window.allianceSetDisplayCurrency(checkoutCurrency);
            syncCurrencyButtons();
            refreshCheckoutSummary();
        });
    });

    document.getElementById('chk-shipping-enabled')?.addEventListener('change', function() {
        syncShippingUi();
        refreshCheckoutSummary();
    });
    document.getElementById('chk-shipping-country')?.addEventListener('change', refreshCheckoutSummary);

    document.getElementById('chk-confirm-order')?.addEventListener('click', function() {
        var cart = cartPayload();
        if (!cart.length) { toast('Panier vide.', 'error'); return; }
        if (!guestEmail) { showStep('auth'); toast('E-mail requis.', 'error'); return; }
        var items = cart.map(function(i) { return { id: i.id, qty: i.qty || 1 }; });
        var cfg = window.allianceShippingConfig || {};
        var shipPayload = { enabled: false };
        var cbShip = document.getElementById('chk-shipping-enabled');
        if (cfg.enabled && cbShip && cbShip.checked) {
            var cty = document.getElementById('chk-shipping-country')?.value?.trim();
            var city = document.getElementById('chk-shipping-city')?.value?.trim();
            var addr = document.getElementById('chk-shipping-address')?.value?.trim();
            var ph = document.getElementById('chk-shipping-phone')?.value?.trim();
            if (!cty || !city || !addr || !ph) {
                toast('Pour la livraison : pays, ville, adresse complète et numéro de contact sont requis.', 'error');
                return;
            }
            shipPayload = { enabled: true, country: cty.toUpperCase(), city: city, address: addr, phone: ph };
        }
        var btn = this;
        setBtnLoading(btn, true);
        fetch(routes.orderInit, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                email: guestEmail,
                name: guestName,
                currency: checkoutCurrency,
                items: items,
                shipping: shipPayload,
            }),
            credentials: 'same-origin',
        }).then(function(r) { return r.json().then(function(d) { return { r: r, d: d }; }); })
        .then(function(pair) {
            if (pair.r.ok && pair.d.success) {
                if (pair.d.user) window.allianceAuthUser = pair.d.user;
                orderRef = pair.d.reference;
                orderTotalStr = fmtMoneyCheckout(pair.d.total, pair.d.currency);
                document.getElementById('chk-pay-ref').textContent = orderRef;
                document.getElementById('chk-pay-total').textContent = orderTotalStr;
                document.getElementById('chk-pay-reference').value = orderRef;
                if (flexOn) {
                    document.getElementById('checkout-no-online-pay').classList.add('d-none');
                    document.getElementById('chk-order-offline').classList.add('d-none');
                    document.getElementById('chk-pay-form').classList.remove('d-none');
                } else {
                    document.getElementById('chk-pay-form').classList.add('d-none');
                    document.getElementById('checkout-no-online-pay').classList.remove('d-none');
                    document.getElementById('chk-order-offline').classList.remove('d-none');
                }
                showStep('pay');
            } else {
                toast(pair.d.message || 'Impossible de créer la commande.', 'error');
            }
        }).catch(function() { toast('Erreur réseau.', 'error'); })
        .finally(function() { setBtnLoading(btn, false); });
    });

    document.getElementById('chk-pay-channel')?.addEventListener('change', function() {
        var w = document.getElementById('chk-pay-phone-wrap');
        var p = document.getElementById('chk-pay-phone');
        if (this.value === 'mobile_money') {
            w.classList.remove('d-none');
            p.required = true;
        } else {
            w.classList.add('d-none');
            p.required = false;
        }
    });

    function releasePayButton(btn) {
        if (btn && window.allianceSetSubmitLoading) window.allianceSetSubmitLoading(btn, false);
        else if (btn) { btn.disabled = false; }
    }

    function pollChk(ref, payBtn) {
        var attempts = 0;
        var max = 14;
        var iv = setInterval(function() {
            attempts++;
            fetch(routes.paymentCheck + '?reference=' + encodeURIComponent(ref), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                .then(function(r) { return r.json(); })
                .then(function(response) {
                    if (response.reponse === true && Number(response.status) === 0) {
                        clearInterval(iv);
                        releasePayButton(payBtn);
                        if (window.allianceSiteToast) window.allianceSiteToast(response.message || 'Paiement effectué.', 'success');
                        if (window.allianceCart) window.allianceCart.clear();
                        resetCheckoutSensitiveFields();
                        bootstrap.Modal.getInstance(document.getElementById('allianceCheckoutModal'))?.hide();
                        bootstrap.Modal.getInstance(document.getElementById('allianceCartModal'))?.hide();
                    }
                    if (response.reponse === false && Number(response.status) === 1) {
                        clearInterval(iv);
                        releasePayButton(payBtn);
                        if (window.allianceSiteToast) window.allianceSiteToast(response.message || 'Paiement annulé.', 'error');
                    }
                    if (attempts >= max) {
                        clearInterval(iv);
                        releasePayButton(payBtn);
                        if (window.allianceSiteToast) window.allianceSiteToast('Délai de confirmation dépassé. Vérifiez plus tard ou contactez-nous.', 'info');
                    }
                }).catch(function() {});
        }, 5000);
    }

    document.getElementById('chk-pay-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!flexOn) return;
        var fd = new FormData(this);
        var body = {
            reference: fd.get('reference'),
            channel: fd.get('channel'),
            phone: fd.get('phone') || '',
        };
        var btn = document.getElementById('chk-pay-submit');
        setBtnLoading(btn, true);
        fetch(routes.paymentProcess, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(body),
            credentials: 'same-origin',
        }).then(function(r) { return r.json().then(function(d) { return { r: r, d: d }; }); })
        .then(function(pair) {
            var d = pair.d;
            if (d.reponse) {
                if (d.type === 'mobile') {
                    if (window.allianceSiteToast) window.allianceSiteToast(d.message || 'Validez le paiement sur votre téléphone.', 'info');
                    pollChk(d.orderNumber || body.reference, btn);
                } else if (d.redirect_url) {
                    try { sessionStorage.setItem('alliance_checkout_clear', '1'); } catch (err) {}
                    window.location.href = d.redirect_url;
                } else {
                    setBtnLoading(btn, false);
                }
            } else {
                toast(d.message || 'Le paiement n’a pas réussi.', 'error');
                setBtnLoading(btn, false);
            }
        }).catch(function() { toast('Erreur réseau.', 'error'); setBtnLoading(btn, false); });
    });

    document.getElementById('chk-order-offline')?.addEventListener('click', function() {
        if (window.allianceSiteToast) window.allianceSiteToast('Commande enregistrée. Nous vous contacterons.', 'success');
        if (window.allianceCart) window.allianceCart.clear();
        resetCheckoutSensitiveFields();
        bootstrap.Modal.getInstance(document.getElementById('allianceCheckoutModal'))?.hide();
        bootstrap.Modal.getInstance(document.getElementById('allianceCartModal'))?.hide();
    });

    document.getElementById('allianceCheckoutModal')?.addEventListener('show.bs.modal', function() {
        checkoutCurrency = (window.allianceGetDisplayCurrency && window.allianceGetDisplayCurrency()) || shopCfg().default || 'USD';
        var u = window.allianceAuthUser;
        if (u && u.email) {
            guestEmail = u.email;
            guestName = u.name || '';
            var ge = document.getElementById('chk-guest-email');
            var gn = document.getElementById('chk-guest-name');
            if (ge) ge.value = guestEmail;
            if (gn) gn.value = guestName;
            goToSummary();
        } else if (guestEmail) {
            goToSummary();
        } else {
            showStep('auth');
        }
    });

    document.getElementById('alliance-checkout-open')?.addEventListener('click', function(e) {
        e.preventDefault();
        var cart = cartPayload();
        if (!cart.length) {
            if (window.allianceSiteToast) window.allianceSiteToast('Panier vide.', 'error');
            return;
        }
        bootstrap.Modal.getInstance(document.getElementById('allianceCartModal'))?.hide();
        setTimeout(function() {
            var m = document.getElementById('allianceCheckoutModal');
            if (m && typeof bootstrap !== 'undefined') bootstrap.Modal.getOrCreateInstance(m).show();
        }, 400);
    });

    document.addEventListener('DOMContentLoaded', function() {
        checkoutCurrency = shopCfg().default || 'USD';
        try {
            if (sessionStorage.getItem('alliance_checkout_clear') === '1') {
                sessionStorage.removeItem('alliance_checkout_clear');
                if (typeof window.allianceResetCheckoutModal === 'function') {
                    window.allianceResetCheckoutModal();
                }
            }
        } catch (e) {}
    });
})();
</script>
