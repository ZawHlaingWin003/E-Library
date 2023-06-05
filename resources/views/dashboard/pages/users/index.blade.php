@extends('dashboard.layouts.app')

@section('title', 'Users List')

@section('content')
    <div class="users">
        <a href="#" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New User</a>
        <a href="{{ route('admin.users.export') }}" class="btn btn-dark mb-3 float-end"><i class="far fa-clock"></i> Export To
            Excel</a>
        <div class="table-responsive">
            <table class="table no-wrap" id="user_dataTable">
                <thead>
                    <tr>
                        <th class="no-sort">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Ip Address</th>
                        <th>Last Login at</th>
                        <th class="no-sort">Actions</th>
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
            $('#user_dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/users/ssr",
                columns: [
                    {
                        data: "DT_RowIndex"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "phone"
                    },
                    {
                        data: "ip_address"
                    },
                    {
                        data: "last_login_at"
                    },
                    {
                        data: "actions"
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
