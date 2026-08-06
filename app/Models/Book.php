<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Produit boutique (livre, clé USB, pack, etc.) vendu via le panier / FlexPay.
 */
class Book extends Model
{
    use SoftDeletes;

    public const TYPE_BOOK = 'book';

    public const TYPE_USB = 'usb';

    public const TYPE_PACK = 'pack';

    public const TYPE_OTHER = 'other';

    /**
     * Libellés FR des types de produit pour l’admin et le front.
     *
     * @return array<string, string>
     */
    public static function productTypeLabels(): array
    {
        return [
            self::TYPE_BOOK => 'Livre',
            self::TYPE_USB => 'Flash USB',
            self::TYPE_PACK => 'Pack / Coffret',
            self::TYPE_OTHER => 'Autre produit',
        ];
    }

    protected $fillable = [
        'title',
        'product_type',
        'slug',
        'description',
        'price',
        'currency',
        'cover_path',
        'gallery_paths',
        'digital_file_path',
        'isbn',
        'is_active',
        'is_featured',
        'stock_quantity',
    ];

    /**
     * Casts des attributs du modèle.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'gallery_paths' => 'array',
        ];
    }

    /**
     * Lignes de commande liées à ce produit.
     *
     * @return HasMany<OrderItem, $this>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Slides mettant en avant ce produit.
     *
     * @return HasMany<Slide, $this>
     */
    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }

    /**
     * URL absolue de la couverture (ou image de repli) pour le panier / listes.
     *
     * @return string
     */
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_path) {
            return Storage::disk('public')->url($this->cover_path);
        }

        $gallery = $this->gallery_paths ?? [];
        if (is_array($gallery) && count($gallery) > 0 && is_string($gallery[0]) && $gallery[0] !== '') {
            return Storage::disk('public')->url($gallery[0]);
        }

        return asset('assets/images/resource/about-1.jpg');
    }

    /**
     * Liste d’URLs d’images (couverture + galerie) pour la fiche produit.
     *
     * @return list<string>
     */
    public function imageUrls(): array
    {
        $urls = [];
        if ($this->cover_path) {
            $urls[] = Storage::disk('public')->url($this->cover_path);
        }
        foreach ($this->gallery_paths ?? [] as $path) {
            if (! is_string($path) || $path === '') {
                continue;
            }
            $url = Storage::disk('public')->url($path);
            if (! in_array($url, $urls, true)) {
                $urls[] = $url;
            }
        }
        if ($urls === []) {
            $urls[] = asset('assets/images/resource/about-1.jpg');
        }

        return $urls;
    }

    /**
     * Libellé du type de produit (FR).
     *
     * @return string
     */
    public function getProductTypeLabelAttribute(): string
    {
        return self::productTypeLabels()[$this->product_type ?? self::TYPE_BOOK]
            ?? self::productTypeLabels()[self::TYPE_OTHER];
    }

    /**
     * Prix de base en USD (la colonne price est toujours stockée en USD).
     *
     * @return float
     */
    public function priceUsd(): float
    {
        return (float) ($this->price ?? 0);
    }

    /**
     * Indique si le produit peut être ajouté au panier (stock).
     *
     * @return bool
     */
    public function isPurchasable(): bool
    {
        return $this->is_active
            && ($this->stock_quantity === null || $this->stock_quantity > 0);
    }

    /**
     * Payload JSON pour les boutons panier / acheter côté front (prix USD de base).
     *
     * @return array{id: int, title: string, price: float|null, currency: string, cover_url: string}
     */
    public function toCartItem(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price !== null ? (float) $this->price : null,
            'currency' => 'USD',
            'cover_url' => $this->cover_url,
        ];
    }

    /**
     * Produits actifs mis en avant (modale d’accueil).
     *
     * @param  Builder<Book>  $query
     * @return Builder<Book>
     */
    public function scopeFeaturedForPromo(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('product_type')
            ->latest();
    }
}
