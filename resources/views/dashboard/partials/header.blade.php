
<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin6">

            <a class="navbar-brand" href="index.html">
                <span class="logo-text text-dark">
                    E-Library
                </span>
            </a>
            <a
            class="
                nav-toggler
                waves-effect waves-light
                text-dark
                d-block d-md-none
            "
            href="javascript:void(0)"
            >
                <i class="ti-menu ti-close"></i
            ></a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <li class="in">
                    <form role="search" class="app-search d-none d-md-block me-3">
                        <input
                            type="text"
                            placeholder="Search..."
                            class="form-control mt-0"
                        />
                        <a href="" class="active">
                            <i class="fa fa-search"></i>
                        </a>
                    </form>
                </li>
                <li>
                    <a class="profile-pic p-0" href="#">
                        <img
                            src="https://ui-avatars.com/api/?name={{ auth()->guard('admin_user')->user()->name }}"
                            alt="user-img"
                            width="36"
                            class="img-circle"
                        />
                        <span class="text-white font-medium">
                            @if (Auth::guard('admin_user')->check())
                                <a class="d-inline-block nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    {{ Auth::guard('admin_user')->user()->name }}
                                    <i class="fa fa-arrow-down"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            @endif
                        </span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</header>