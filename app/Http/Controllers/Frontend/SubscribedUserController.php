<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UserSubscribed;
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
}
