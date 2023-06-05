@extends('dashboard.layouts.app')

@section('title', 'Admin Users')

@section('content')
    <div class="container">
        <a href="#" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add Admin User</a>
        <a href="{{ route('admin.admin-users.export') }}" class="btn btn-dark mb-3 float-end"><i class="fa fa-file-export"></i>
            Export To Excel</a>
        <a href="{{ route('admin.admin-users.upload') }}" class="btn btn-dark mb-3">Import Excel Data <i
                class="fa fa-file-import"></i></a>
        <div class="table-responsive">
            @if (session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            <table class="table no-wrap table-striped" id="adminUser_dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Ip Address</th>
                        <th>Last Login At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin_users as $index => $admin_user)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td class="txt-oflo">{{ $admin_user->name }}</td>
                            <td>{{ $admin_user->email }}</td>
                            <td>{{ $admin_user->phone }}</td>
                            <td>
                                <span class="text-success">
                                    {{ $admin_user->ip ? $admin_user->ip : 'Haven\'t Login yet' }}
                                </span>
                            </td>
                            <td class="text-success">
                                @if ($admin_user->last_login_at)
                                    {{ \Carbon\Carbon::parse($admin_user->last_login_at)->diffForHumans() }}
                                @else
                                    <span class="badge rounded-pill bg-dark">UnLogged In</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns d-flex gap-2">
                                    <a href="{{ route('admin.admin-users.edit', $admin_user->id) }}" class="btn btn-sm btn-success">
                                        <span><i class="fa-solid fa-user-pen"></i></span>
                                    </a>
                                    <a href="{{ route('admin.admin-users.destroy', $admin_user->id) }}" class="btn btn-sm btn-danger">
                                        <span><i class="fa-solid fa-user-xmark"></i></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('custom_script')

    <script>
        $(document).ready(function() {
            $('#adminUser_dataTable').DataTable();
        });
    </script>

@endsection
