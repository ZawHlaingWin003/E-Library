<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.users.index');
    }

    public function ssr()
    {
        $data = User::all();
        
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
                $ipAddress = $data->ip_address ? $data->ip_address : "No IP Address";
                return $ipAddress;
            })
            ->editColumn('last_login_at', function ($data) {
                $lastLoginAt = $data->last_login_at ? $data->last_login_at->diffForHumans() : "Haven't Logged In Yet";
                return $lastLoginAt;
            })
            ->addColumn('actions', function ($data) {
                $edit_btn = '<a href="' . route('admin.users.edit', $data->id) . '" class="btn btn-sm btn-success"><span><i class="fa-solid fa-user-pen"></i></span></a>';

                $delete_btn = '<a href="' . route('admin.users.destroy', $data->id) . '" class="btn btn-sm btn-danger"><span><i class="fa-solid fa-user-xmark"></i></span></a>';

                return '<div class="action-btns d-flex gap-2">' . $edit_btn . $delete_btn . '</div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function export()
    {
        $users = User::all();
        return Excel::download(new UsersExport($users), 'users.xlsx');
    }
}
