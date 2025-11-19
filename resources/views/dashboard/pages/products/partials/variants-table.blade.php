@forelse ($product->variants as $variant)
    @php
        // Get images for this variant's color
$variantImages = $variant->color_id
    ? $product
        ->images()
        ->where('color_id', $variant->color_id)
        ->orderBy('is_primary', 'desc')
        ->orderBy('order')
        ->get()
    : $product->images()->whereNull('color_id')->orderBy('is_primary', 'desc')->orderBy('order')->get();

// If no color-specific images, try general images
if ($variantImages->isEmpty() && $variant->color_id) {
    $variantImages = $product
        ->images()
        ->whereNull('color_id')
        ->orderBy('is_primary', 'desc')
        ->orderBy('order')
        ->get();
}

// If still no images, use product main image
if ($variantImages->isEmpty()) {
    $variantImages = collect([(object) ['image' => $product->getRawOriginal('image'), 'is_primary' => true]]);
}

$primaryImage = $variantImages->first();
if ($primaryImage) {
    // Check if it's an Eloquent model or a plain object
            if ($primaryImage instanceof \App\Models\ProductImage) {
                $imagePath = $primaryImage->getRawOriginal('image') ?? ($primaryImage->image ?? null);
            } elseif (is_object($primaryImage) && isset($primaryImage->image)) {
                $imagePath = $primaryImage->image;
            } else {
                $imagePath = null;
            }
            $imageUrl = $imagePath ? asset('storage/' . $imagePath) : 'https://placehold.co/100';
        } else {
            $imageUrl = 'https://placehold.co/100';
        }

    @endphp
    <tr id="variant-row-{{ $variant->id }}">
        <td>
            <div class="userDatatable-content position-relative d-inline-block">
                @if ($variantImages->count() > 1)
                    <img src="{{ $imageUrl }}" alt="Variant Image" class="img-thumbnail rounded-circle"
                        style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal"
                        data-bs-target="#imageModal{{ $variant->id }}">
                    <small class="d-block text-muted mt-1">{{ $variantImages->count() }} images</small>
                @else
                    @php
                        $singleImage = $variantImages->first();
                        $singleImageId = null;
                        if ($singleImage instanceof \App\Models\ProductImage) {
                            $singleImageId = $singleImage->id;
                        } elseif (is_object($singleImage) && isset($singleImage->id)) {
                            $singleImageId = $singleImage->id;
                        }
                    @endphp
                    <img src="{{ $imageUrl }}" alt="Variant Image" class="img-thumbnail"
                        style="width: 60px; height: 60px; object-fit: cover;">
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $variant->size->name ?? 'N/A' }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $variant->color->name ?? 'N/A' }}
            </div>
        </td>

        <td>
            <div class="userDatatable-content">
                <input type="number" class="form-control form-control-sm variant-price-input"
                    data-variant-id="{{ $variant->id }}"
                    data-update-url="{{ route('dashboard.products.variants.update-price', $variant) }}"
                    value="{{ $variant->price ?? '' }}" step="0.01" min="0"
                    style="width: 120px; display: inline-block;">
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <input type="number" class="form-control form-control-sm variant-stock-input"
                    data-variant-id="{{ $variant->id }}"
                    data-update-url="{{ route('dashboard.products.variants.update-stock', $variant) }}"
                    value="{{ $variant->stock ?? '' }}" min="0" style="width: 100px; display: inline-block;">
            </div>
        </td>
        <td class="status-cell">
            <div class="userDatatable-content d-inline-block">
                <x-dashboard.status-switcher route="{{ route('dashboard.products.variants.toggle-status', $variant) }}"
                    item-id="{{ $variant->id }}" is-active="{{ $variant->is_active }}" item-type="variant" />
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <button type="button" class="btn fs-10 btn-sm delete-variant-btn"
                    data-variant-id="{{ $variant->id }}"
                    data-variant-info="{{ $variant->size->name ?? 'N/A' }} - {{ $variant->color->name ?? 'N/A' }}"
                    title="Delete Variant">
                    <i class="uil uil-trash text-2xl"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No variants found.</td>
    </tr>
@endforelse
