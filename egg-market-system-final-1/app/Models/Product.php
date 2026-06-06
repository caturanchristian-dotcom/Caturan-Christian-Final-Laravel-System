<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'user_id', 
        'category_id', 
        'name', 
        'description', 
        'price', 
        'stock', 
        'unit', 
        'image'
    ];

    /**
     * Get the product's image.
     */
    public function getImageAttribute($value)
    {
        // 1. Return high-quality placeholder if empty or null
        if (!$value) {
            return 'https://images.unsplash.com/photo-1587486914762-8f05560e6187?w=800';
        }

        // 2. If it's inline base64 data, return it directly
        if (str_starts_with($value, 'data:')) {
            return $value;
        }

        // 3. If it's a full web link (URL), return it immediately
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // 4. Robust path cleaning for local storage files
        $cleanPath = str_replace(['public/', 'storage/'], '', $value);
        $cleanPath = ltrim($cleanPath, '/');

        // 5. Returns absolute URL using the asset() helper
        return asset('storage/' . $cleanPath);
    }

    /**
     * Get the farmer that owns the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
