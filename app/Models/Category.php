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
}
