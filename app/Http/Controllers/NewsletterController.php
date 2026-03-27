<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterConfirmationMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse e-mail valide.',
        ]);

        $email = Str::lower(trim($validated['email']));

        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($subscriber && $subscriber->verified_at && ! $subscriber->unsubscribed_at) {
            $payload = [
                'success' => false,
                'message' => 'Cette adresse e-mail est déjà inscrite à notre newsletter.',
            ];

            if ($request->wantsJson()) {
                return response()->json($payload, 422);
            }

            return back()->withErrors(['email' => $payload['message']])->withInput();
        }

        $token = Str::random(64);

        if ($subscriber) {
            $subscriber->forceFill([
                'confirmation_token' => $token,
                'verified_at' => null,
            ])->save();
        } else {
            $subscriber = NewsletterSubscriber::create([
                'email' => $email,
                'confirmation_token' => $token,
                'verified_at' => null,
            ]);
        }

        $confirmUrl = route('newsletter.confirm', ['token' => $token]);

        try {
            Mail::to($email)->send(new NewsletterConfirmationMail($confirmUrl));
        } catch (\Throwable $e) {
            report($e);

            $fail = [
                'success' => false,
                'message' => 'L’inscription n’a pas pu être enregistrée pour le moment (envoi d’e-mail impossible). Réessayez plus tard ou contactez-nous.',
            ];

            if ($request->wantsJson()) {
                return response()->json($fail, 500);
            }

            return back()->withErrors(['email' => $fail['message']])->withInput();
        }

        $okMessage = 'Un e-mail de confirmation vous a été envoyé. Cliquez sur le bouton dans le message pour valider votre inscription.';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $okMessage,
            ]);
        }

        return back()->with('newsletter_pending', $okMessage);
    }

    public function confirm(string $token): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::where('confirmation_token', $token)->first();

        if (! $subscriber) {
            return redirect()->route('home')->with('newsletter_error', 'Ce lien de confirmation est invalide ou a déjà été utilisé.');
        }

        $subscriber->forceFill([
            'verified_at' => now(),
            'confirmation_token' => null,
            'unsubscribed_at' => null,
        ])->save();

        return redirect()->route('home')->with('newsletter_success', 'Merci — vous recevrez bientôt nos actualités.');
    }
}
