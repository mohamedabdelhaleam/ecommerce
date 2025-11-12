<li class="nav-flag-select">
    <div class="dropdown-custom">
        <a href="javascript:;" class="nav-item-toggle">
            @if (app()->getLocale() == 'ar')
                <img src="https://flagcdn.com/w20/sa.png" alt="Arabic" class="rounded-circle"
                    style="width: 20px; height: 20px;">
                <span class="nav-item__title">{{ __('dashboard.arabic') }}<i
                        class="las la-angle-down nav-item__arrow"></i></span>
            @else
                <img src="https://flagcdn.com/w20/gb.png" alt="English" class="rounded-circle"
                    style="width: 20px; height: 20px;">
                <span class="nav-item__title">{{ __('dashboard.english') }}<i
                        class="las la-angle-down nav-item__arrow"></i></span>
            @endif
        </a>
        <div class="dropdown-parent-wrapper">
            <div class="dropdown-wrapper">
                <div class="nav-flag-select__options">
                    <ul>
                        <li>
                            <a href="{{ route('dashboard.language.switch', 'en') }}" class="d-flex align-items-center">
                                <img src="https://flagcdn.com/w20/gb.png" alt="English" class="rounded-circle me-2"
                                    style="width: 20px; height: 20px;">
                                <span>{{ __('dashboard.english') }}</span>
                                @if (app()->getLocale() == 'en')
                                    <i class="las la-check ms-auto"></i>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.language.switch', 'ar') }}" class="d-flex align-items-center">
                                <img src="https://flagcdn.com/w20/sa.png" alt="Arabic" class="rounded-circle me-2"
                                    style="width: 20px; height: 20px;">
                                <span>{{ __('dashboard.arabic') }}</span>
                                @if (app()->getLocale() == 'ar')
                                    <i class="las la-check ms-auto"></i>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</li>
