@extends('auth.otp-layout')

@section('title', 'Verifikasi OTP')

@section('heading', 'Verifikasi OTP')

@section('description')
    Masukkan kode OTP 6 digit yang telah dikirimkan ke email kamu.
@endsection

@section('content')

    <div class="email-note">
        Kode OTP dikirim ke:<br>
        <strong>{{ $email }}</strong>
    </div>

    <form method="POST" action="{{ route('password.otp.verify') }}">
        @csrf

        <div class="form-group">
            <label for="otp">Kode OTP</label>

            <input
                id="otp"
                type="text"
                name="otp"
                class="form-input"
                placeholder="Masukkan 6 digit OTP"
                maxlength="6"
                pattern="[0-9]{6}"
                inputmode="numeric"
                autocomplete="one-time-code"
                required
                autofocus
            >
        </div>

        <button type="submit" class="login-button">
            Verifikasi OTP
        </button>
    </form>

    <div class="extra-link">
        <a href="{{ route('password.request') }}">
            Kembali ke halaman lupa password
        </a>
    </div>

@endsection