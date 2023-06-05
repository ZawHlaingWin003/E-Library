

<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item pt-2">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fa fa-globe"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/admin_users') || request()->is('admin/admin_users/upload') ? 'active' : '' }}" href="{{ route('admin-users.index') }}">
                        <i class="fa fa-user-tie"></i>
                        <span class="hide-menu">Admin Users</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="fa fa-user"></i>
                        <span class="hide-menu">Users</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/book_list') || request()->is('admin/books/create') || request()->is('admin/books/*/edit') ||  request()->is('admin/books/upload') ? 'active' : '' }}" href="{{ route('books.index') }}">
                        <i class="fa fa-book"></i>
                        <span class="hide-menu">Books</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/author_list') || request()->is('admin/authors/create') || request()->is('admin/authors/*/edit') ? 'active' : '' }}" href="{{ route('authors.index') }}">
                        <i class="fa fa-users"></i>
                        <span class="hide-menu">Authors</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/genre_list') || request()->is('admin/genres/create') || request()->is('admin/genres/*/edit') ? 'active' : '' }}" href="{{ route('genres.index') }}">
                        <i class="fa fa-list"></i>
                        <span class="hide-menu">Genres</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('admin/subscribed_list') ? 'active' : '' }}" href="{{ route('subscribed-users.index') }}">
                        <i class="fa fa-envelope"></i>
                        <span class="hide-menu">Subscribed Email List</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>