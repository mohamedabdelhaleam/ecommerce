@forelse ($roles as $role)
    <tr id="role-row-{{ $role->id }}">
        <td>
            <div class="d-flex">
                <div class="userDatatable__imgWrapper d-flex align-items-center">
                    <div class="checkbox-group-wrapper">
                        <div class="checkbox-group d-flex">
                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                <input class="checkbox" type="checkbox" id="check-grp-{{ $role->id }}">
                                <label for="check-grp-{{ $role->id }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="profile-image rounded-circle d-block m-0 wh-38 d-flex align-items-center justify-content-center"
                        style="background-color: #6366f1; color: white; font-weight: bold;">
                        {{ strtoupper(substr($role->name, 0, 1)) }}
                    </div>
                </div>
                <div class="userDatatable-inline-title">
                    <a href="{{ route('dashboard.roles.show', $role) }}" class="text-dark fw-500">
                        <h6>{{ $role->name }}</h6>
                    </a>
                    <p class="d-block mb-0">
                        {{ $role->guard_name }}
                    </p>
                </div>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $role->permissions->count() ?? 0 }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ \App\Models\Admin::role($role->name)->count() }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if (app()->getLocale() == 'ar')
                    {{ $role->created_at->locale('ar')->translatedFormat('d F Y') }}
                @else
                    {{ $role->created_at->format('F d, Y') }}
                @endif
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap align-items-center">
                <li>
                    <a href="{{ route('dashboard.roles.show', $role) }}" class="view">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.roles.edit', $role) }}" class="edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                @if ($role->name !== 'Super Admin')
                    <li>
                        <x-dashboard.delete-button route="{{ route('dashboard.roles.destroy', $role) }}"
                            item-id="{{ $role->id }}" item-name="{{ $role->name }}" item-type="role"
                            table-row-id="role-row-{{ $role->id }}" />
                    </li>
                @endif
            </ul>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">{{ __('dashboard.no_roles_found') }}</td>
    </tr>
@endforelse
