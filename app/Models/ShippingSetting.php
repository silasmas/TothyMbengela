<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    protected $fillable = [
        'is_active',
        'domestic_country_code',
        'price_domestic',
        'price_international',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price_domestic' => 'decimal:2',
            'price_international' => 'decimal:2',
        ];
    }

    /**
     * Paramètres globaux (une seule ligne en base).
     */
    public static function instance(): self
    {
        $row = static::query()->first();
        if ($row !== null) {
            return $row;
        }

        return static::query()->create([
            'is_active' => false,
            'domestic_country_code' => 'CD',
            'price_domestic' => 5,
            'price_international' => 25,
            'currency' => 'USD',
        ]);
    }

    /**
     * Montant des frais de livraison pour un pays ISO2 (hors activation).
     */
    public function amountForCountry(string $countryIso2): float
    {
        $domestic = strtoupper((string) ($this->domestic_country_code ?: 'CD'));
        $code = strtoupper(trim($countryIso2));

        return $code === $domestic
            ? (float) $this->price_domestic
            : (float) $this->price_international;
    }
}
