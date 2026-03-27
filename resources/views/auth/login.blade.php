<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <p class="text-sm text-gray-600 mb-6">{{ __('Connexion par code : aucun mot de passe. Nous vous envoyons un code à 6 chiffres par e-mail.') }}</p>

    <div id="otp-login-step1">
        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-6">
            <x-primary-button type="button" id="otp-login-send">
                {{ __('Recevoir le code') }}
            </x-primary-button>
        </div>
    </div>

    <div id="otp-login-step2" class="hidden mt-4">
        <p class="text-sm text-gray-600 mb-2">Saisissez le code reçu à l’adresse <strong id="otp-login-email-display"></strong>.</p>
        <div>
            <x-input-label for="otp_code" value="Code à 6 chiffres" />
            <x-text-input id="otp_code" class="block mt-1 w-full tracking-widest" type="text" name="otp_code" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required autocomplete="one-time-code" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
        <input type="hidden" id="otp-login-email-hidden" name="email" value="">
        <div class="flex items-center justify-between mt-6">
            <button type="button" id="otp-login-back" class="text-sm text-gray-600 underline">{{ __('Modifier l’e-mail') }}</button>
            <x-primary-button type="button" id="otp-login-verify">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>
    </div>

    <script>
    (function(){
        var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        var sendUrl = @json(route('login.send-code'));
        var verifyUrl = @json(route('login.verify'));
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
            }).then(function(r) { return r.json().then(function(d) { return { r: r, d: d }; }); });
        }
        document.getElementById('otp-login-send')?.addEventListener('click', function() {
            var email = document.getElementById('email')?.value?.trim();
            if (!email) return;
            var btn = this;
            btn.disabled = true;
            postJson(sendUrl, { email: email }).then(function(pair) {
                if (pair.r.ok && pair.d.success) {
                    document.getElementById('otp-login-step1').classList.add('hidden');
                    document.getElementById('otp-login-step2').classList.remove('hidden');
                    document.getElementById('otp-login-email-display').textContent = email;
                    document.getElementById('otp-login-email-hidden').value = email;
                    document.getElementById('otp_code')?.focus();
                } else {
                    alert(pair.d.message || 'Impossible d’envoyer le code.');
                }
            }).catch(function() { alert('Erreur réseau.'); })
            .finally(function() { btn.disabled = false; });
        });
        document.getElementById('otp-login-verify')?.addEventListener('click', function() {
            var email = document.getElementById('otp-login-email-hidden')?.value;
            var code = document.getElementById('otp_code')?.value?.trim();
            if (!email || !code || code.length !== 6) return;
            var btn = this;
            btn.disabled = true;
            var returnPath = new URLSearchParams(window.location.search).get('return');
            if (returnPath && (!returnPath.startsWith('/') || returnPath.startsWith('//'))) {
                returnPath = null;
            }
            postJson(verifyUrl, { email: email, code: code, return: returnPath || null }).then(function(pair) {
                if (pair.r.ok && pair.d.success) {
                    window.location.href = pair.d.redirect || @json(url(route('dashboard')));
                } else {
                    alert(pair.d.message || (pair.d.errors && Object.values(pair.d.errors).flat().join(' ')) || 'Code invalide.');
                }
            }).catch(function() { alert('Erreur réseau.'); })
            .finally(function() { btn.disabled = false; });
        });
        document.getElementById('otp-login-back')?.addEventListener('click', function() {
            document.getElementById('otp-login-step2').classList.add('hidden');
            document.getElementById('otp-login-step1').classList.remove('hidden');
        });
    })();
    </script>
</x-guest-layout>
