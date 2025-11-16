<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get primary image or first image
        $primaryImage = $this->primaryImage ?? $this->images->first();
        $productImage = $primaryImage
            ? asset('storage/' . $primaryImage->image)
            : $this->image;

        // Get price information
        $minPrice = $this->min_price;
        $maxPrice = $this->max_price;

        // Format price display
        $priceDisplay = 'N/A';
        if ($minPrice && $maxPrice) {
            if ($minPrice == $maxPrice) {
                $priceDisplay = '$' . number_format($minPrice, 2);
            } else {
                $priceDisplay = '$' . number_format($minPrice, 2) . ' - $' . number_format($maxPrice, 2);
            }
        }

        // Check if product is new (less than 30 days old)
        $isNew = $this->created_at->diffInDays(now()) < 30;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $productImage,
            'category' => [
                'id' => $this->category->id ?? null,
                'name' => $this->category->name ?? 'Uncategorized',
            ],
            'price' => [
                'min' => $minPrice,
                'max' => $maxPrice,
                'display' => $priceDisplay,
            ],
            'is_new' => $isNew,
            'url' => route('products.show', $this->id),
            'created_at' => $this->created_at,
        ];
    }
}
