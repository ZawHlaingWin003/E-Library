@extends('dashboard.layouts.app')

@section('title', 'Import Excel File')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="card p-3">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <small>
                                <p class="alert alert-danger">* {{ $error }}</p>
                            </small>
                        @endforeach
                    @endif
                    <form action="{{ route('admin.admin-users.import') }}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <input class="form-control @error('admin_users') is-invalid @enderror" id="" name="admin_users" type="file">
                        </div>

                        <button class="btn btn-primary my-3" type="submit">Import Excel</button>
                        <a class="btn btn-danger my-3" href="{{ route('admin.admin-users.index') }}">Cancle</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
