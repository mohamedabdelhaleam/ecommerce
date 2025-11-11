<div class="sidebar-wrapper">
    <div class="sidebar sidebar-collapse" id="sidebar">
        <div class="sidebar__menu-group">
            <ul class="sidebar_nav">
                <li class="{{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.home') }}" class="">
                        <span class="nav-icon uil uil-create-dashboard"></span>
                        <span class="menu-text">Dashboard</span>
                        {{-- <span class="toggle-icon"></span> --}}
                    </a>
                </li>
                <li class="{{ request()->routeIs('dashboard.products.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.products.index') }}" class="">
                        <span class="nav-icon uil uil-box"></span>
                        <span class="menu-text">Products</span>
                        {{-- <span class="toggle-icon"></span> --}}
                    </a>
                </li>
                <li class="{{ request()->routeIs('dashboard.categories.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.categories.index') }}" class="">
                        <span class="nav-icon uil uil-list-ul"></span>
                        <span class="menu-text">Categories</span>
                        {{-- <span class="toggle-icon"></span> --}}
                    </a>
                </li>


            </ul>
        </div>
    </div>
</div>
