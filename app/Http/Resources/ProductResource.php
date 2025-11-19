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

        // Get variant with minimum price from loaded variants
        $minPriceVariant = $this->variants
            ->where('is_active', true)
            ->whereNotNull('price')
            ->sortBy('price')
            ->first();
        $minPriceVariantId = $minPriceVariant ? $minPriceVariant->id : null;

        // Format price display - always show minimum price
        $priceDisplay = 'N/A';
        if ($minPrice) {
            $priceDisplay = '$' . number_format($minPrice, 2);
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
            'min_price_variant_id' => $minPriceVariantId,
            'is_new' => $isNew,
            'url' => route('products.show', $this->id),
            'created_at' => $this->created_at,
        ];
    }
}
