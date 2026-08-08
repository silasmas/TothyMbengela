<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Formulaires contact et demande de rendez-vous (avec protection anti-spam).
 */
class ContactController extends Controller
{
    /**
     * Affiche la page contact.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pages.contact');
    }

    /**
     * Enregistre un message de contact (honeypot + validation).
     *
     * @param  Request  $request  Requête HTTP
     * @return RedirectResponse|JsonResponse
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        if ($this->isHoneypotFilled($request)) {
            return $this->fakeSuccess($request, 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|min:10|max:5000',
        ], [
            'name.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse e-mail valide.',
            'subject.required' => 'Le sujet est obligatoire.',
            'body.required' => 'Le message est obligatoire.',
            'body.min' => 'Le message est trop court.',
        ]);

        if ($this->looksLikeSpam($validated['subject'], $validated['body'], $validated['name'])) {
            return $this->fakeSuccess($request, 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
        }

        $validated['ip_address'] = $request->ip();

        ContactMessage::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.',
            ]);
        }

        return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
    }

    /**
     * Enregistre une demande de rendez-vous (honeypot + validation).
     *
     * @param  Request  $request  Requête HTTP
     * @return RedirectResponse|JsonResponse
     */
    public function appointmentStore(Request $request): RedirectResponse|JsonResponse
    {
        if ($this->isHoneypotFilled($request)) {
            return $this->fakeSuccess($request, 'Votre demande de rendez-vous a été enregistrée. Nous vous contacterons pour confirmer.', 'appointment_success');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required_if:home_appointment,1|nullable|string|max:20',
            'message' => 'nullable|string|max:3000',
        ], [
            'name.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse e-mail valide.',
            'preferred_date.required' => 'La date souhaitée est obligatoire.',
            'preferred_date.after' => 'La date doit être ultérieure à aujourd’hui.',
            'preferred_time.required_if' => 'Veuillez choisir une heure souhaitée.',
        ]);

        $validated['status'] = 'pending';

        AppointmentRequest::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Votre demande de rendez-vous a été enregistrée. Nous vous contacterons pour confirmer.',
            ]);
        }

        return back()->with('appointment_success', 'Votre demande de rendez-vous a été enregistrée. Nous vous contacterons pour confirmer.');
    }

    /**
     * Détecte un honeypot rempli (bots).
     *
     * @param  Request  $request  Requête
     * @return bool
     */
    private function isHoneypotFilled(Request $request): bool
    {
        $trap = (string) $request->input('website_url', '');

        return trim($trap) !== '';
    }

    /**
     * Filtre basique des sujets / messages SEO spam courants.
     *
     * @param  string  $subject  Sujet
     * @param  string  $body  Corps
     * @param  string  $name  Nom
     * @return bool
     */
    private function looksLikeSpam(string $subject, string $body, string $name): bool
    {
        $haystack = mb_strtolower($subject.' '.$body.' '.$name);
        $needles = [
            'seo',
            'google\'s first page',
            'rank your website',
            'backlink',
            'guest post',
            'link building',
            'search engine visibility',
            'rocketdigital',
            'webgrowth',
            'broken links issue',
            'result-driven',
        ];

        foreach ($needles as $needle) {
            if (str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Réponse « succès » silencieuse (ne stocke rien) pour ne pas informer les bots.
     *
     * @param  Request  $request  Requête
     * @param  string  $message  Message affiché
     * @param  string  $flashKey  Clé flash session
     * @return RedirectResponse|JsonResponse
     */
    private function fakeSuccess(Request $request, string $message, string $flashKey = 'success'): RedirectResponse|JsonResponse
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return back()->with($flashKey, $message);
    }
}
