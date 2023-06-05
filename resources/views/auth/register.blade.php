@extends('frontend.layouts.app')

@section('title', 'Register')

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
                    <p class="login-title"><strong>Create new account.</strong></p>
                    <form method="POST" action="{{ route('register') }}" class="my-4">
                        @csrf

                        @if ($message = session('status'))
                            <p class="alert alert-warning">{{ $message }}</p>
                        @endif

                        <x-form-group label="Username" class="mb-3" id="name-input-group">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </x-form-group>

                        <x-form-group label="Phone Number" class="mb-3" id="phone-input-group">
                            <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </x-form-group>

                        <x-form-group label="Email Address" class="mb-3" id="email-input-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </x-form-group>

                        <x-form-group label="Password" class="mb-3" id="password-input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </x-form-group>

                        <x-form-group label="Confirm Password" class="mb-3" id="password-confirm-input-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </x-form-group>

                        <x-main-button type="submit" class="mt-3" buttonId="register-button" iconName="fa-right-to-bracket"
                            iconId="register-button-icon" loaderId="register-button-loader">
                            Register
                        </x-main-button>
                    </form>
                    <div class="d-flex justify-content-between links">
                        <a href="{{ route('login') }}">Already have an account? Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
