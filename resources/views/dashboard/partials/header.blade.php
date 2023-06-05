<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin6">

            <a class="navbar-brand" href="index.html">
                <span class="logo-text text-dark">
                    E-Library
                </span>
            </a>
            <a class="
                nav-toggler
                waves-effect waves-light
                text-dark
                d-block d-md-none
            "
                href="javascript:void(0)">
                <i class="ti-menu ti-close"></i></a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <li class="in">
                    <form role="search" class="app-search d-none d-md-block me-3">
                        <input type="text" placeholder="Search..." class="form-control mt-0" />
                        <a href="" class="active">
                            <i class="fa fa-search"></i>
                        </a>
                    </form>
                </li>
                <li>
                    @if (Auth::guard('admin_user')->check())
                        <a class="d-flex align-items-center gap-1 nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->guard('admin_user')->user()->name }}"
                                alt="user-img" width="36" class="img-circle rounded m-0" />
                            <i class="fa fa-arrow-down"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item">
                                {{ Auth::guard('admin_user')->user()->name }} <br>
                                {{ Auth::guard('admin_user')->user()->email }}
                            </a>
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
                </li>

            </ul>
        </div>
    </nav>
</header>
