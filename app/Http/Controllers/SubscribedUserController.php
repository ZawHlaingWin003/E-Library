<?php

namespace App\Http\Controllers;

use App\Events\UserSubscribed;
use App\Models\SubscribedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribedUserController extends Controller
{
    public function subscribe(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribed_users,email|max:255'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'code' => 400,
                'response' => $validation->errors()->toArray()
            ]);
        }

        event(new UserSubscribed($request->email));

        return response()->json([
            'code' => 200,
            'response' => "Successfully subscribed! Check your email"
        ]);
    }

    public function list()
    {
        $emails = SubscribedUser::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.pages.subscribed-users.index', compact('emails'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
