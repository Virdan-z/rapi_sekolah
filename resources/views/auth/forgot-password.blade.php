@extends('auth.otp-layout')

@section('title', 'Lupa Password')

@section('heading', 'Lupa Password?')

@section('description')
    Masukkan alamat email yang sudah terdaftar.
    Kami akan mengirimkan kode OTP untuk mereset password kamu.
@endsection

@section('content')

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">Alamat Email</label>

            <input
                id="email"
                type="email"
                name="email"
                class="form-input"
                value="{{ old('email') }}"
                placeholder="Masukkan alamat email"
                required
                autofocus
            >
        </div>

        <button type="submit" class="login-button">
            Kirim Kode OTP
        </button>
    </form>

    <div class="extra-link">
        <a href="{{ route('login') }}">
            Kembali ke Login
        </a>
    </div>

@endsection