<?php

namespace App\Services;

class FlexPayService
{
    public function initiatePayment(float $amount, string $currency, string $reference, string $description, string $type = 'don'): array
    {
        $token = config('services.flexpay.token');
        if (empty($token)) {
            throw new \RuntimeException('Le token du prestataire de paiement est vide. Vérifiez votre .env.');
        }

        $merchant = config('services.flexpay.merchant');
        $gateway = config('services.flexpay.gateway_card');
        if (empty($gateway)) {
            throw new \RuntimeException('FLEXPAY_GATEWAY_CARD non configuré.');
        }
        $appUrl = rtrim(config('app.url'), '/');

        $baseRedirectUrl = "{$appUrl}/paid/{$reference}/{$amount}/{$currency}";
        $callbackUrl = "{$appUrl}/storeTransaction";

        $body = [
            'authorization' => 'Bearer '.$token,
            'merchant' => $merchant,
            'reference' => $reference,
            'amount' => $amount,
            'currency' => $currency,
            'description' => $description,
            'callback_url' => $callbackUrl,
            'approve_url' => "{$baseRedirectUrl}/success",
            'cancel_url' => "{$baseRedirectUrl}/cancel",
            'decline_url' => "{$baseRedirectUrl}/decline",
            'home_url' => "{$appUrl}/",
        ];

        $curl = curl_init($gateway);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $curlResponse = curl_exec($curl);
        curl_close($curl);

        $json = json_decode($curlResponse, true);

        if (isset($json['code']) && $json['code'] === '0') {
            return [
                'rep' => true,
                'url' => $json['url'],
                'orderNumber' => $json['orderNumber'],
                'data' => $json,
            ];
        }

        return [
            'rep' => false,
            'message' => $json['message'] ?? 'Réponse invalide du service de paiement',
            'error' => 'Échec de l\'initiation du paiement',
        ];
    }
}
