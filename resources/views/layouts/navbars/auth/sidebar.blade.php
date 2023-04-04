<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
            <img src="{{ asset('travi.png') }}" class="navbar-brand-img h-100" alt="Travi">
            <span class="ms-3 font-weight-bold fs-6">TRAVI<br>Travel to Village</span>
        </a>
    </div>
    <hr>
    <div class="navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ url('dashboard') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i style="font-size: 1rem;" class="bx bxs-dashboard ps-2 pe-2 text-center text-dark {{ (Request::is('dashboard') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>

        @canany(['reservation-list','tour-package-list', 'lodge-list', 'tour-list', 'tour-category-list'])
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Tour and Reservation</h6>
            </li>
            @can('reservation-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['reservations.index', 'reservations.create', 'reservations.edit']) ? 'active' : '' }}"
                        href="{{ route('reservations.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-calendar-event ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['reservations.index', 'reservations.create', 'reservations.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Reserveration</span>
                    </a>
                </li>
            @endcan
            @can('tour-package-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['tour-packages.index', 'tour-packages.create', 'tour-packages.edit']) ? 'active' : '' }}"
                        href="{{ route('tour-packages.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-directions ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['tour-packages.index', 'tour-packages.create', 'tour-packages.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Tour Package</span>
                    </a>
                </li>
            @endcan
            @can('lodge-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['lodges.index', 'lodges.create', 'lodges.edit']) ? 'active' : '' }}"
                        href="{{ route('lodges.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-home ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['lodges.index', 'lodges.create', 'lodges.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Lodge</span>
                    </a>
                </li>
            @endcan
            @can('tour-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['tours.index', 'tours.create', 'tours.edit']) ? 'active' : '' }}"
                        href="{{ route('tours.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-map ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['tours.index', 'tours.create', 'tours.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Tour Object</span>
                    </a>
                </li>
            @endcan
            @can('tour-category-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['tour-categories.index', 'tour-categories.create', 'tour-categories.edit']) ? 'active' : '' }}"
                        href="{{ route('tour-categories.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-category ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['tour-categories.index', 'tour-categories.create', 'tour-categories.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Tour Category</span>
                    </a>
                </li>
            @endcan
        @endcanany

        @canany(['news-list','news-category-list'])
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">News</h6>
            </li>
            @can('news-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['news.index', 'news.create', 'news.edit']) ? 'active' : '' }}"
                        href="{{ route('news.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-news ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['news.index', 'news.create', 'news.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">News</span>
                    </a>
                </li>
            @endcan
            @can('news-category-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['news-categories.index', 'news-categories.create', 'news-categories.edit']) ? 'active' : '' }}"
                        href="{{ route('news-categories.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-category ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['news-categories.index', 'news-categories.create', 'news-categories.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">News Category</span>
                    </a>
                </li>
            @endcan
        @endcanany

        @canany(['employee-list', 'user-list', 'role-list'])
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">ACL</h6>
            </li>
            @can('employee-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['employees.index', 'employees.create', 'employees.edit']) ? 'active' : '' }}"
                        href="{{ route('employees.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-user ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['employees.index', 'employees.create', 'employees.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Employee</span>
                    </a>
                </li>
            @endcan
            @can('user-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['users.index', 'users.create', 'users.edit']) ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bx-user ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['users.index', 'users.create', 'users.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">User</span>
                    </a>
                </li>
            @endcan
            @can('role-list')
                <li class="nav-item">
                    <a class="nav-link {{ in_array(request()->route()->getName(),['roles.index', 'roles.create', 'roles.edit']) ? 'active' : '' }}"
                        href="{{ route('roles.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="bx bxs-check-shield ps-2 pe-2 text-center
                            {{ in_array(request()->route()->getName(),['roles.index', 'roles.create', 'roles.edit']) ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Role</span>
                    </a>
                </li>
            @endcan
        @endcanany
        </ul>
    </div>
</aside>
