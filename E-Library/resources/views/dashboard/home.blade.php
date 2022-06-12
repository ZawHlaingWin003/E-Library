@extends('dashboard.layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 mt-5">
            <h1>
                Welcom To E-Library's Admin Dashboard
                <br />
                <span class="text-primary">
                    {{ auth()->guard('admin_user')->user()->name }}({{ auth()->guard('admin_user')->user()->email }})
                </span>
            </h1>
        </div>
    </div>
</div>
@endsection
