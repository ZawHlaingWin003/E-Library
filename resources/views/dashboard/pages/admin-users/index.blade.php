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
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('custom_script')

    <script>
        $(document).ready(function() {
            $('#adminUser_dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/admin-users/ssr",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "email",
                        name: "email"
                    },
                    {
                        data: "phone",
                        name: "phone"
                    },
                    {
                        data: "ip_address",
                        name: "ip_address"
                    },
                    {
                        data: "last_login_at",
                        name: "last_login_at",
                    },
                    {
                        data: "created_at",
                        name: "created_at",
                    },
                    {
                        data: "action",
                        name: "action",
                    },
                ],
                columnDefs: [{
                    targets: "no-sort",
                    sortable: false
                }],
            });
        });
    </script>

@endsection
