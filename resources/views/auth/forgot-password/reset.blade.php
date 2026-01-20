@extends('layouts.auth')

@section('title', 'Resetting Your Password ?')

@section('content')
    <div class="card my-5">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="card-body">
                <div class="mb-4">
                    <h2 class="mb-4"><b>Reset Password</b></h2>
                    <div class="my-2">
                        <p class="mb-2">Masukkan kode OTP yang telah kami kirimkan ke email Anda, lalu buat password baru.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach

                    </div>

                @endif

                <div class="form-group mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email"
                        value="{{ old('email', $email ?? ($user->email ?? '')) }}" required readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"
                        required>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
@endsection
