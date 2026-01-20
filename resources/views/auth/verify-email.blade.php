@extends('layouts.auth')

@section('title', 'Verifikasi Email')

@section('content')
    @include('auth._theme')

    <style>
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

        .container {
            z-index: 1;
            position: relative;
            padding: 2rem 1rem;
        }

        .otp-input {
            border-radius: 12px !important;
            border: 2px solid #e5e7eb !important;
            font-size: 20px;
            height: 50px;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            border-color: #1ba34a !important;
            box-shadow: 0 0 0 3px rgba(27, 163, 74, 0.1) !important;
            background: #ffffff;
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
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(27, 163, 74, 0.3);
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

        /* Mobile Responsive */
        @media (max-width: 576px) {
            .auth-card {
                border-radius: 20px !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                margin: 1rem;
            }

            .container {
                padding: 1rem 0.5rem;
            }

            .auth-card {
                padding: 1.5rem !important;
            }

            .auth-card .card-body {
                padding: 0 !important;
            }

            h3 {
                font-size: 1.3rem;
            }

            p {
                font-size: 0.9rem;
            }

            .row {
                gap: 0.5rem;
            }

            .col {
                padding: 0.25rem;
            }

            .otp-input {
                font-size: 18px;
                height: 48px;
                border-radius: 10px;
            }

            .btn-primary {
                height: 48px;
                font-size: 0.95rem;
                margin-top: 1rem;
            }

            .d-flex {
                flex-direction: column;
                gap: 0.5rem;
            }

            .small {
                font-size: 0.85rem;
            }

            .btn-link {
                font-size: 0.85rem;
            }

            .alert {
                font-size: 0.9rem;
                padding: 0.75rem 1rem;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 768px) {
            .auth-card {
                padding: 2rem !important;
                max-width: 100%;
                margin: 1rem auto;
            }

            .container {
                padding: 1.5rem 0.5rem;
            }

            .otp-input {
                height: 48px;
                font-size: 18px;
            }

            .btn-primary {
                height: 50px;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 1.25rem !important;
                border-radius: 16px !important;
                margin: 0.75rem;
            }

            h3 {
                font-size: 1.1rem;
            }

            .otp-input {
                height: 46px;
                font-size: 16px;
            }

            .row {
                gap: 0.35rem;
            }

            .btn-primary {
                height: 46px;
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="container">
        <div class="auth-card small my-5 p-4">
            <form method="POST" action="{{ Auth::check() ? route('verify.otp.auth') : route('verify.otp') }}">
                @csrf
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="mb-2"><b>Verifikasi Email</b></h3>
                        @if (session('verify_email'))
                            <p class="text-muted">Masukkan kode OTP yang telah dikirim ke:</p>
                            <p class="mb-0 fw-bold">{{ session('verify_email') }}</p>
                        @endif
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row text-center">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="col">
                                <input type="text" maxlength="1" class="form-control text-center otp-input"
                                    style="font-size:20px; height: 50px;" name="otp[]" required autofocus>
                            </div>
                        @endfor
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Verifikasi OTP</button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0 small">Tidak menerima OTP?</p>
                        <form action="{{ Auth::check() ? route('send.otp.auth') : route('send.otp') }}" method="POST" id="resendForm" class="d-inline">
                            @csrf
                            <button style="font-size:12px;" type="submit" id="resendBtn" class="btn btn-link p-0"
                                {{ $cooldown > 0 ? 'disabled' : '' }}>
                                {{ $cooldown > 0 ? 'Kirim ulang (' . $cooldown . 's)' : 'Kirim Ulang' }}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle OTP input
        const inputs = document.querySelectorAll(".otp-input");
        inputs.forEach((input, index) => {
            input.addEventListener("input", (e) => {
                e.target.value = e.target.value.replace(/[^0-9]/g, "");
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener("paste", (e) => {
                e.preventDefault();
                const pasteData = (e.clipboardData || window.clipboardData).getData("text");
                const digits = pasteData.replace(/[^0-9]/g, "").split("");
                digits.forEach((digit, i) => {
                    if (i < inputs.length) {
                        inputs[i].value = digit;
                    }
                });
                const filledIndex = Math.min(digits.length, inputs.length) - 1;
                if (filledIndex >= 0) inputs[filledIndex].focus();
            });
        });

        // Combine OTP before submit
        document.querySelector("form").addEventListener("submit", function(e) {
            e.preventDefault();
            let otpValue = "";
            inputs.forEach(input => otpValue += input.value);
            let hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "otp";
            hiddenInput.value = otpValue;
            this.appendChild(hiddenInput);
            this.submit();
        });

        // Countdown timer
        let cooldown = {{ $cooldown }};
        const resendBtn = document.getElementById("resendBtn");
        const resendForm = document.getElementById("resendForm");
        const setResendOtp = {{ $timeResendOtp }};

        if (cooldown > 0) {
            let countdown = setInterval(() => {
                cooldown--;
                if (cooldown <= 0) {
                    clearInterval(countdown);
                    resendBtn.disabled = false;
                    resendBtn.textContent = "Kirim Ulang";
                } else {
                    resendBtn.textContent = "Kirim ulang (" + cooldown + "s)";
                }
            }, 1000);
        }
    });
    </script>
@endsection