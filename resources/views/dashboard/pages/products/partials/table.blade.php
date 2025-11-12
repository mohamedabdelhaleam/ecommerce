@forelse ($products as $product)
    <tr id="product-row-{{ $product->id }}">
        <td>
            <div class="d-flex">
                <div class="userDatatable__imgWrapper d-flex align-items-center">
                    <div class="checkbox-group-wrapper">
                        <div class="checkbox-group d-flex">
                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                <input class="checkbox" type="checkbox" id="check-grp-{{ $product->id }}">
                                <label for="check-grp-{{ $product->id }}"></label>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.products.show', $product) }}"
                        class="profile-image rounded-circle d-block m-0 wh-38"
                        style="background-image:url({{ $product->image }}); background-size: cover;"></a>
                </div>
                <div class="userDatatable-inline-title">
                    <a href="{{ route('dashboard.products.show', $product) }}" class="text-dark fw-500">
                        <h6>{{ $product->name_ar }}</h6>
                    </a>
                    <p class="d-block mb-0">
                        PROD-{{ $product->id }}
                    </p>
                </div>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $product->category->name_ar ?? ($product->category->name_en ?? 'N/A') }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $product->name_en ?? 'N/A' }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $product->variants->sum('stock') }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $product->created_at->format('F d, Y') }}
            </div>
        </td>
        <td class="status-cell">
            <div class="userDatatable-content d-inline-block">
                <x-dashboard.status-switcher route="{{ route('dashboard.products.toggle-status', $product) }}"
                    item-id="{{ $product->id }}" is-active="{{ $product->is_active }}" item-type="product" />
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap align-items-center">
                <li>
                    <a href="{{ route('dashboard.products.show', $product) }}" class="view">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.products.edit', $product) }}" class="edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <x-dashboard.delete-button route="{{ route('dashboard.products.destroy', $product) }}"
                        item-id="{{ $product->id }}" item-name="{{ $product->name_ar }}" item-type="product"
                        table-row-id="product-row-{{ $product->id }}" />
                </li>
            </ul>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No products found.</td>
    </tr>
@endforelse
