<?php

namespace App\Exports;

use App\Models\AdminUser;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminUsersExport implements FromView
{
    public $admin_users;

    public function __construct($admin_users)
    {
        $this->admin_users = $admin_users;
    }

    public function view(): View
    {
        return view('dashboard.pages.admin-users.export', [
            'admin_users' => $this->admin_users
        ]);
    }
}
