{{-- Même flux que la boutique (code e-mail sans mot de passe). Hors .page-wrapper via @stack('modals'). --}}
<div class="modal fade" id="allianceOtpAuthModal" tabindex="-1" aria-labelledby="allianceOtpAuthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="allianceOtpAuthModalLabel"><i class="fa fa-user-circle me-2" style="color:#C8922A;"></i> Connexion ou inscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3">Comme pour finaliser une commande : <strong>code reçu par e-mail</strong>, sans mot de passe. Votre compte est enregistré dans la base <strong>users</strong> après validation du code.</p>
                <ul class="nav nav-pills nav-fill mb-3 gap-2" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill" id="aot-tab-login" data-bs-toggle="pill" data-bs-target="#aot-pane-login" type="button" role="tab">Connexion</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill" id="aot-tab-reg" data-bs-toggle="pill" data-bs-target="#aot-pane-reg" type="button" role="tab">Créer un compte</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="aot-pane-login" role="tabpanel">
                        <div id="aot-login-1">
                            <label class="form-label small fw-bold">E-mail</label>
                            <input type="email" class="form-control mb-2" id="aot-login-email" autocomplete="username">
                            <button type="button" class="btn w-100 text-white fw-bold" style="background:#C8922A;" id="aot-login-send">Recevoir le code</button>
                        </div>
                        <div id="aot-login-2" class="d-none">
                            <p class="small text-muted">Code envoyé à <span id="aot-login-email-show"></span></p>
                            <label class="form-label small fw-bold">Code à 6 chiffres</label>
                            <input type="text" class="form-control mb-2 tracking-wider" id="aot-login-code" maxlength="6" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code">
                            <button type="button" class="btn btn-dark w-100" id="aot-login-verify">Valider</button>
                            <button type="button" class="btn btn-link btn-sm w-100 mt-1" id="aot-login-back">Changer d’e-mail</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="aot-pane-reg" role="tabpanel">
                        <div id="aot-reg-1">
                            <label class="form-label small fw-bold">Nom complet</label>
                            <input type="text" class="form-control mb-2" id="aot-reg-name" autocomplete="name">
                            <label class="form-label small fw-bold">E-mail</label>
                            <input type="email" class="form-control mb-2" id="aot-reg-email" autocomplete="username">
                            <button type="button" class="btn w-100 text-white fw-bold" style="background:#C8922A;" id="aot-reg-send">Recevoir le code</button>
                        </div>
                        <div id="aot-reg-2" class="d-none">
                            <p class="small text-muted">Code envoyé à <span id="aot-reg-email-show"></span></p>
                            <label class="form-label small fw-bold">Code à 6 chiffres</label>
                            <input type="text" class="form-control mb-2" id="aot-reg-code" maxlength="6" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code">
                            <button type="button" class="btn btn-dark w-100" id="aot-reg-verify">Créer le compte et continuer</button>
                            <button type="button" class="btn btn-link btn-sm w-100 mt-1" id="aot-reg-back">Modifier</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    var routes = window.allianceRoutes || {};

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
            credentials: 'same-origin',
        }).then(function (r) {
            return r.json().then(function (d) { return { r: r, d: d }; }).catch(function () { return { r: r, d: {} }; });
        });
    }

    function toast(msg, variant) {
        if (window.allianceSiteToast) window.allianceSiteToast(msg, variant || 'error');
    }

    function setBtnLoading(btn, on) {
        if (window.allianceSetSubmitLoading) window.allianceSetSubmitLoading(btn, !!on);
        else if (btn) btn.disabled = !!on;
    }

    function resetAotForm() {
        document.getElementById('aot-login-1')?.classList.remove('d-none');
        document.getElementById('aot-login-2')?.classList.add('d-none');
        document.getElementById('aot-reg-1')?.classList.remove('d-none');
        document.getElementById('aot-reg-2')?.classList.add('d-none');
        ['aot-login-email', 'aot-login-code', 'aot-reg-name', 'aot-reg-email', 'aot-reg-code'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.value = '';
        });
        window._aotLoginEmail = undefined;
        window._aotRegEmail = undefined;
    }

    function afterStandaloneOtpSuccess(user) {
        window.allianceAuthUser = user;
        try {
            document.dispatchEvent(new CustomEvent('alliance:otp-auth-success', { detail: user }));
        } catch (e) {}
        var pendingLike = sessionStorage.getItem('alliance_pending_content_like_url');
        if (pendingLike && user && user.id) {
            sessionStorage.removeItem('alliance_pending_content_like_url');
            postJson(pendingLike, {}).then(function (pair) {
                bootstrap.Modal.getInstance(document.getElementById('allianceOtpAuthModal'))?.hide();
                if (pair.r.ok && typeof pair.d.count === 'number') {
                    toast('Merci pour votre soutien.', 'success');
                }
                location.reload();
            }).catch(function () {
                bootstrap.Modal.getInstance(document.getElementById('allianceOtpAuthModal'))?.hide();
                location.reload();
            });
            return;
        }
        bootstrap.Modal.getInstance(document.getElementById('allianceOtpAuthModal'))?.hide();
        location.reload();
    }

    document.getElementById('aot-login-send')?.addEventListener('click', function () {
        var email = document.getElementById('aot-login-email')?.value?.trim();
        if (!email || !routes.loginSend) return;
        var btn = this;
        setBtnLoading(btn, true);
        postJson(routes.loginSend, { email: email }).then(function (pair) {
            if (pair.r.ok && pair.d.success) {
                document.getElementById('aot-login-1').classList.add('d-none');
                document.getElementById('aot-login-2').classList.remove('d-none');
                document.getElementById('aot-login-email-show').textContent = email;
                window._aotLoginEmail = email;
                toast('Code envoyé. Consultez votre boîte mail.', 'success');
            } else {
                toast(pair.d.message || 'Impossible d’envoyer le code.', 'error');
            }
        }).catch(function () { toast('Erreur réseau.', 'error'); })
            .finally(function () { setBtnLoading(btn, false); });
    });

    document.getElementById('aot-login-verify')?.addEventListener('click', function () {
        var email = window._aotLoginEmail;
        var code = document.getElementById('aot-login-code')?.value?.trim();
        if (!email || code?.length !== 6 || !routes.loginVerify) return;
        var btn = this;
        setBtnLoading(btn, true);
        postJson(routes.loginVerify, { email: email, code: code }).then(function (pair) {
            if (pair.r.ok && pair.d.success) {
                toast('Connecté.', 'success');
                afterStandaloneOtpSuccess(pair.d.user);
            } else {
                toast(pair.d.message || (pair.d.errors && Object.values(pair.d.errors).flat().join(' ')) || 'Code incorrect.', 'error');
            }
        }).catch(function () { toast('Erreur réseau.', 'error'); })
            .finally(function () { setBtnLoading(btn, false); });
    });

    document.getElementById('aot-login-back')?.addEventListener('click', function () {
        document.getElementById('aot-login-2').classList.add('d-none');
        document.getElementById('aot-login-1').classList.remove('d-none');
    });

    document.getElementById('aot-reg-send')?.addEventListener('click', function () {
        var name = document.getElementById('aot-reg-name')?.value?.trim();
        var email = document.getElementById('aot-reg-email')?.value?.trim();
        if (!name || !email || !routes.registerSend) return;
        var btn = this;
        setBtnLoading(btn, true);
        postJson(routes.registerSend, { name: name, email: email }).then(function (pair) {
            if (pair.r.ok && pair.d.success) {
                document.getElementById('aot-reg-1').classList.add('d-none');
                document.getElementById('aot-reg-2').classList.remove('d-none');
                document.getElementById('aot-reg-email-show').textContent = email;
                window._aotRegEmail = email;
                toast('Code envoyé. Consultez votre boîte mail.', 'success');
            } else {
                toast(pair.d.message || (pair.d.errors && Object.values(pair.d.errors).flat().join(' ')) || 'Erreur.', 'error');
            }
        }).catch(function () { toast('Erreur réseau.', 'error'); })
            .finally(function () { setBtnLoading(btn, false); });
    });

    document.getElementById('aot-reg-verify')?.addEventListener('click', function () {
        var email = window._aotRegEmail;
        var code = document.getElementById('aot-reg-code')?.value?.trim();
        if (!email || code?.length !== 6 || !routes.registerVerify) return;
        var btn = this;
        setBtnLoading(btn, true);
        postJson(routes.registerVerify, { email: email, code: code }).then(function (pair) {
            if (pair.r.ok && pair.d.success) {
                toast('Compte créé.', 'success');
                afterStandaloneOtpSuccess(pair.d.user);
            } else {
                toast(pair.d.message || (pair.d.errors && Object.values(pair.d.errors).flat().join(' ')) || 'Code incorrect.', 'error');
            }
        }).catch(function () { toast('Erreur réseau.', 'error'); })
            .finally(function () { setBtnLoading(btn, false); });
    });

    document.getElementById('aot-reg-back')?.addEventListener('click', function () {
        document.getElementById('aot-reg-2').classList.add('d-none');
        document.getElementById('aot-reg-1').classList.remove('d-none');
    });

    document.getElementById('allianceOtpAuthModal')?.addEventListener('show.bs.modal', function () {
        resetAotForm();
    });
})();
</script>
