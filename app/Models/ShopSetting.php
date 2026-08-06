<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Paramètres boutique (taux USD→CDF, devise par défaut).
 */
class ShopSetting extends Model
{
    protected $fillable = [
        'usd_to_cdf_rate',
        'default_currency',
        'allow_currency_switch',
    ];

    /**
     * Casts des attributs.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'usd_to_cdf_rate' => 'decimal:4',
            'allow_currency_switch' => 'boolean',
        ];
    }

    /**
     * Instance unique des paramètres boutique (créée si absente).
     *
     * @return self
     */
    public static function instance(): self
    {
        $row = static::query()->first();
        if ($row !== null) {
            return $row;
        }

        return static::query()->create([
            'usd_to_cdf_rate' => 2850,
            'default_currency' => 'USD',
            'allow_currency_switch' => true,
        ]);
    }

    /**
     * Convertit un montant USD vers la devise demandée.
     *
     * @param  float  $amountUsd  Montant en USD
     * @param  string  $currency  USD ou CDF
     * @return float
     */
    public function convertFromUsd(float $amountUsd, string $currency): float
    {
        $currency = strtoupper($currency);
        if ($currency === 'CDF') {
            return round($amountUsd * (float) $this->usd_to_cdf_rate, 2);
        }

        return round($amountUsd, 2);
    }

    /**
     * Indique si la devise est acceptée (USD / CDF).
     *
     * @param  string  $currency  Code devise
     * @return bool
     */
    public function isSupportedCurrency(string $currency): bool
    {
        return in_array(strtoupper($currency), ['USD', 'CDF'], true);
    }
}
