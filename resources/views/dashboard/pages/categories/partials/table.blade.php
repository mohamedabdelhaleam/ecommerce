@forelse ($categories as $category)
    <tr id="category-row-{{ $category->id }}">
        <td>
            <div class="d-flex">
                <div class="userDatatable__imgWrapper d-flex align-items-center">
                    <div class="checkbox-group-wrapper">
                        <div class="checkbox-group d-flex">
                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                <input class="checkbox" type="checkbox" id="check-grp-{{ $category->id }}">
                                <label for="check-grp-{{ $category->id }}"></label>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.categories.show', $category) }}"
                        class="profile-image rounded-circle d-block m-0 wh-38"
                        style="background-image:url({{ $category->image }}); background-size: cover;"></a>
                </div>
                <div class="userDatatable-inline-title">
                    <a href="{{ route('dashboard.categories.show', $category) }}" class="text-dark fw-500">
                        <h6>{{ $category->name }}</h6>
                    </a>
                    <p class="d-block mb-0">
                        CAT-{{ $category->id }}
                    </p>
                </div>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $category->products->count() ?? 0 }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if (app()->getLocale() == 'ar')
                    {{ $category->created_at->locale('ar')->translatedFormat('d F Y') }}
                @else
                    {{ $category->created_at->format('F d, Y') }}
                @endif
            </div>
        </td>
        <td class="status-cell">
            <div class="userDatatable-content d-inline-block">
                <x-dashboard.status-switcher route="{{ route('dashboard.categories.toggle-status', $category) }}"
                    item-id="{{ $category->id }}" is-active="{{ $category->is_active }}" item-type="category" />
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap align-items-center">
                <li>
                    <a href="{{ route('dashboard.categories.show', $category) }}" class="view">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.categories.edit', $category) }}" class="edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <x-dashboard.delete-button route="{{ route('dashboard.categories.destroy', $category) }}"
                        item-id="{{ $category->id }}" item-name="{{ $category->name }}" item-type="category"
                        table-row-id="category-row-{{ $category->id }}" />
                </li>
            </ul>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">{{ __('dashboard.no_categories_found') }}</td>
    </tr>
@endforelse
