<header class="header-top">
    <nav class="navbar navbar-light">
        <div class="navbar-left">
            <div class="logo-area">
                <a class="navbar-brand" href="{{ route('dashboard.home') }}">
                    {{-- <img class="dark" src="{{ asset('assets/images/logo.png') }}" alt="logo">
                    <img class="light" src="{{ asset('assets/images/logo.png') }}" alt="logo"> --}}
                    Halim
                </a>
                <a href="#" class="sidebar-toggle">
                    <img class="svg" src="{{ asset('dashboard/img/svg/align-center-alt.svg') }}" alt="img"></a>
            </div>
        </div>
        <!-- ends: navbar-left -->
        <div class="navbar-right">
            <ul class="navbar-right__menu">
                @include('dashboard.components.language-switcher')
                <!-- ends: .nav-flag-select -->
                <li class="nav-author">
                    <div class="dropdown-custom">
                        <a href="javascript:;" class="nav-item-toggle"><img
                                src="{{ asset('dashboard/img/author-nav.jpg') }}" alt="" class="rounded-circle">
                            @if (Auth::guard('admin')->check())
                                <span class="nav-item__title">{{ Auth::guard('admin')->user()->name }}<i
                                        class="las la-angle-down nav-item__arrow"></i></span>
                            @endif
                        </a>
                        <div class="dropdown-parent-wrapper">
                            <div class="dropdown-wrapper">
                                <div class="nav-author__info">
                                    <div class="author-img">
                                        <img src="{{ asset('dashboard/img/author-nav.jpg') }}" alt=""
                                            class="rounded-circle">
                                    </div>
                                    <div>
                                        <h6>{{ Auth::guard('admin')->user()->name }}</h6>
                                    </div>
                                </div>
                                <div class="nav-author__options">
                                    <ul>
                                        <li id="ChangePassword">
                                            <a style="cursor: pointer">
                                                <img src="{{ asset('dashboard/img/svg/settings.svg') }}" alt="settings"
                                                    class="svg">{{ __('dashboard.change_password') }}</a>
                                        </li>
                                    </ul>

                                    {{-- change password modal --}}

                                    <div class="nav-author__options">
                                        <form method="POST" action="{{ route('dashboard.logout') }}"
                                            class="d-inline w-100">
                                            @csrf
                                            <button type="submit"
                                                class="nav-author__signout border-0 bg-transparent w-100 text-left p-1"
                                                style="cursor: pointer;">
                                                <i class="uil uil-sign-out-alt"></i>{{ __('dashboard.logout') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- ends: .dropdown-wrapper -->
                        </div>
                    </div>
                </li>
                <!-- ends: .nav-author -->
            </ul>
            <!-- ends: .navbar-right__menu -->
            {{-- <div class="navbar-right__mobileAction d-md-none">
                <a href="#" class="btn-search">
                    <img src="img/svg/search.svg" alt="search" class="svg feather-search">
                    <img src="img/svg/x.svg" alt="x" class="svg feather-x"></a>
                <a href="#" class="btn-author-action">
                    <img class="svg" src="img/svg/more-vertical.svg" alt="more-vertical"></a>
            </div> --}}
        </div>
        <!-- ends: .navbar-right -->
    </nav>
</header>
