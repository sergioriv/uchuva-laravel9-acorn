<div class="nav-content d-flex">
    <!-- Logo Start -->
    <div class="logo position-relative">
        <a href="/">
            <!-- Logo can be added directly -->
            <!-- <img src="/img/logo/logo-white.svg" alt="logo" /> -->
            {{-- <x-application-logo class="w-200 h-200 fill-current text-white" /> --}}
            <div class="img img-uchuva"></div>
            <!-- Or added via css to provide different ones for different color themes -->
            {{-- <div class="img"></div> --}}
        </a>
    </div>
    <!-- Logo End -->

    <!-- User Menu Start -->
    <div class="user-container d-flex">
        <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <x-avatar-nav :avatar="Auth::user()->avatar" />
            <div class="name">{{ Auth::user()->name }}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-end user-menu wide">
            <div class="row mb-2 ms-0 me-0">
                <div class="col-12 ps-1 mb-2">
                    <div class="text-extra-small text-primary">ACCOUNT</div>
                </div>
                <div class="col-12 ps-1 pe-1">
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('user.profile') }}">User Info</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row mb-1 ms-0 me-0">
                <div class="col-12 p-1 mb-3 pt-3">
                    <div class="separator-light"></div>
                </div>
                <div class="col-12 pe-1 ps-1">
                    <ul class="list-unstyled">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    <i data-acorn-icon="logout" class="me-2" data-acorn-size="17"></i>
                                    <span class="align-middle">{{ __('Log Out') }}</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- User Menu End -->

    <!-- Menu Start -->
    <div class="menu-container flex-grow-1">
        <ul id="menu" class="menu">
            <li>
                <a href="/dashboard">
                    <i data-acorn-icon="home" class="icon" data-acorn-size="18"></i>
                    <span class="label">{{ __('Dashboard') }}</span>
                </a>
            </li>

            @can('support.restaurants')
            <li>
                <a href="{{ route('support.restaurants.index') }}">
                    <i class="bi-building icon icon-18"></i>
                    <span class="label">{{ __('Restaurants') }}</span>
                </a>
            </li>
            @endcan
            @can('support.access')
            <li>
                <a href="{{ route('support.users.index') }}">
                    <i class="bi-people-fill icon icon-18"></i>
                    <span class="label">{{ __('Users') }}</span>
                </a>
            </li>
            @endcan
            @can('support.access')
            <li>
                <a href="{{ route('support.roles.index') }}">
                    <i class="bi-person-badge icon icon-18"></i>
                    <span class="label">{{ __('Roles') }}</span>
                </a>
            </li>
            @endcan


            <!-- RESTAURANT NAV -->
            @can('categories')
            <li>
                <a href="{{ route('restaurant.categories.index') }}">
                    <i class="bi-stickies icon icon-18"></i>
                    <span class="label">{{ __('Categories') }}</span>
                </a>
            </li>
            @endcan
            @can('dishes')
            <li>
                <a href="{{ route('restaurant.dishes.index') }}">
                    <i data-acorn-icon="main-course" class="icon" data-acorn-size="18"></i>
                    <span class="label">{{ __('Dishes') }}</span>
                </a>
            </li>
            @endcan
            @can('waiters')
            <li>
                <a href="{{ route('restaurant.waiters.index') }}">
                    <i class="bi-person-lines-fill icon icon-18"></i>
                    <span class="label">{{ __('Waiters') }}</span>
                </a>
            </li>
            @endcan
            @can('tables')
            <li>
                <a href="{{ route('restaurant.tables.index') }}">
                    <i class="bi-list-ol icon icon-18"></i>
                    <span class="label">{{ __('Tables') }}</span>
                </a>
            </li>
            @endcan


            <!-- WAITERS & RESTAURANTS NAV -->
            @can('orders.index')
            <li>
                <a href="{{ route('waiter.orders.index') }}">
                    <i class="bi-list-nested icon icon-18"></i>
                    <span class="label">{{ __('Backorders') }}</span>
                </a>
            </li>
            @endcan


            <!-- USER NAV -->
            @can('user.profile')
            <li>
                <a href="{{ route('user.profile') }}">
                    <i data-acorn-icon="user" class="icon" data-acorn-size="18"></i>
                    <span class="label">{{ __('Profile') }}</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
    <!-- Menu End -->

    <!-- Mobile Buttons Start -->
    <div class="mobile-buttons-container">
        <!-- Scrollspy Mobile Button Start -->
        <a href="#" id="scrollSpyButton" class="spy-button" data-bs-toggle="dropdown">
            <i data-acorn-icon="menu-dropdown"></i>
        </a>
        <!-- Scrollspy Mobile Button End -->

        <!-- Scrollspy Mobile Dropdown Start -->
        <div class="dropdown-menu dropdown-menu-end" id="scrollSpyDropdown"></div>
        <!-- Scrollspy Mobile Dropdown End -->

        <!-- Menu Button Start -->
        <a href="#" id="mobileMenuButton" class="menu-button">
            <i data-acorn-icon="menu"></i>
        </a>
        <!-- Menu Button End -->
    </div>
    <!-- Mobile Buttons End -->
</div>
<div class="nav-shadow"></div>
