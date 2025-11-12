@forelse ($product->variants as $variant)
    <tr id="variant-row-{{ $variant->id }}">
        <td>
            <div class="userDatatable-content">
                {{ $variant->size->name_en ?? 'N/A' }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $variant->color->name_en ?? 'N/A' }}
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
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">No variants found.</td>
    </tr>
@endforelse
