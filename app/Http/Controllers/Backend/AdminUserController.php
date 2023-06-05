<?php

namespace App\Http\Controllers\Backend;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Exports\AdminUsersExport;
use App\Imports\AdminUsersImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{
    public function index()
    {
        $admin_users = AdminUser::latest()->get();
        return view('dashboard.pages.admin-users.index', compact('admin_users'));
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
