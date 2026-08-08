<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\PartnerCommitment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function donateForm(): View
    {
        return view('pages.donate');
    }

    public function donateStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'nullable|string|max:50',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:CDF',
            'frequency' => 'required|string|in:once,monthly',
            'message' => 'nullable|string|max:2000',
            'is_anonymous' => 'boolean',
        ]);

        $validated['status'] = 'pending';

        Donation::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Merci pour votre générosité ! Votre don a été enregistré.',
            ]);
        }

        return back()->with('success', 'Merci pour votre générosité ! Votre don a été enregistré.');
    }

    public function partnerForm(): View
    {
        return view('pages.partner');
    }

    /**
     * Enregistre un engagement partenaire (crée / connecte le compte si invité).
     *
     * @param  Request  $request  Montant, devise, message, name?, email?
     * @return RedirectResponse|JsonResponse
     */
    public function partnerStore(Request $request): RedirectResponse|JsonResponse
    {
        $rules = [
            'monthly_amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:USD,EUR,CDF',
            'message' => 'nullable|string|max:2000',
        ];

        if (! Auth::check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        $validated = $request->validate($rules);

        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = User::findOrRegisterByEmail(
                (string) $validated['email'],
                (string) $validated['name'],
            );
            Auth::login($user, true);
        }

        PartnerCommitment::create([
            'user_id' => $user->id,
            'monthly_amount' => $validated['monthly_amount'],
            'currency' => $validated['currency'],
            'message' => $validated['message'] ?? null,
            'status' => 'active',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Merci pour votre engagement en tant que partenaire ! Votre compte a été enregistré.',
            ]);
        }

        return back()->with('success', 'Merci pour votre engagement en tant que partenaire !');
    }
}
