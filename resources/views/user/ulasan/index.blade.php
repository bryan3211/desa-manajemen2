@extends('layouts.dashboard')

@section('title', 'Ulasan Saya')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ulasan Saya</h5>
                <a href="{{ route('user.ulasan.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Tambah Ulasan
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($reviews->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Pesan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                    <tr>
                                        <td>{{ $review->user->name }}</td>
                                        <td>{{ str_repeat('⭐', $review->rating) }} ({{ $review->rating }})</td>
                                        <td>{{ Str::limit($review->comment, 50) }}</td>
                                        <td>
                                            @if($review->is_approved)
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-warning">Menunggu</span>
                                            @endif
                                        </td>
                                        <td>{{ $review->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('user.ulasan.edit', $review) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form action="{{ route('user.ulasan.destroy', $review) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $reviews->links() }}
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-message-circle-off display-1 text-muted"></i>
                        <h4 class="mt-3">Belum ada ulasan</h4>
                        <p class="text-muted">Anda belum membuat ulasan apapun.</p>
                        <a href="{{ route('user.ulasan.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Buat Ulasan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection