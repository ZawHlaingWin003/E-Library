<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscribedUser;


class SubscribedUserController extends Controller
{
    public function index()
    {
        $subscribedUsers = SubscribedUser::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.pages.subscribed-users.index', compact('subscribedUsers'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
