@forelse ($coupons as $coupon)
    <tr id="coupon-row-{{ $coupon->id }}">
        <td>
            <div class="d-flex">
                <div class="userDatatable__imgWrapper d-flex align-items-center">
                    <div class="checkbox-group-wrapper">
                        <div class="checkbox-group d-flex">
                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                <input class="checkbox" type="checkbox" id="check-grp-{{ $coupon->id }}">
                                <label for="check-grp-{{ $coupon->id }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="profile-image rounded-circle d-block m-0 wh-38 d-flex align-items-center justify-content-center"
                        style="background-color: #10b981; color: white; font-weight: bold;">
                        {{ strtoupper(substr($coupon->code, 0, 1)) }}
                    </div>
                </div>
                <div class="userDatatable-inline-title">
                    <a href="{{ route('dashboard.coupons.show', $coupon) }}" class="text-dark fw-500">
                        <h6>{{ $coupon->code }}</h6>
                    </a>
                    <p class="d-block mb-0">
                        {{ app()->getLocale() == 'ar' ? $coupon->name_ar ?? $coupon->name_en : $coupon->name_en ?? $coupon->name_ar }}
                    </p>
                </div>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <span class="badge bg-{{ $coupon->type == 'percentage' ? 'info' : 'warning' }}">
                    {{ $coupon->type == 'percentage' ? $coupon->value . '%' : $coupon->value }}
                </span>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if ($coupon->usage_limit)
                    {{ $coupon->used_count }} / {{ $coupon->usage_limit }}
                @else
                    {{ $coupon->used_count }} / {{ __('dashboard.unlimited') }}
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if ($coupon->expires_at)
                    @if (app()->getLocale() == 'ar')
                        {{ \Carbon\Carbon::parse($coupon->expires_at)->locale('ar')->translatedFormat('d F Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($coupon->expires_at)->format('F d, Y') }}
                    @endif
                @else
                    {{ __('dashboard.no_expiry') }}
                @endif
            </div>
        </td>
        <td class="status-cell">
            <div class="userDatatable-content d-inline-block">
                <x-dashboard.status-switcher route="{{ route('dashboard.coupons.toggle-status', $coupon) }}"
                    item-id="{{ $coupon->id }}" is-active="{{ $coupon->is_active }}" item-type="coupon" />
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap align-items-center">
                <li>
                    <a href="{{ route('dashboard.coupons.show', $coupon) }}" class="view">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.coupons.edit', $coupon) }}" class="edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <x-dashboard.delete-button route="{{ route('dashboard.coupons.destroy', $coupon) }}"
                        item-id="{{ $coupon->id }}" item-name="{{ $coupon->code }}" item-type="coupon"
                        table-row-id="coupon-row-{{ $coupon->id }}" />
                </li>
            </ul>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">{{ __('dashboard.no_coupons_found') }}</td>
    </tr>
@endforelse
