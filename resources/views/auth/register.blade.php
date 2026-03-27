<x-guest-layout>
    <p class="text-sm text-gray-600 mb-6">Création de compte sans mot de passe : indiquez votre nom et votre e-mail, puis le code reçu par message.</p>

    <div id="otp-reg-step1">
        <div>
            <x-input-label for="name" value="Nom complet" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-6">
            <x-primary-button type="button" id="otp-reg-send">{{ __('Recevoir le code') }}</x-primary-button>
        </div>
    </div>

    <div id="otp-reg-step2" class="hidden mt-4">
        <p class="text-sm text-gray-600 mb-2">Code envoyé à <strong id="otp-reg-email-display"></strong></p>
        <div>
            <x-input-label for="otp_reg_code" value="Code à 6 chiffres" />
            <x-text-input id="otp_reg_code" class="block mt-1 w-full tracking-widest" type="text" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required autocomplete="one-time-code" />
        </div>
        <div class="flex items-center justify-between mt-6">
            <button type="button" id="otp-reg-back" class="text-sm text-gray-600 underline">Modifier</button>
            <x-primary-button type="button" id="otp-reg-verify">Créer mon compte</x-primary-button>
        </div>
    </div>

    <p class="mt-6 text-center text-sm text-gray-600">
        <a class="underline" href="{{ route('login') }}">Déjà inscrit ? Se connecter</a>
    </p>

    <script>
    (function(){
        var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        var sendUrl = @json(route('register.send-code'));
        var verifyUrl = @json(route('register.verify'));
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
        document.getElementById('otp-reg-send')?.addEventListener('click', function() {
            var name = document.getElementById('name')?.value?.trim();
            var email = document.getElementById('email')?.value?.trim();
            if (!name || !email) return;
            var btn = this;
            btn.disabled = true;
            postJson(sendUrl, { name: name, email: email }).then(function(pair) {
                if (pair.r.ok && pair.d.success) {
                    document.getElementById('otp-reg-step1').classList.add('hidden');
                    document.getElementById('otp-reg-step2').classList.remove('hidden');
                    document.getElementById('otp-reg-email-display').textContent = email;
                    window._otpRegEmail = email;
                    document.getElementById('otp_reg_code')?.focus();
                } else {
                    alert(pair.d.message || (pair.d.errors && Object.values(pair.d.errors).flat().join(' ')) || 'Erreur.');
                }
            }).catch(function() { alert('Erreur réseau.'); })
            .finally(function() { btn.disabled = false; });
        });
        document.getElementById('otp-reg-verify')?.addEventListener('click', function() {
            var email = window._otpRegEmail;
            var code = document.getElementById('otp_reg_code')?.value?.trim();
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
        document.getElementById('otp-reg-back')?.addEventListener('click', function() {
            document.getElementById('otp-reg-step2').classList.add('hidden');
            document.getElementById('otp-reg-step1').classList.remove('hidden');
        });
    })();
    </script>
</x-guest-layout>
