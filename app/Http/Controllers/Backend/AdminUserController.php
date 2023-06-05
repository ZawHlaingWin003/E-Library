<?php

namespace App\Http\Controllers\Backend;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Exports\AdminUsersExport;
use App\Imports\AdminUsersImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller
{
    public function index()
    {
        $admin_users = AdminUser::latest()->get();
        return view('dashboard.pages.admin-users.index', compact('admin_users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function ssr()
    {
        $data = AdminUser::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return $data->name;
            })
            ->editColumn('email', function ($data) {
                return $data->email;
            })
            ->editColumn('phone', function ($data) {
                return $data->phone;
            })
            ->editColumn('ip_address', function ($data) {
                return $data->ip_address;
            })
            ->editColumn('last_login_at', function ($data) {
                return $data->last_login_at;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at;
            })
            ->addColumn('action', function ($data) {
                $show_btn = '<a href="' . route('admin-users.create', $data->id) . '" class="btn btn-sm rounded btn-primary">Show <span class="ti-eye"></span></a>';

                return '<div class="action-btns">' . $show_btn . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function export()
    {
        $admin_users = AdminUser::all();
        return Excel::download(new AdminUsersExport($admin_users), 'admin_users.xlsx');
    }

    public function uploadExcel()
    {
        return view('dashboard.pages.admin-users.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'admin_users' => 'required|mimes:xlsx'
        ]);

        if ($request->hasFile('admin_users')) {
            Excel::import(new AdminUsersImport, $request->file('admin_users'));

            return redirect()->route('admin-users.index')
                ->with('success', 'Admin Users Data Imported Successfully!');
        }
    }
}
