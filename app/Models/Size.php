<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $guarded = [];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() == 'ar'
            ? ($this->name_ar ?? $this->name_en ?? 'N/A')
            : ($this->name_en ?? $this->name_ar ?? 'N/A');
    }
}
