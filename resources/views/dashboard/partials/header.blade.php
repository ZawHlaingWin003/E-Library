

<header>
    <div class="search-wrapper">
        <span>
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="search" placeholder="Search">
    </div>
    @if (Auth::guard('admin_user')->check())
        <a class="d-flex align-items-center gap-1 nav-link dropdown-toggle" href="#"
            data-bs-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name={{ auth()->guard('admin_user')->user()->name }}"
                alt="user-img" width="36" class="img-circle rounded m-0" />
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
</header>