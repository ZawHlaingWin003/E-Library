@extends('dashboard.layouts.app')

@section('title', 'Subscribed Emails List')

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="#"><i class="fa fa-envelope-open"></i> Send Notification</a>

        <div class="table-responsive">
            @if (Session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            <table class="no-wrap table">
                <thead>
                    <tr>
                        <th class="border-top-0">#</th>
                        <th class="border-top-0">Emails</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscribedUsers as $user)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td class="txt-oflo">{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $subscribedUsers->links() }}
        </div>
    </div>

@endsection
