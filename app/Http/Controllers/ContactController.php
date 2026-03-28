<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('pages.contact');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
        ], [
            'name.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse e-mail valide.',
            'subject.required' => 'Le sujet est obligatoire.',
            'body.required' => 'Le message est obligatoire.',
        ]);

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

    public function appointmentStore(Request $request): RedirectResponse|JsonResponse
    {
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
}
