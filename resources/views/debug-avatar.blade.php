@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Debug Avatar</h5>
        </div>
        <div class="card-body">
            <h6>User Info:</h6>
            <ul>
                <li><strong>Name:</strong> {{ $user->name }}</li>
                <li><strong>Provider:</strong> {{ $user->provider ?? 'local' }}</li>
                <li><strong>Avatar DB:</strong> {{ $user->avatar }}</li>
                <li><strong>Avatar Variable:</strong> {{ $avatar }}</li>
            </ul>

            <h6 class="mt-4">Avatar Preview:</h6>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Using $avatar variable:</strong></p>
                    <img src="{{ $avatar }}" alt="Avatar" style="width: 100px; height: 100px; border: 2px solid red;">
                    <p><small>{{ $avatar }}</small></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Using asset() directly:</strong></p>
                    <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="Avatar" style="width: 100px; height: 100px; border: 2px solid blue;">
                    <p><small>{{ asset('assets/images/user/avatar-1.jpg') }}</small></p>
                </div>
            </div>

            <h6 class="mt-4">Network Check:</h6>
            <p>Buka Developer Tools (F12) → Network tab dan lihat apakah gambar loading atau error 404</p>
        </div>
    </div>
</div>
@endsection
