@extends('auth.otp-layout')

@section('title', 'Password Baru')

@section('heading', 'Buat Password Baru')

@section('description')
    Verifikasi berhasil. Silakan masukkan password baru
    untuk akun RAPI-Sekolah kamu.
@endsection

@section('content')

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <div class="form-group">
            <label for="password">Password Baru</label>

            <input
                id="password"
                type="password"
                name="password"
                class="form-input"
                placeholder="Masukkan password baru"
                minlength="8"
                required
                autocomplete="new-password"
            >
        </div>

        <div class="form-group">
            <label for="password_confirmation">
                Konfirmasi Password Baru
            </label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-input"
                placeholder="Ulangi password baru"
                minlength="8"
                required
                autocomplete="new-password"
            >
        </div>

        <button type="submit" class="login-button">
            Simpan Password Baru
        </button>

    </form>

@endsection