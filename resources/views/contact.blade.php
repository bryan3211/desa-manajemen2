@extends('layouts.landing')

@section('title', 'Hubungi Kami')

@section('content')

    <header class="contact-hero"
        style="position: relative; padding: 100px 0; background: url('{{ asset('assets/images/my/desa-sid.png') }}') no-repeat center center; background-size: cover;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5);"></div>
        <div class="container">
            <div class="row justify-content-center text-center text-light">
                <div class="col-md-8 col-lg-6">
                    <h1 class="text-white display-4">Hubungi <span class="text-primary">Kami</span></h1>
                    <p class="text-white-75 lead">
                        Silakan hubungi kami untuk pertanyaan, informasi, atau bantuan lebih lanjut terkait layanan
                        administrasi desa, pengajuan surat, dan informasi masyarakat.
                    </p>
                </div>
            </div>
        </div>
    </header>

    <section class="contact-form">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-10 col-xl-5 mb-4">
                    <h5 class="text-primary mb-0">Tetap Terhubung</h5>
                    <h2 class="my-3">Kirim Pesan Anda</h2>
                    <p class="text-muted">Kami siap membantu menjawab setiap pertanyaan Anda terkait layanan desa, pengajuan surat, dan informasi masyarakat. Silakan isi formulir di bawah ini.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-md-8 col-sm-10">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" value="kelmedaeng@gmail.com" readonly style="background-color: #f8f9fa; cursor: not-allowed;">
                                <small class="text-muted">Email akan dikirim ke: kelmedaeng@gmail.com</small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Subjek Pesan" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <textarea name="message" class="form-control form-control-lg @error('message') is-invalid @enderror" rows="4" placeholder="Tuliskan pesan Anda di sini..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-check mt-3 text-start">
                            <input class="form-check-input" type="checkbox" value="1" id="privacy" name="privacy" required>
                            <label class="form-check-label" for="privacy">
                                Saya setuju dengan <a href="#" class="link-primary"> Kebijakan Privasi</a>.
                            </label>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
