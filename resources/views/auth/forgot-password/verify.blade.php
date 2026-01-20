@extends('layouts.auth')

@section('title', 'Verifikasi OTP Reset Password')

@section('content')
    <div class="card my-5">
        <form method="POST" action="{{ route('password.verify') }}">
            @csrf
            <div class="card-body">
                <div class="mb-4">
                    <h2 class="mb-4"><b>Verifikasi OTP</b></h2>
                    <div class="my-2">
                        <p class="mb-2">Masukkan kode OTP yang telah kami kirimkan ke email <strong>{{ $email }}</strong>.</p>
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
                    <input type="email" name="email" class="form-control" value="{{ $email }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">OTP Code</label>
                    <input type="text" name="otp" class="form-control" placeholder="6-digit OTP" maxlength="6" required>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Verifikasi OTP</button>
                </div>
            </div>
        </form>

        <div class="card-footer text-center">
            <small>Belum menerima OTP? <a href="{{ route('forgot_password.email_form') }}">Kirim ulang</a></small>
        </div>
    </div>
@endsection
