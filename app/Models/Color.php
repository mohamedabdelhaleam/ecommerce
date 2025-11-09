<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
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
}
