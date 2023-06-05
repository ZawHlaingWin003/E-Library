@extends('frontend.layouts.app')

@section('title', 'Login')

@section('custom_style')
    <style>
        .login-form {
            font-family: bodyRegularFont;
        }

        .login-form .login-title {
            text-align: center;
            font-size: 1.3rem;
            margin-bottom: 2rem;
            font-family: titleBoldFont;
            color: rgba(0, 0, 0, .6);
        }

        .login-form .navbar-brand {
            font-family: titleBoldFont;
            color: var(--primary-color);
            font-size: 1.5rem;
            display: block;
            text-align: center;
        }

        .login-form .links a {
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 border p-5 login-form">
                    <a class="navbar-brand" href="#"><i class="fas fa-book"></i> E-Library</a>
                    <p class="login-title"><strong>Please login to your account.</strong></p>
                    <form method="POST" action="{{ route('login') }}" class="my-4">
                        @csrf

                        @if ($message = session('error'))
                            <p class="alert alert-danger">{{ $message }}</p>
                        @endif

                        @if ($message = session('status'))
                            <p class="alert alert-warning">{{ $message }}</p>
                        @endif

                        <x-form-group label="Email Address" class="mb-3" id="email-input-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </x-form-group>

                        <x-form-group label="Password" class="mb-3" id="email-input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </x-form-group>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <x-main-button type="submit" class="mt-3" buttonId="login-button"
                            iconName="fa-right-to-bracket" iconId="login-button-icon" loaderId="login-button-loader">
                            Login
                        </x-main-button>
                    </form>
                    <div class="d-flex justify-content-between links">
                        <a href="{{ route('register') }}">Don't have an account? Create Account</a>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
