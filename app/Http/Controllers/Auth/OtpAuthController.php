<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpCodeMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OtpAuthController extends Controller
{
    private const CACHE_PREFIX = 'auth_otp:';

    private const TTL_MINUTES = 15;

    /**
     * Demande un code par e-mail (connexion — compte existant).
     */
    public function sendLoginCode(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $email = strtolower($validated['email']);
        $user = User::where('email', $email)->first();

        if (! $user) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Aucun compte pour cette adresse. Créez un compte ou vérifiez l’e-mail.'], 422);
            }

            throw ValidationException::withMessages(['email' => 'Aucun compte pour cette adresse.']);
        }

        $this->dispatchCode($email, 'login', null);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Un code vous a été envoyé par e-mail.']);
        }

        return back()->with('otp_sent', true)->with('otp_email', $email);
    }

    /**
     * Vérifie le code et connecte l’utilisateur.
     */
    public function verifyLoginCode(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        $email = strtolower($validated['email']);
        $this->assertValidCode($email, $validated['code'], 'login');

        $user = User::where('email', $email)->firstOrFail();
        if ($user->email_verified_at === null) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }
        Auth::login($user, true);
        $request->session()->regenerate();
        Cache::forget(self::CACHE_PREFIX.$email);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie.',
                'user' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email],
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Demande un code (inscription — e-mail libre).
     */
    public function sendRegisterCode(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        $email = strtolower($validated['email']);
        $this->dispatchCode($email, 'register', $validated['name']);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Un code vous a été envoyé par e-mail.']);
        }

        return back()->with('otp_sent', true)->with('otp_email', $email)->with('otp_name', $validated['name']);
    }

    /**
     * Vérifie le code et crée le compte + connexion (le nom a été fixé à l’étape « envoyer le code »).
     */
    public function verifyRegisterCode(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        $email = strtolower($validated['email']);
        $payload = Cache::get(self::CACHE_PREFIX.$email);

        if (! $payload || ($payload['intent'] ?? '') !== 'register') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Code invalide ou expiré.'], 422);
            }
            throw ValidationException::withMessages(['code' => 'Code invalide ou expiré. Demandez un nouveau code.']);
        }

        if (! Hash::check($validated['code'], $payload['hash'])) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Code incorrect.'], 422);
            }
            throw ValidationException::withMessages(['code' => 'Code incorrect.']);
        }

        $name = $payload['name'] ?? null;
        if (! $name) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Session d’inscription invalide.'], 422);
            }
            throw ValidationException::withMessages(['email' => 'Redemandez un code depuis le formulaire d’inscription.']);
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make(Str::random(48)),
            'email_verified_at' => now(),
        ]);

        Cache::forget(self::CACHE_PREFIX.$email);

        Auth::login($user, true);
        $request->session()->regenerate();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Compte créé et connexion réussie.',
                'user' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email],
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    private function dispatchCode(string $email, string $intent, ?string $name): void
    {
        $code = str_pad((string) random_int(0, 999_999), 6, '0', STR_PAD_LEFT);

        Cache::put(self::CACHE_PREFIX.$email, [
            'hash' => Hash::make($code),
            'intent' => $intent,
            'name' => $name,
        ], now()->addMinutes(self::TTL_MINUTES));

        $label = $intent === 'register'
            ? 'Pour finaliser votre inscription sur Alliance, utilisez ce code :'
            : 'Pour vous connecter à Alliance, utilisez ce code :';

        Mail::to($email)->send(new OtpCodeMail($code, $label));
    }

    private function assertValidCode(string $email, string $code, string $expectedIntent): void
    {
        $payload = Cache::get(self::CACHE_PREFIX.$email);

        if (! $payload || ($payload['intent'] ?? '') !== $expectedIntent) {
            throw ValidationException::withMessages(['code' => 'Code invalide ou expiré. Demandez un nouveau code.']);
        }

        if (! Hash::check($code, $payload['hash'])) {
            throw ValidationException::withMessages(['code' => 'Code incorrect.']);
        }
    }
}
