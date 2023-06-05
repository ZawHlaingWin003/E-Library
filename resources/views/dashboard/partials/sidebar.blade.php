<input type="checkbox" id="sidebar-toggle">
<div class="sidebar">
    <div class="sidebar-header">
        <h5 class="brand m-0">
            <span>
                <i class="fas fa-book"></i>
            </span>
            <span>
                E-Library
            </span>
        </h5>
        <label for="sidebar-toggle">
            <i class="fa-solid fa-bars-staggered"></i>
        </label>
    </div>

    <div class="sidebar-menu">
        <ul class="p-0">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <span>
                        <i class="fa-solid fa-house-chimney"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.admin-users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.admin-users.index') }}">
                    <span>
                        <i class="fa-solid fa-user-tie"></i>
                    </span>
                    <span>Admin Users</span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}">
                    <span>
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <span>Users</span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('admin.subscribed-users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.subscribed-users.index') }}">
                    <span>
                        <i class="fa-solid fa-bell"></i>
                    </span>
                    <span>Subscribed Users</span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
                <a href="{{ route('admin.authors.index') }}">
                    <span>
                        <i class="fa-solid fa-pen-nib"></i>
                    </span>
                    <span>Authors</span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('admin.genres.*') ? 'active' : '' }}">
                <a href="{{ route('admin.genres.index') }}">
                    <span>
                        <i class="fa-solid fa-layer-group"></i>
                    </span>
                    <span>Genres</span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                <a href="{{ route('admin.books.index') }}">
                    <span>
                        <i class="fa-solid fa-book"></i>
                    </span>
                    <span>Books</span>
                </a>
            </li>
        </ul>
    </div>
</div>
