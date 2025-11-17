<div class="sidebar-wrapper">
    <div class="sidebar sidebar-collapse" id="sidebar">
        <div class="sidebar__menu-group">
            <ul class="sidebar_nav">
                @can('view dashboard')
                    <li class="{{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.home') }}" class="">
                            <span class="nav-icon uil uil-create-dashboard"></span>
                            <span class="menu-text">{{ __('dashboard.dashboard') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan
                @can('view products')
                    <li class="{{ request()->routeIs('dashboard.products.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.products.index') }}" class="">
                            <span class="nav-icon uil uil-box"></span>
                            <span class="menu-text">{{ __('dashboard.products') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan
                @can('view categories')
                    <li class="{{ request()->routeIs('dashboard.categories.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.categories.index') }}" class="">
                            <span class="nav-icon uil uil-list-ul"></span>
                            <span class="menu-text">{{ __('dashboard.categories') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan
                @can('view colors')
                    <li class="{{ request()->routeIs('dashboard.colors.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.colors.index') }}" class="">
                            <span class="nav-icon uil uil-palette"></span>
                            <span class="menu-text">{{ __('dashboard.colors') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan
                @can('view sizes')
                    <li class="{{ request()->routeIs('dashboard.sizes.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.sizes.index') }}" class="">
                            <span class="nav-icon uil uil-ruler"></span>
                            <span class="menu-text">{{ __('dashboard.sizes') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan
                @can('view admins')
                    <li class="{{ request()->routeIs('dashboard.admins.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.index') }}" class="">
                            <span class="nav-icon uil uil-users-alt"></span>
                            <span class="menu-text">{{ __('dashboard.admins') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan
                @can('view roles')
                    <li class="{{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.roles.index') }}" class="">
                            <span class="nav-icon uil uil-shield-check"></span>
                            <span class="menu-text">{{ __('dashboard.roles') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan
                @can('view coupons')
                    <li class="{{ request()->routeIs('dashboard.coupons.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.coupons.index') }}" class="">
                            <span class="nav-icon uil uil-tag-alt"></span>
                            <span class="menu-text">{{ __('dashboard.coupons') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan
                @can('view orders')
                    <li class="{{ request()->routeIs('dashboard.orders.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.orders.index') }}" class="">
                            <span class="nav-icon uil uil-shopping-cart"></span>
                            <span class="menu-text">{{ __('dashboard.orders') }}</span>
                            {{-- <span class="toggle-icon"></span> --}}
                        </a>
                    </li>
                @endcan


            </ul>
        </div>
    </div>
</div>
