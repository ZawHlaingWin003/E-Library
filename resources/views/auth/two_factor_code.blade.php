@extends('frontend.layouts.app')

@section('title', '2FA Login')

@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-5">
                        <div class="card-header">{{ __('2FA Verification') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('2fa.store') }}">
                                @csrf
                                {{-- <p class="text-center">We sent code to your phone :
                                    {{ substr(auth()->user()->phone, 0, 5) . '******' . substr(auth()->user()->phone, -2) }}
                                </p> --}}

                                @if ($message = session('success'))
                                    <p class="alert alert-success">{{ $message }}</p>
                                @endif

                                @if ($message = session('status'))
                                    <p class="alert alert-success">{{ $message }}</p>
                                @endif

                                @if ($message = session('error'))
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @endif

                                <div class="row mb-3">
                                    <label for="code"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Verification Code') }}</label>

                                    <div class="col-md-6">
                                        <input id="code" type="text"
                                            class="form-control @error('two_factor_code') is-invalid @enderror"
                                            name="two_factor_code" value="{{ old('two_factor_code') }}" autofocus>

                                        @error('two_factor_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Verify') }}
                                        </button>

                                        <a class="btn btn-link" href="{{ route('2fa.resend') }}">
                                            {{ __('Resend Code') }}
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
