@forelse ($admins as $admin)
    <tr id="admin-row-{{ $admin->id }}">
        <td>
            <div class="d-flex">
                <div class="userDatatable__imgWrapper d-flex align-items-center">
                    <div class="checkbox-group-wrapper">
                        <div class="checkbox-group d-flex">
                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                <input class="checkbox" type="checkbox" id="check-grp-{{ $admin->id }}">
                                <label for="check-grp-{{ $admin->id }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="profile-image rounded-circle d-block m-0 wh-38 d-flex align-items-center justify-content-center"
                        style="background-color: #4f46e5; color: white; font-weight: bold;">
                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                    </div>
                </div>
                <div class="userDatatable-inline-title">
                    <a href="{{ route('dashboard.admins.show', $admin) }}" class="text-dark fw-500">
                        <h6>{{ $admin->name }}</h6>
                    </a>
                    <p class="d-block mb-0">
                        {{ $admin->email }}
                    </p>
                </div>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $admin->phone ?? 'N/A' }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if (app()->getLocale() == 'ar')
                    {{ $admin->created_at->locale('ar')->translatedFormat('d F Y') }}
                @else
                    {{ $admin->created_at->format('F d, Y') }}
                @endif
            </div>
        </td>
        <td class="status-cell">
            <div class="userDatatable-content d-inline-block">
                <x-dashboard.status-switcher route="{{ route('dashboard.admins.toggle-status', $admin) }}"
                    item-id="{{ $admin->id }}" is-active="{{ $admin->is_active }}" item-type="admin" />
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap align-items-center">
                <li>
                    <a href="{{ route('dashboard.admins.show', $admin) }}" class="view">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.admins.edit', $admin) }}" class="edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <x-dashboard.delete-button route="{{ route('dashboard.admins.destroy', $admin) }}"
                        item-id="{{ $admin->id }}" item-name="{{ $admin->name }}" item-type="admin"
                        table-row-id="admin-row-{{ $admin->id }}" />
                </li>
            </ul>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">{{ __('dashboard.no_admins_found') }}</td>
    </tr>
@endforelse
