<?php

namespace App\Http\Controllers;

use App\Models\TwoFactorCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class TwoFactorCodeController extends Controller
{
    public function index()
    {
        return view('auth.two_factor_code');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required'
        ]);

        $user = auth()->user();

        if ($user->twoFactorCode->two_factor_code !== request()->two_factor_code) {
            throw ValidationException::withMessages([
                'two_factor_code' => 'Please enter the right verification code!'
            ]);
        }

        $user->resetTwoFactorCode();

        return redirect()->to(RouteServiceProvider::HOME);
    }

    public function resend()
    {
        auth()->user()->generateTwoFactorCode();

        return back()->with('success', 'We\'ve been resent code to your email');
    }
}
