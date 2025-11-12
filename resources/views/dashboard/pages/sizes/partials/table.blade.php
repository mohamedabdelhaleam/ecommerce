@forelse ($sizes as $size)
    <tr id="size-row-{{ $size->id }}">
        <td>
            <div class="d-flex">
                <div class="userDatatable__imgWrapper d-flex align-items-center">
                    <div class="checkbox-group-wrapper">
                        <div class="checkbox-group d-flex">
                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                <input class="checkbox" type="checkbox" id="check-grp-{{ $size->id }}">
                                <label for="check-grp-{{ $size->id }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="profile-image rounded-circle d-block m-0 wh-38 d-flex align-items-center justify-content-center"
                        style="background-color: #f0f0f0; border: 1px solid #ddd;">
                        <span class="text-dark fw-600 small">{{ $size->value ?? $size->name }}</span>
                    </div>
                </div>
                <div class="userDatatable-inline-title">
                    <a href="{{ route('dashboard.sizes.show', $size) }}" class="text-dark fw-500">
                        <h6>{{ $size->name }}</h6>
                    </a>
                    <p class="d-block mb-0">
                        SIZ-{{ $size->id }}
                    </p>
                </div>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <span class="badge bg-secondary">{{ $size->value ?? 'N/A' }}</span>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $size->order ?? 0 }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $size->variants->count() ?? 0 }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if (app()->getLocale() == 'ar')
                    {{ $size->created_at->locale('ar')->translatedFormat('d F Y') }}
                @else
                    {{ $size->created_at->format('F d, Y') }}
                @endif
            </div>
        </td>
        <td class="status-cell">
            <div class="userDatatable-content d-inline-block">
                <x-dashboard.status-switcher route="{{ route('dashboard.sizes.toggle-status', $size) }}"
                    item-id="{{ $size->id }}" is-active="{{ $size->is_active }}" item-type="size" />
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap align-items-center">
                <li>
                    <a href="{{ route('dashboard.sizes.show', $size) }}" class="view">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.sizes.edit', $size) }}" class="edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <x-dashboard.delete-button route="{{ route('dashboard.sizes.destroy', $size) }}"
                        item-id="{{ $size->id }}" item-name="{{ $size->name }}" item-type="size"
                        table-row-id="size-row-{{ $size->id }}" />
                </li>
            </ul>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">{{ __('dashboard.no_sizes_found') }}</td>
    </tr>
@endforelse
