@forelse ($colors as $color)
    <tr id="color-row-{{ $color->id }}">
        <td>
            <div class="d-flex">
                <div class="userDatatable__imgWrapper d-flex align-items-center">
                    <div class="checkbox-group-wrapper">
                        <div class="checkbox-group d-flex">
                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                <input class="checkbox" type="checkbox" id="check-grp-{{ $color->id }}">
                                <label for="check-grp-{{ $color->id }}"></label>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.colors.show', $color) }}"
                        class="profile-image rounded-circle d-block m-0 wh-38"
                        style="background-color: {{ $color->hex_code ?? '#cccccc' }}; background-size: cover; border: 1px solid #ddd;"></a>
                </div>
                <div class="userDatatable-inline-title">
                    <a href="{{ route('dashboard.colors.show', $color) }}" class="text-dark fw-500">
                        <h6>{{ $color->name }}</h6>
                    </a>
                    <p class="d-block mb-0">
                        COL-{{ $color->id }}
                    </p>
                </div>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <span class="badge bg-secondary">{{ $color->hex_code ?? 'N/A' }}</span>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $color->variants->count() ?? 0 }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if (app()->getLocale() == 'ar')
                    {{ $color->created_at->locale('ar')->translatedFormat('d F Y') }}
                @else
                    {{ $color->created_at->format('F d, Y') }}
                @endif
            </div>
        </td>
        <td class="status-cell">
            <div class="userDatatable-content d-inline-block">
                <x-dashboard.status-switcher route="{{ route('dashboard.colors.toggle-status', $color) }}"
                    item-id="{{ $color->id }}" is-active="{{ $color->is_active }}" item-type="color" />
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap align-items-center">
                <li>
                    <a href="{{ route('dashboard.colors.show', $color) }}" class="view">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.colors.edit', $color) }}" class="edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <x-dashboard.delete-button route="{{ route('dashboard.colors.destroy', $color) }}"
                        item-id="{{ $color->id }}" item-name="{{ $color->name }}" item-type="color"
                        table-row-id="color-row-{{ $color->id }}" />
                </li>
            </ul>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">{{ __('dashboard.no_colors_found') }}</td>
    </tr>
@endforelse
