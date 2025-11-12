<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : 'https://placehold.co/400';
    }

    public function products()
    {
        return $this->hasMany(Product::class)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
}
