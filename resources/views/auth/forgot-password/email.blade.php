@extends('layouts.auth')

@section('title', 'Forgot Your Password ?')

@section('content')

    <div class="card my-5">
        <form method="POST" action="{{ route('forgot_password.send_link') }}">
            @csrf
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="mb-0"><b>Forgot Password</b></h3>
                    <a href="{{ route('login') }}" class="link-primary">Back to Login</a>
                </div>


                @if ($errors->any())
                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach

                    </div>

                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email Address"
                        autocomplete="off" autofocus required>
                </div>
                <p class="mt-4 text-sm text-muted">Do not forgot to check SPAM box.</p>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Send OTP</button>
                </div>
            </div>
        </form>
    </div>
@endsection
