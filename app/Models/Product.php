<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : 'https://placehold.co/400';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function activeVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->orderBy('created_at', 'desc');
    }

    /**
     * Get the name based on current locale
     */
    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar'
            ? ($this->name_ar ?? $this->name_en ?? 'N/A')
            : ($this->name_en ?? $this->name_ar ?? 'N/A');
    }

    /**
     * Get the minimum price from active variants
     */
    public function getMinPriceAttribute()
    {
        $minPrice = $this->activeVariants()
            ->whereNotNull('price')
            ->min('price');
        return $minPrice ? (float) $minPrice : null;
    }

    /**
     * Get the maximum price from active variants
     */
    public function getMaxPriceAttribute()
    {
        $maxPrice = $this->activeVariants()
            ->whereNotNull('price')
            ->max('price');
        return $maxPrice ? (float) $maxPrice : null;
    }

    /**
     * Get formatted price range
     */
    public function getPriceRangeAttribute()
    {
        $min = $this->min_price;
        $max = $this->max_price;

        if ($min === null && $max === null) {
            return 'N/A';
        }

        if ($min === $max) {
            return '$' . number_format($min, 2);
        }

        return '$' . number_format($min, 2) . ' - $' . number_format($max, 2);
    }
}
