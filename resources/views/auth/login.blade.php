@extends('layouts.app')

@section('title', 'Login - Absensi Guru')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="text-center mb-1">Absensi Guru</h4>
                <p class="text-center text-muted mb-4">Silakan masuk ke akun Anda</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>

                <hr class="my-4">
                <small class="text-muted">
                    <strong>Demo:</strong><br>
                    Admin: admin@sekolah.test / password<br>
                    Guru: budi@sekolah.test / password
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
