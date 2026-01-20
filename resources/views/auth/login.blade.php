@extends('layouts.auth')

@section('title', 'Login - Desa Digital')

@section('content')
@include('auth._theme')

<style>
    body {
        background: linear-gradient(135deg, #0f7938 0%, #1ba34a 50%, #0d5c2f 100%) !important;
        position: relative;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.03)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,133.3C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') repeat;
        pointer-events: none;
        z-index: 0;
    }

    .auth-card {
        border-radius: 24px !important;
        background: #ffffff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: none;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #1ba34a 0%, #0f7938 100%);
    }

    .auth-card::after {
        content: '';
        position: absolute;
        top: -1px;
        right: -1px;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, rgba(27, 163, 74, 0.1) 0%, transparent 70%);
        border-radius: 0 24px 0 100%;
        pointer-events: none;
    }

    .form-control {
        border-radius: 12px !important;
        border: 2px solid #e5e7eb !important;
        background: #f9fafb;
        height: 50px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #1ba34a !important;
        box-shadow: 0 0 0 3px rgba(27, 163, 74, 0.1) !important;
        background: #ffffff;
    }

    .form-label {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
        margin-bottom: 0.6rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%) !important;
        border: none !important;
        font-weight: 700;
        height: 56px;
        border-radius: 12px;
        font-size: 1.05rem;
        box-shadow: 0 10px 30px rgba(27, 163, 74, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.3s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(27, 163, 74, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .text-muted {
        color: #6b7280 !important;
    }

    .link-primary {
        color: #1ba34a !important;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .link-primary:hover {
        color: #0f7938 !important;
        text-decoration: underline;
    }

    .header-section {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 2;
    }

    .header-section h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .header-section small {
        color: #6b7280;
        font-size: 1rem;
    }

    .alert {
        border-radius: 12px;
        border: none;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .checkbox-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    .form-check {
        display: flex;
        align-items: center;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        margin-right: 0.6rem;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .form-check-input:checked {
        background-color: #1ba34a;
        border-color: #1ba34a;
    }

    .form-check-label {
        cursor: pointer;
        user-select: none;
    }

    .separator {
        text-align: center;
        margin: 2rem 0;
        position: relative;
    }

    .separator::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 1px;
        top: 50%;
        left: 0;
        background: #e5e7eb;
    }

    .separator span {
        background: #ffffff;
        padding: 0 1rem;
        color: #6b7280;
        font-size: 0.95rem;
        font-weight: 500;
        position: relative;
    }

    .sso-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 16px;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        color: #1f2937;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .sso-btn:hover {
        background: #ffffff;
        border-color: #1ba34a;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27, 163, 74, 0.15);
        color: #1ba34a;
    }

    .footer-text {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.95rem;
        color: #6b7280;
    }

    .footer-text a {
        color: #1ba34a;
        font-weight: 600;
        text-decoration: none;
    }

    .footer-text a:hover {
        text-decoration: underline;
    }

    .container {
        z-index: 1;
        position: relative;
    }

    /* Mobile Responsive */
    @media (max-width: 576px) {
        body::before {
            display: none;
        }

        html, body {
            overflow-x: hidden;
        }

        .auth-card {
            border-radius: 20px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin: 1rem;
        }

        .auth-card::after {
            width: 100px;
            height: 100px;
        }

        .container {
            min-height: auto;
            padding: 1rem 0;
        }

        .auth-card {
            margin: 1.5rem 1rem;
        }

        .auth-card p {
            padding: 1.5rem;
        }

        .header-section {
            margin-bottom: 1.5rem;
        }

        .header-section h3 {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .header-section small {
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1rem !important;
        }

        .form-control {
            height: 48px;
            font-size: 16px !important;
            border-radius: 10px;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        .btn-primary {
            height: 50px;
            font-size: 1rem;
            box-shadow: 0 8px 20px rgba(27, 163, 74, 0.15);
            margin-top: 0.5rem;
        }

        .checkbox-group {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
            margin: 0.75rem 0;
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        .link-primary {
            font-size: 0.85rem;
        }

        .separator {
            margin: 1.5rem 0;
        }

        .separator span {
            padding: 0 0.75rem;
            font-size: 0.9rem;
            background: #ffffff;
        }

        .sso-btn {
            width: 100%;
            padding: 12px;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
            border-radius: 10px;
        }

        .footer-text {
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .footer-text a {
            color: #1ba34a;
            font-weight: 600;
        }

        .alert {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 10px;
        }

        .d-grid {
            gap: 0.5rem;
        }
    }

    @media (max-width: 768px) {
        .auth-card {
            padding: 2rem !important;
        }

        .header-section h3 {
            font-size: 1.6rem;
        }

        .form-control {
            font-size: 16px !important;
            height: 48px;
        }

        .btn-primary {
            height: 50px;
        }
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 1.5rem !important;
            border-radius: 16px !important;
            margin: 1rem 0.75rem !important;
        }

        .header-section h3 {
            font-size: 1.3rem;
        }

        .header-section small {
            font-size: 0.85rem;
        }

        .form-control {
            height: 46px;
            font-size: 16px !important;
        }

        .btn-primary {
            height: 48px;
            font-size: 0.95rem;
        }

        .checkbox-group {
            margin-bottom: 0.75rem;
        }

        .separator {
            margin: 1.25rem 0;
        }
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <div class="auth-card p-4 p-sm-5" style="width: 100%; max-width: 480px; margin: 1rem;">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="header-section">
                <h3>Masuk Sistem</h3>
                <small>Desa Digital Indonesia</small>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div class="mb-1">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-group mb-3">
                <label class="form-label">NIK</label>
                <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK 16 digit"
                    value="{{ session('registered_nik') ?? old('nik') }}"
                    maxlength="16" pattern="[0-9]{16}" autocomplete="off" required>
            </div>

            <div class="form-group mb-1">
                <label for="password" class="form-label">Kata Sandi</label>
                <input id="password" type="password" class="form-control" name="password"
                    placeholder="Masukkan Password" @if (session('registered_nik')) autofocus @endif required>
            </div>

            <div class="checkbox-group mt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <a href="{{ route('forgot_password.email_form') }}" class="link-primary small">Lupa Password?</a>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">
                Login
            </button>

            <div class="separator">
                <span>Atau masuk dengan</span>
            </div>

            @include('auth.sso')

            <div class="footer-text">
                Belum punya akun? 
                <a href="/register">Daftar sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection
