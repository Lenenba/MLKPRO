<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'stock',
        'minimum_stock',
        'user_id', // Ajout pour permettre une meilleure gestion multi-utilisateurs
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the category of the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get the user who owns the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to order products by the most recent.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * Scope a query to find products with low stock.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('stock', '<=', 'minimum_stock');
    }

    /**
     * Get a flag indicating if the product is low on stock.
     *
     * @return bool
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->minimum_stock;
    }

    /**
     * Get a human-readable stock status.
     *
     * @return string
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->is_low_stock) {
            return 'Low Stock';
        }

        return 'In Stock';
    }
}
