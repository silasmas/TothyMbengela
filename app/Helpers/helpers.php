<?php

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

if (! function_exists('initRequeteFlexPayMobile')) {
    /**
     * @param  array<string, mixed>  $data
     * @param  Model  $order  Donation ou PartnerCommitment (external_payment_id, status)
     */
    function initRequeteFlexPayMobile(array $data, $order): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.config('services.flexpay.token'),
        ])->post(config('services.flexpay.gateway_mobile'), $data);

        $responseBody = $response->json();

        if (isset($responseBody['code']) && $responseBody['code'] == '0') {
            $payload = [
                'external_payment_id' => $responseBody['orderNumber'],
                'status' => 'processing',
            ];
            if ($order instanceof Order) {
                $payload['payment_status'] = 'processing';
            }
            $order->update($payload);

            return [
                'reponse' => true,
                'message' => 'Paiement en attente sur votre téléphone',
                'type' => 'mobile',
                'reference' => $data['reference'],
                'orderNumber' => $responseBody['orderNumber'],
            ];
        }

        return [
            'reponse' => false,
            'message' => $responseBody['message'] ?? 'Échec de la transaction',
        ];
    }
}

if (! function_exists('generateUniqueReference')) {
    function generateUniqueReference(string $prefix, string $modelClass, string $column = 'reference'): string
    {
        do {
            $reference = strtoupper($prefix).'-'.strtoupper(Str::random(10));
        } while ($modelClass::where($column, $reference)->exists());

        return $reference;
    }
}
